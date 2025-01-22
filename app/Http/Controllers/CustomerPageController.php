<?php

namespace App\Http\Controllers;

use App\Helpers\Common;
use App\Http\Requests\RentalRequest;
use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Brand;
use App\Models\Rental;
use App\Models\Transaction;
use App\Models\User;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerPageController extends Controller
{
    private $title = 'Landing';
    private $icon = '';
    private $path = 'frontend.landing.';

    public function index()
    {
        $users = User::all();
        $userCount = count($users);
        $customerCount = User::role('customer')->count();
        $staffCount = User::role('admin')->count();
        $motorCount = Motor::count();

        $motor = Motor::with('brand')
            ->where('status', 'ready')
            ->paginate(3);

        if (request()->ajax()) {
            return response()->json([
                'html' => view('frontend.landing.vehicle-cards', compact('motor'))->render(),
                'lastPage' => $motor->lastPage()
            ]);
        }

        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'users' => $users,
            'userCount' => $userCount,
            'customerCount' => $customerCount,
            'motorCount' => $motorCount,
            'staffCount' => $staffCount,
            'motor' => $motor,
            'totalPages' => $motor->lastPage()
        ]);
    }


    public function catalog(Request $request)
    {
        $query = Motor::query()->with('brand');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }
        $motors = $query->paginate(9);
        $brands = Brand::all();
        $types = Common::option('bike_type');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.catalog.vehicle-cards', compact('motors'))->render(),
                'lastPage' => $motors->lastPage()
            ]);
        }

        return view('frontend.catalog.catalog', compact('motors', 'brands', 'types'));
    }

    public function show($id)
    {
        $motor = Motor::findOrFail($id);
        $type = Common::option('bike_type');

        $brand = Brand::all();
        return view('frontend.catalog.detail', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brand' => $brand,
            'type' => $type,
            'motor' => $motor,

        ]);
    }

    public function createRental($id)
    {
        $motor = Motor::findOrFail($id);
        $payment_type = Common::option('payment_type');

        if ($motor->status !== 'ready') {
            return redirect()->route('catalog.index')
                ->with('error', 'Motor is not available for rental');
        }

        return view('frontend.rental.create', [
            'motor' => $motor,
            'payment_type' => $payment_type,
        ]);
    }

    public function store(RentalRequest $request)
    {
        try {
            DB::beginTransaction();

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            if ($startDate->isPast()) {
                throw new \Exception('Start date cannot be in the past');
            }

            if ($endDate->isBefore($startDate)) {
                throw new \Exception('End date must be after start date');
            }

            $motor = Motor::findOrFail($request->motor_id);

            $conflictingRentals = Rental::where('motor_id', $motor->id)
                ->whereIn('status', ['rent', 'pending'])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                        });
                })
                ->exists();

            $totalDays = $startDate->diffInDays($endDate);
            if ($totalDays < 1) {
                $totalDays = 1;
            }

            $expectedPrice = $motor->price * $totalDays;

            $rental = Rental::create([
                'customer_id' => $request->customer_id,
                'motor_id' => $request->motor_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_price' => $request->total_price,
                'payment_type' => $request->payment_type,
                'description' => $request->description,
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            $orderId = 'RNT-' . date('Ymd') . '-' . str_pad($rental->id, 4, '0', STR_PAD_LEFT);

            $transaction = Transaction::create([
                'rental_id' => $rental->id,
                'status' => 'pending',
                'payment_type' => $rental->payment_type,
                'order_id' => $orderId,
                'transaction_time' => now(),
                'snap_token' => null
            ]);

            // Generate Snap Token jika metode pembayaran adalah QRIS atau Transfer
            if (in_array($request->payment_type, ['qris', 'Transfer'])) {
                $midtransService = app(MidtransService::class);
                $snapToken = $midtransService->createTransaction($transaction);
                $transaction->update(['snap_token' => $snapToken]);
            }

            DB::commit();

            return redirect()->route('transaction.index')
                ->with('success', 'Rental request submitted successfully. Please complete your payment.');
        } catch (\Exception $e) {
            DB::rollBack(); 
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
