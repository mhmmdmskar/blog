<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$clientKey = config('midtrans.clientKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }

    public function getSnapToken(array $params)
    {
        try {
            // Log sebelum mendapatkan Snap Token
            \Log::info('Mencoba mendapatkan Snap Token', $params);

            // Mendapatkan Snap Token
            $token = Snap::getSnapToken($params);

            // Log setelah mendapatkan Snap Token
            \Log::info('Snap Token berhasil didapatkan', ['snap_token' => $token]);

            return $token;
        } catch (\Exception $e) {
            // Log error jika gagal mendapatkan Snap Token
            \Log::error('Midtrans SnapToken Error: ' . $e->getMessage());
            return null;
        }
    }

    public function createPaymentLink(array $params)
    {
        return $this->getSnapToken($params); // Konsisten
    }
}
