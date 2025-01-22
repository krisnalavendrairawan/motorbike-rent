<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Brand;
use App\Models\Rental;
use App\Models\User;
use App\Helpers\Common;
use App\Http\Requests\RentalRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    private $title = 'Rental';
    private $icon = 'bx bxs-credit-card';
    private $path = 'backend.rental.';

    public function index(Request $request)
    {
        $query = Motor::query();
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('plate', 'like', "%{$request->search}%");
            });
        }

        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $motor = $query->paginate(9);
        $brands = Brand::all();
        $type = Common::option('bike_type');
        $motorCount = Motor::count();

        if ($request->ajax()) {
            return view($this->path . 'bike-grid', compact('motor'))->render();
        }

        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'motor' => $motor,
            'brands' => $brands,
            'motorCount' => $motorCount,
            'types' => $type,
        ]);
    }



    public function show($id)
    {
        $motor = Motor::findOrFail($id);
        $type = Common::option('bike_type');
        $brand = Brand::all();
        return view($this->path . 'show', [
            'title' => $this->title,
            'icon' => $this->icon,
            'brand' => $brand,
            'type' => $type,
            'motor' => $motor,
        ]);
    }

    public function showListRental()
    {
        $rental = Rental::all();
        $rentalCount = count($rental);
        return view($this->path . 'list-rent', [
            'title' => $this->title,
            'icon' => $this->icon,
            'rental' => $rental,
            'rentalCount' => $rentalCount,
        ]);
    }

    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $rental = Rental::with(['customer', 'motor'])
            ->select('id', 'customer_id', 'motor_id', 'start_date', 'end_date', 'status', 'payment_type', 'total_price');

        $rental_count = $rental->count();

        $rental_filter = $rental->where(function ($query) use ($search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
                ->orWhereHas('motor', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('image', 'like', '%' . $search . '%');
                })
                ->orWhere('rental.start_date', 'like', '%' . $search . '%')
                ->orWhere('rental.end_date', 'like', '%' . $search . '%')
                ->orWhere('rental.status', 'like', '%' . $search . '%')
                ->orWhere('rental.payment_type', 'like', '%' . $search . '%')
                ->orWhere('rental.total_price', 'like', '%' . $search . '%');
        });

        $rental_count_filter = $rental_filter->count();
        $rental_data = $rental_filter->limit($limit)
            ->offset($start)
            ->orderBy('rental.created_at', 'desc')
            ->get();

        $rental_arr = [];
        foreach ($rental_data as $u) {
            $push = $u->toArray();
            $push['encrypted_id'] = $u->encrypted_id;
            $push['customer_name'] = $u->customer ? $u->customer->name : 'N/A';
            $push['motor_name'] = $u->motor ? $u->motor->name : 'N/A';
            $push['motor_image'] = $u->motor ? $u->motor->image : 'N/A';
            $push['formatted_start_date'] = \Carbon\Carbon::parse($u->start_date)->isoFormat('D MMMM Y HH:mm');
            $push['formatted_end_date'] = \Carbon\Carbon::parse($u->end_date)->isoFormat('D MMMM Y HH:mm');
            $push['formatted_price'] = 'Rp ' . number_format($u->total_price, 0, ',', '.');
            $push['payment_type'] = $u->payment_type;
            array_push($rental_arr, $push);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $rental_count,
            'recordsFiltered' => $rental_count_filter,
            'data' => $rental_arr
        ];

        return response()->json($response);
    }

    public function create($motorId)
    {
        $motor = Motor::findOrFail($motorId);

        if ($motor->status !== 'ready') {
            return redirect()->route('rental.index')
                ->with('error', 'Motor is not available for rental');
        }

        $customers = User::role('customer')->get();

        if ($customers->isEmpty()) {
            return redirect()->route('rental.index')
                ->with('error', 'No customers available. Please add a customer first.');
        }

        return view(
            $this->path . 'create',
            [
                'title' => $this->title,
                'icon' => $this->icon,
                'motor' => $motor,
                'customers' => $customers,
            ]
        );;
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
                ->where('status', 'rent')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                        });
                })
                ->exists();

            if ($conflictingRentals) {
                throw new \Exception('Motor is already booked for these dates');
            }

            $totalDays = $startDate->diffInDays($endDate);
            if ($totalDays < 1) {
                $totalDays = 1; // Minimum 1 day rental
            }

            $expectedPrice = $motor->price * $totalDays;
            // if ($request->total_price != $expectedPrice) {
            //     throw new \Exception('Invalid total price calculation');
            // }

            $rental = Rental::create([
                'customer_id' => $request->customer_id,
                'motor_id' => $request->motor_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'total_price' => $request->total_price,
                'description' => $request->description,
                'status' => 'rent',
                'created_by' => auth()->id(),
            ]);

            $motor->update(['status' => 'not_ready']);

            DB::commit();

            return redirect()->route('list.rental')
                ->with('success', 'Rental created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function confirmPayment(Request $request)
    {
        try {
            DB::beginTransaction();

            $rental = Rental::findOrFail($request->rental_id);

            if ($rental->status !== 'pending' || $rental->payment_type !== 'cash') {
                throw new \Exception('Invalid rental status or payment type');
            }

            $rental->update([
                'status' => 'rent',
                'payment_confirmed_at' => now(),
                'payment_confirmed_by' => auth()->id()
            ]);

            $motor = Motor::findOrFail($rental->motor_id);
            $motor->update([
                'status' => 'not_ready'
            ]);

            $transaction = Transaction::where('rental_id', $rental->id)->firstOrFail();
            $transaction->update(['status' => 'paid']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Payment confirmed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
