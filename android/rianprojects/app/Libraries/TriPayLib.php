<?php
namespace App\Libraries;

/** Minimal TriPay Payment Gateway client (closed transaction / merchant API v2). */
class TriPayLib
{
    private string $apiKey;
    private string $privateKey;
    private string $merchantCode;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('tripay.apiKey');
        $this->privateKey = env('tripay.privateKey');
        $this->merchantCode = env('tripay.merchantCode');
        $mode = env('tripay.mode', 'sandbox');
        $this->baseUrl = $mode === 'production'
            ? 'https://tripay.co.id/api'
            : 'https://tripay.co.id/api-sandbox';
    }

    public function getPaymentChannels(): array
    {
        $result = $this->request('GET', '/merchant/payment-channel');
        return $result['data'] ?? [];
    }

    public function createTransaction(array $data): array
    {
        $signature = hash_hmac(
            'sha256',
            $this->merchantCode . $data['merchant_ref'] . $data['amount'],
            $this->privateKey
        );
        $data['method'] = $data['method'];
        $data['merchant_code'] = $this->merchantCode;
        $data['signature'] = $signature;

        return $this->request('POST', '/transaction/create', $data);
    }

    public function verifyCallbackSignature(string $rawBody, string $callbackSignature): bool
    {
        $expected = hash_hmac('sha256', $rawBody, $this->privateKey);
        return hash_equals($expected, $callbackSignature);
    }

    private function request(string $method, string $path, array $body = []): array
    {
        $ch = curl_init($this->baseUrl . $path);
        $headers = ['Authorization: Bearer ' . $this->apiKey];

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
