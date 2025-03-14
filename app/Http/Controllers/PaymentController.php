<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Rental;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private $title = 'Pembayaran';
    private $icon = 'bx bxs-wallet';
    private $path = 'backend.payment.';

    public function index()
    {
        return view($this->path . 'index', [
            'title' => $this->title,
            'icon' => $this->icon,
        ]);
    }

    public function datatable(Request $request)
    {
        $search = $request->input('search')['value'];
        $limit = $request->input('length');
        $start = $request->input('start');

        $transactions = Transaction::with(['rental.motor', 'rental.customer'])
            ->select('transactions.*');

        $transaction_count = $transactions->count();

        $transaction_filter = $transactions->where(function ($query) use ($search) {
            $query->where('order_id', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('total_amount', 'like', '%' . $search . '%')
                ->orWhereHas('rental.customer', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('rental.motor', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
        });

        $transaction_count_filter = $transaction_filter->count();
        $transaction_data = $transaction_filter->limit($limit)
            ->offset($start)
            ->orderBy('created_at', 'desc')
            ->get();

        $transaction_arr = [];
        foreach ($transaction_data as $t) {
            if (!$t->rental) {
                continue; // Skip transactions with missing rental data
            }

            $push = $t->toArray();
            $push['id'] = $t->id;
            $push['order_id'] = $t->order_id;
            $push['rental_id'] = $t->rental_id;
            $push['customer_name'] = $t->rental->customer ? $t->rental->customer->name : 'N/A';
            $push['motor_name'] = $t->rental->motor ? $t->rental->motor->name : 'N/A';
            $push['motor_image'] = $t->rental->motor ? $t->rental->motor->image : 'N/A';
            $push['payment_type'] = $t->payment_type ?? 'cash';
            $push['formatted_total_amount'] = 'Rp ' . number_format($t->total_amount, 0, ',', '.');
            $push['payment_date'] = $t->transaction_time;
            $push['formatted_payment_date'] = $t->transaction_time ? \Carbon\Carbon::parse($t->transaction_time)->isoFormat('D MMMM Y HH:mm') : null;

            array_push($transaction_arr, $push);
        }

        $response = [
            'draw' => $request->input('draw'),
            'recordsTotal' => $transaction_count,
            'recordsFiltered' => $transaction_count_filter,
            'data' => $transaction_arr
        ];

        return response()->json($response);
    }

    public function confirm(Request $request)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::findOrFail($request->transaction_id);

            if ($transaction->status !== 'pending') {
                throw new \Exception('Invalid transaction status');
            }

            $transaction->update([
                'status' => 'paid',
                'transaction_time' => now()
            ]);

            $rental = Rental::findOrFail($request->rental_id);
            $rental->update([
                'status' => 'rent',
                'payment_confirmed_at' => now(),
                'payment_confirmed_by' => auth()->id()
            ]);

            $motor = Motor::findOrFail($rental->motor_id);
            $motor->update([
                'status' => 'not_ready'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment confirmed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment confirmation error: ' . $e->getMessage());
            Log::error('Error Trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
