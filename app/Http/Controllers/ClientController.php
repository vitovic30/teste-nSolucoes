<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\Client as ResourcesClient;
use App\Models\Client;
use App\Models\Endereco;

class ClientController extends Controller
{
    public function index()
    {
        try {
            $clients = Client::with('endereco')->get()->toArray();

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
}
