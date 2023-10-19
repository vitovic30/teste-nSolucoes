<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormaPagamentoRequest extends FormRequest
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
            'client_id' => 'required|integer',
            'credit_card.holder_name' => 'required|string',
            'credit_card.number' => 'required|string',
            'credit_card.expiry_month' => 'required|string|max:2',
            'credit_card.expiry_year' => 'required|string|max:4',
            'credit_card.ccv' => 'required|string|max:3',
            'credit_card_holder_info.name' => 'required|string',
            'credit_card_holder_info.email' => 'required|string',
            'credit_card_holder_info.cpf_cnpj' => 'required|string',
            'credit_card_holder_info.postal_code' => 'required|string',
            'credit_card_holder_info.address_number' => 'required|string',
            'credit_card_holder_info.address_complement' => 'nullable|string',
            'credit_card_holder_info.phone' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'O campo client_id é requerido.',
            'credtit_card.holder_name.required' => 'O campo holder é requerido.',
            'credit_card.number.required' => 'O campo number é requerido.',
            'credit_card.expiry_month.required' => 'O campo expiry_month é requerido.',
            'credit_card.expiry_month.max' => 'O campo expiry_month deve ter até dois caracteres.',
            'credit_card.expiry_year.required' => 'O campo expiry_year é requerido.',
            'credit_card.expiry_year.max' => 'O campo expiry_year deve ter até quatro caracteres.',
            'credit_card.ccv.required' => 'O campo ccv é requerido.',
            'credit_card.ccv.max' => 'O campo ccv deve ter até três caracteres.',
            'credit_card_holder_info.name.required' => 'O campo name é requerido.',
            'credit_card_holder_info.email.required' => 'O campo email é requerido.',
            'credit_card_holder_info.cpf_cnpj.required' => 'O campo cpf_cnpj é requerido.',
            'credit_card_holder_info.postal_code.required' => 'O campo postal_code é requerido.',
            'credit_card_holder_info.address_number.required' => 'O campo address_number é requerido.',
            'credit_card_holder_info.phone.required' => 'O campo phone é requerido.',

        ];
    }
}
