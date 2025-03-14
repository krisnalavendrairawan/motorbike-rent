<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    private $title = 'Transaction';
    private $icon = 'bx bxs-credit-card';

    protected $midtransService;
    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }
    public function index()
    {
        $transactions = Transaction::with(['rental.motor', 'rental.customer'])
            ->whereHas('rental', function ($query) {
                $query->where('customer_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('frontend.transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->rental->customer_id !== auth()->id()) {
            abort(403);
        }

        try {
            if ($transaction->status === 'pending' && empty($transaction->snap_token)) {
                $snapToken = $this->midtransService->createTransaction($transaction);
                $transaction->update(['snap_token' => $snapToken]);
                $transaction->refresh();
            }

            return view('frontend.transaction.show', compact('transaction'));
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment system error: ' . $e->getMessage());
        }
    }

    public function notification(Request $request)
    {
        $payload = $request->all();

        $signatureKey = $payload['signature_key'];
        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];

        $transaction = Transaction::where('order_id', $orderId)->firstOrFail();

        $validSignatureKey = hash(
            'sha512',
            $orderId . $statusCode . $grossAmount . config('midtrans.server_key')
        );

        if ($signatureKey !== $validSignatureKey) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        switch ($payload['transaction_status']) {
            case 'capture':
            case 'settlement':
                $transaction->update(['status' => 'paid']);
                $transaction->rental->update(['status' => 'rent']);
                break;
            case 'cancel':
            case 'deny':
            case 'expire':
                $transaction->update(['status' => 'failed']);
                $transaction->rental->update(['status' => 'failed']);
                break;
        }

        return response()->json(['message' => 'Notification handled']);
    }

    public function updatePaymentStatus(Request $request, $orderId)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaction::where('order_id', $orderId)->firstOrFail();

            $transaction->update(['status' => 'paid']);

            $transaction->rental->update(['status' => 'rent']);

            $transaction->rental->motor->update(['status' => 'not_ready']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment status update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error updating payment status'
            ], 500);
        }
    }

    public function detailTransaction(Transaction $transaction)
    {
        $transaction = Transaction::with(['rental.motor', 'rental.customer'])->findOrFail($transaction->id);

        if (!$transaction->rental) {
            return redirect()->back()->with('error', 'Rental data not found');
        }

        return view('frontend.transaction.detail', compact('transaction'));
    }
}
