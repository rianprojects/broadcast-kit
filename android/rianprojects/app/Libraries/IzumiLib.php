<?php
namespace App\Libraries;

/** Client ke API toko izumistore.web.id sendiri — dipakai buat ambil QRIS, bukan integrasi TriPay baru. */
class IzumiLib
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(env('izumi.apiUrl'), '/');
    }

    public function getPaymentChannels(): array
    {
        $result = $this->request('GET', '/api/payment-channels');
        return $result['data'] ?? [];
    }

    /** sku 'REG-RL' = nominal bebas (lihat api.php), jadi tidak perlu produk terdaftar di izumistore. */
    public function createTransaction(string $merchantRef, int $amount, string $productName, string $email, string $paymentMethod): array
    {
        return $this->request('POST', '/api/products/buy', [
            'sku'            => 'REG-RL',
            'amount'         => $amount,
            'product_name'   => $productName,
            'email'          => $email,
            'telegram_id'    => $merchantRef,
            'merchant_ref'   => $merchantRef,
            'payment_method' => $paymentMethod,
            'use_balance'    => false,
        ]);
    }

    public function checkStatus(string $merchantRef): ?string
    {
        $result = $this->request('GET', '/api/api/transaksi/status/' . $merchantRef);
        return $result['status'] ?? null;
    }

    private function request(string $method, string $path, array $body = []): array
    {
        $ch = curl_init($this->baseUrl . $path);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['success' => false, 'message' => $error];
        }

        return json_decode($response, true) ?? ['success' => false, 'message' => 'Invalid response'];
    }
}
