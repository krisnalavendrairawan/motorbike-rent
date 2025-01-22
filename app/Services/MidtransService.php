<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Add debug logging
        Log::info('Midtrans Config:', [
            'serverKey' => Config::$serverKey,
            'isProduction' => Config::$isProduction
        ]);
    }

    public function createTransaction($transaction)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => (int)$transaction->rental->total_price,
            ],
            'customer_details' => [
                'first_name' => $transaction->rental->customer->name,
                'email' => $transaction->rental->customer->email,
                'phone' => $transaction->rental->customer->phone ?? '',
            ],
            'item_details' => [
                [
                    'id' => $transaction->rental->motor->id,
                    'price' => (int)$transaction->rental->total_price,
                    'quantity' => 1,
                    'name' => $transaction->rental->motor->name,
                ]
            ],
            'enable_payments' => ['credit_card', 'transfer', 'gopay', 'qris'],
            'credit_card' => [
                'secure' => true,
                'channel' => 'migs',
            ],
        ];

        try {
            Log::info('Midtrans Request Params:', $params);
            $token = Snap::createTransaction($params)->token;
            Log::info('Midtrans Token Generated:', ['token' => $token]);
            return $token;
        } catch (\Exception $e) {
            Log::error('Midtrans Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
