<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.mode') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createSnapUrl(string $orderId, float $amount, string $customerName, string $customerEmail, ?string $customerPhone = null, ?string $finishRedirectUrl = null): array
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $customerEmail,
                'phone' => $customerPhone ?? '',
            ],
        ];

        if ($finishRedirectUrl) {
            $params['callbacks'] = [
                'finish' => $finishRedirectUrl,
            ];
        }

        $snap = Snap::createTransaction($params);

        return [
            'redirect_url' => $snap->redirect_url,
            'token' => $snap->token,
        ];
    }

    public function handleNotification(): object
    {
        return new Notification();
    }
}
