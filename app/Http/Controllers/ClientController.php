<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChargeRequest;
use App\Http\Requests\ClientRequest;
use App\Http\Requests\FormaPagamentoRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\Client as ResourcesClient;
use App\Http\Services\AssasSandbox;
use App\Models\Charge;
use App\Models\Client;
use App\Models\Endereco;
use App\Models\FormaPagamento;

class ClientController extends Controller
{
    protected $service;

    public function __construct(AssasSandbox $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $clients = Client::with('endereco')
                ->with('formaPagamento')
                ->get()
                ->toArray();

            return response()->json(['data' => new ResourcesClient($clients)]);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function store(ClientRequest $request)
    {
        try {

            $data = $request->validated();
            $dataEndereco = [...$data['enderecos']];
            $enderecoId = Endereco::create($dataEndereco)->id;

            list("nome" => $nome, "cpf" => $cpf, "data_nascimento" => $data_nascimento) = $data;

            $dataClient = [
                "nome" => $nome,
                "cpf" => $cpf,
                "data_nascimento" => $data_nascimento,
                "endereco_id" => $enderecoId
            ];

            $codigo_cus = $this->service->newClient($data)->id;

            $dataClient['codigo_cus'] = $codigo_cus;
            $clientId = Client::create($dataClient)->id;

            Endereco::where('id',$enderecoId)->update(['client_id' => $clientId]);

            return response()->json(['message' => 'Cliente criado com sucesso.'], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function charge(ChargeRequest $request)
    {
        try {
            $data = $request->validated();
            $data['customer'] = Client::where('id', $data['client_id'])->first()->codigo_cus;
            $charge = $this->service->createCharge($data);
            $client = Client::where('id', $data['client_id']);

            $charge = Charge::create([
                'codigo_cliente_cus' => $data['customer'],
                'codigo_payment' => $charge->id,
                'forma_pagamento' => $charge->billingType,
                'value' => $charge->value,
                'data_vencimento' => $charge->originalDueDate,
                'client_id' => $client->first()->id
            ]);

            $client->update(['charge_id' => $charge->id ]);

            return response()->json(['message' => 'Cobrança realizada com sucesso.']);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function formaPagamento(FormaPagamentoRequest $request)
    {
        try {
            $data = $request->validated();
            $client = Client::where('id', $data['client_id'])->first();

            $data['customer'] = $client->codigo_cus;
            $cartao = $this->service->tokenizacaoCreditCard($data);

            $formaPagamento = FormaPagamento::create([
                'holder_name' => $data['credit_card']['holder_name'],
                'number' => $data['credit_card']['number'],
                'expiry_month' => $data['credit_card']['expiry_month'],
                'expiry_year' => $data['credit_card']['expiry_year'],
                'ccv' => $data['credit_card']['ccv'],
                'credit_card_brand' => $cartao->creditCardBrand,
                'credit_card_token' => $cartao->creditCardToken,
                'client_id' => $client->id
            ]);

            Client::where('id', $client->id)->update(['forma_pagamento_id' => $formaPagamento->id]);

            return response()->json(['message' => 'Método de pagamento adicionado com sucesso.']);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function payment(PaymentRequest $request)
    {
        try {
            $data = $request->validated();

            $this->service->payment($data);

            return response()->json(['message' => 'Pagamento aprovado'], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'data' => null,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
