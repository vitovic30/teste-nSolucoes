<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'categoria' => 'required|string',
            'valor' => 'required|numeric',
            'tem_estoque' => [
                'required',
                Rule::in(["yes", "no"])
            ],
            'imagem' => 'nullable|File',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome e requerido.',
            'categoria.required' => 'O campo categoria e requerido.',
            'valor.required' => 'O campo valor e requerido.',
            'tem_estoque.required' => 'O campo tem_estoque e requerido.',
            'imagem.required' => 'O campo imagem e requerido.',
            'imagem.file' => 'O campo imagem nao e um arquivo.'
        ];
    }
}
