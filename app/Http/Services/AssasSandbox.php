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

    public function tokenizacaoCreditCard(array $payload)
    {
        $payload = [
            'creditCard' => [
                'holderName' => $payload['credit_card']['holder_name'],
                'number' => $payload['credit_card']['number'],
                'expiryMonth' => $payload['credit_card']['expiry_month'],
                'expiryYear' => $payload['credit_card']['expiry_year'],
                'ccv' => $payload['credit_card']['ccv'],
            ],
            'creditCardHolderInfo' => [
                'name' => $payload['credit_card_holder_info']['name'],
                'email' => $payload['credit_card_holder_info']['email'],
                'cpfCnpj' => $payload['credit_card_holder_info']['cpf_cnpj'],
                'postalCode' => $payload['credit_card_holder_info']['postal_code'],
                'addressNumber' => $payload['credit_card_holder_info']['address_number'],
                'addressComplement' => $payload['credit_card_holder_info']['address_complement'] ?? null,
                'phone' => $payload['credit_card_holder_info']['phone'],
            ],
            'customer' => $payload['customer'],
        ];

        $response = $this->client->request('POST', 'https://sandbox.asaas.com/api/v3/creditCard/tokenize', [
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

    public function payment(array $data)
    {
        $payload = [
            'creditCardToken' => $data['token_card']
        ];

        $url = "https://sandbox.asaas.com/api/v3/payments/".$data['payment_id']."/payWithCreditCard";
        $response = $this->client->request('POST', $url, [
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
