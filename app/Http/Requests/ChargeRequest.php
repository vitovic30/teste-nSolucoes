<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChargeRequest extends FormRequest
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
            'billing_type' => [
                'required',
                Rule::in(['CREDIT_CARD','BOLETO','PIX'])
            ],
            'value' => 'required|integer',
            'dueDate' => 'required|date|after_or_equal:now|date_format:Y-m-d'
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'O campo client_id deve ser requerido',
            'billing_type.required' => 'O campo billing_type deve ser requerido',
            'value.required' => 'O campo value deve ser requerido',
            'dueDate.required' => 'O campo dueDate deve ser requerido',
            'dueDate.date' => 'O campo dueDate deve ser uma data valida',
        ];
    }
}
