<?php

namespace App\Libraries;

class RazorpayClient
{
    private string $keyId;

    private string $keySecret;

    public function __construct(?string $keyId = null, ?string $keySecret = null)
    {
        $this->keyId = trim((string) ($keyId ?? env('razorpay.keyId') ?? ''));
        $this->keySecret = trim((string) ($keySecret ?? env('razorpay.keySecret') ?? ''));
    }

    public function isConfigured(): bool
    {
        return $this->keyId !== '' && $this->keySecret !== '';
    }

    public function keyId(): string
    {
        return $this->keyId;
    }

    /**
     * @param array<string, string> $notes
     * @return array<string, mixed>
     */
    public function createOrder(int $amountPaise, string $receipt, array $notes = []): array
    {
        return $this->request('POST', 'https://api.razorpay.com/v1/orders', [
            'amount'   => $amountPaise,
            'currency' => 'INR',
            'receipt'  => substr($receipt, 0, 40),
            'notes'    => $notes,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function fetchPayment(string $paymentId): array
    {
        return $this->request('GET', 'https://api.razorpay.com/v1/payments/' . rawurlencode($paymentId));
    }

    /**
     * @return array<string, mixed>
     */
    public function capturePayment(string $paymentId, int $amountPaise): array
    {
        return $this->request('POST', 'https://api.razorpay.com/v1/payments/' . rawurlencode($paymentId) . '/capture', [
            'amount'   => $amountPaise,
            'currency' => 'INR',
        ]);
    }

    public function verifySignature(string $orderId, string $paymentId, string $signature): bool
    {
        if ($orderId === '' || $paymentId === '' || $signature === '' || $this->keySecret === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->keySecret);

        return hash_equals($expected, $signature);
    }

    /**
     * @param array<string, mixed>|null $payload
     * @return array<string, mixed>
     */
    private function request(string $method, string $url, ?array $payload = null): array
    {
        if (! $this->isConfigured()) {
            throw new \RuntimeException('Razorpay keys are not configured.');
        }

        $client = \Config\Services::curlrequest([
            'timeout' => 20,
        ]);

        $options = [
            'auth'        => [$this->keyId, $this->keySecret],
            'http_errors' => false,
            'headers'     => [
                'Accept' => 'application/json',
            ],
        ];

        if ($payload !== null) {
            $options['json'] = $payload;
        }

        $response = $client->request($method, $url, $options);
        $body = json_decode((string) $response->getBody(), true);
        $body = is_array($body) ? $body : [];
        $status = $response->getStatusCode();

        if ($status < 200 || $status >= 300) {
            $description = (string) ($body['error']['description'] ?? 'Razorpay request failed.');
            log_message('error', 'Razorpay ' . $method . ' ' . $url . ' failed (' . $status . '): ' . $description);

            throw new \RuntimeException($description);
        }

        return $body;
    }
}
