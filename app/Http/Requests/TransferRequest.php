<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'id_sender' => 'required|numeric',
            'id_receiver' => 'required|numeric',
            'amount' => 'required|numeric',
        ];
    }   

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id_sender.required' => 'The sender ID is required.',
            'id_sender.numeric' => 'The sender ID must be a numeric value.',
            'id_receiver.required' => 'The receiver ID is required.',
            'id_receiver.numeric' => 'The receiver ID must be a numeric value.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a numeric value.'
        ];
    }
}
