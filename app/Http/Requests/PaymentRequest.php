<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'payment_id' => 'required|string',
            'token_card' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_id.required' => 'O campo payment é requerido.',
            'token_card.required' => 'O campo token_card é requerido.'
        ];
    }
}
