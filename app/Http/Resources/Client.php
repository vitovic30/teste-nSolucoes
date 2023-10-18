<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class Client extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): Collection
    {
        return $this->collection->map(function($item) {
            return [
                'id' => $item['id'],
                'nome' => $item['nome'],
                'cpf' => $item['cpf'],
                'data_nascimento' => $item['data_nascimento'],
                'endereco' => $item['endereco'],
            ];
        });
    }
}
