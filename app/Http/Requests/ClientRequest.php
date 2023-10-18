<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string',
            'cpf' => 'required|string|unique:clients',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'enderecos.cep' => 'required|string|unique:enderecos',
            'enderecos.localidade' => 'required|string',
            'enderecos.uf' => 'required|string',
            'enderecos.logradouro' => 'nullable|string',
            'enderecos.complemento' => 'nullable|string',
            'enderecos.bairro' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é requerido.',
            'cpf.required' => 'O campo cpf é requerido.',
            'cpf.unique' => 'O campo cpf deve ser único',
            'data_nascimento.required' => 'O campo data_nascimento deve ser requerido.',
            'data_nascimento.date_format' => 'O campo data de nascimento não é uma data válida',
            'enderecos.cep' => 'O campo cep é requerido.',
            'enderecos.uf' => 'O campo uf é requerido.',
            'enderecos.cep.unique' => 'O campo cep deve ser único.',
            'enderecos.localidade' => 'O campo localidade é requerido.',
        ];
    }
}
