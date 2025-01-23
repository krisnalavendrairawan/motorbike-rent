<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnRequest;
use App\Models\Rental;
use App\Models\Returns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class ReturnController extends Controller
{
    private $title = 'Return';
    private $icon = 'bx bxs-credit-card';
    private $path = 'backend.return.';

    public function index()
    {
        $rental = Rental::all();
        $rentalCount = count($rental);
        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
            'rental' => $rental,
            'rentalCount' => $rentalCount,
        ]);
    }

    public function show($id)
    {
        $return = Returns::with(['rental.customer', 'rental.motor'])->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $return
        ]);
    }

    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $returns = Returns::with(['rental.customer', 'rental.motor'])
            ->select('return.*');

        $returns_count = $returns->count();

        $returns_filter = $returns->where(function ($query) use ($search) {
            $query->whereHas('rental.customer', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
                ->orWhereHas('rental.motor', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('image', 'like', '%' . $search . '%');
                })
                ->orWhere('return.return_date', 'like', '%' . $search . '%')
                ->orWhere('return.status', 'like', '%' . $search . '%');
        });

        $returns_count_filter = $returns_filter->count();
        $returns_data = $returns_filter->limit($limit)
            ->offset($start)
            ->orderBy('return.created_at', 'desc')
            ->get();

        $returns_arr = [];
        foreach ($returns_data as $return) {
            $push = $return->toArray();
            $push['encrypted_id'] = $return->encrypted_id;
            $push['customer_name'] = $return->rental->customer->name ?? 'N/A';
            $push['motor_name'] = $return->rental->motor->name ?? 'N/A';
            $push['motor_image'] = $return->rental->motor->image ?? 'N/A';
            $push['total_price'] = 'Rp ' . number_format($return->rental->total_price, 0, ',', '.');
            $push['formatted_return_date'] = \Carbon\Carbon::parse($return->return_date)->isoFormat('D MMMM Y HH:mm');
            array_push($returns_arr, $push);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $returns_count,
            'recordsFiltered' => $returns_count_filter,
            'data' => $returns_arr
        ];

        return response()->json($response);
    }

    public function store(ReturnRequest $request)
    {
        try {
            DB::beginTransaction();

            $rental_id = $request->rental_id;

            $return = Returns::create([
                'rental_id' => $rental_id,
                'return_date' => $request->return_date ?? now(),
                'status' => 'finished'
            ]);

            $rental = Rental::with('motor')->findOrFail($rental_id);
            $rental->update(['status' => 'finished']);

            $rental->motor->update(['status' => 'ready']);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Rental has been completed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        $query = Returns::with(['rental.customer', 'rental.motor'])
        ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filter_type === 'date') {
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('return_date', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            }
        } else if ($request->filter_type === 'month') {
            if ($request->month) {
                $date = Carbon::createFromFormat('Y-m', $request->month);
                $query->whereYear('return_date', $date->year)
                ->whereMonth('return_date', $date->month);
            }
        }

        $returns = $query->get()
        ->map(function ($return) {
            return [
                'customer_name' => $return->rental->customer->name ?? 'N/A',
                'motor_name' => $return->rental->motor->name ?? 'N/A',
                'return_date' => Carbon::parse($return->return_date)->isoFormat('D MMMM Y HH:mm'),
                'total_price' => 'Rp ' . number_format($return->rental->total_price, 0, ',', '.'),
                'status' => $return->status === 'finished' ? 'Selesai' : 'Disewa'
            ];
        });

        $pdf = PDF::loadView('backend.return.pdf', [
            'returns' => $returns,
            'title' => $this->title,
            'date' => Carbon::now()->isoFormat('D MMMM Y HH:mm'),
            'filter_info' => $this->getFilterInfo($request),
            'has_data' => $returns->count() > 0
        ]);

        return $pdf->download('returns-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    private function getFilterInfo(Request $request)
    {
        if ($request->filter_type === 'date') {
            if ($request->start_date && $request->end_date) {
                return 'Periode: ' . Carbon::parse($request->start_date)->isoFormat('D MMMM Y') .
                    ' - ' . Carbon::parse($request->end_date)->isoFormat('D MMMM Y');
            }
        } else if ($request->filter_type === 'month') {
            if ($request->month) {
                return 'Periode: ' . Carbon::createFromFormat('Y-m', $request->month)->isoFormat('MMMM Y');
            }
        }
        return 'Semua Periode';
    }
}
