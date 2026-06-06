<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function callback(Request $request): JsonResponse
    {
        $payload = $request->all();
        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (! $orderId || ! $transactionStatus) {
            Log::warning('Midtrans callback received with missing fields', $payload);
            return response()->json(['message' => 'Missing required fields'], 400);
        }

        if ($transactionStatus !== 'capture' && $transactionStatus !== 'settlement') {
            return response()->json(['message' => 'Transaction not completed, ignoring']);
        }

        if ($fraudStatus === 'deny') {
            Log::warning("Midtrans transaction denied for order_id: {$orderId}");
            return response()->json(['message' => 'Transaction denied'], 403);
        }

        $payment = Payment::query()->where('midtrans_order_id', $orderId)->first();

        if (! $payment) {
            Log::warning("Payment not found for Midtrans order_id: {$orderId}");
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $this->paymentService->completePayment($payment);

        return response()->json(['message' => 'OK']);
    }
}

