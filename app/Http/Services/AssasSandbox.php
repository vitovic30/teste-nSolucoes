<?php

namespace App\Http\Services;

class AssasSandbox {

    protected $uri = "https://sandbox.asaas.com/api/v3/customers";
    protected $access_token = '$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNjc3MTU6OiRhYWNoX2EzMjM1Yjg5LWM2NmQtNDVkZC05YTI2LTEyZjgxM2VhOTQ2YQ==';
    protected $client;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
    }
    public function newClient(array $payload)
    {
        $payload = ['name' => $payload['nome'], 'cpcpfCnpj' => $payload['cpf']];

        $response = $this->client->request('POST', $this->uri, [
            'body' => json_encode($payload),
            'headers' => [
                'accept' => 'application/json',
                'access_token' => $this->access_token,
                'content-type' => 'application/json',
            ],
        ]);

        $contents = $response->getBody()->getContents();

        return json_decode($contents);
    }

    public function createCharge(array $payload)
    {
        $payload = [
            'billingType' => $payload['billing_type'],
            'customer' => $payload['customer'],
            'value' => $payload['value'],
            'dueDate' => $payload['dueDate']
        ];

        $response = $this->client->request('POST', 'https://sandbox.asaas.com/api/v3/payments', [
            'body' => json_encode($payload),
            'headers' => [
                'accept' => 'application/json',
                'access_token' => $this->access_token,
                'content-type' => 'application/json',
            ],
        ]);

        $contents = $response->getBody()->getContents();

        return json_decode($contents);
    }
}

?>
