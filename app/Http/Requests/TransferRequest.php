<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_sender' => 'required|numeric',
            'id_receiver' => 'required|numeric',
            'amount' => 'required|numeric|min:0.01',
        ];
    }   

    public function messages(): array
    {
        return [
            'id_sender.required' => 'The sender ID is required.',
            'id_sender.numeric' => 'The sender ID must be a numeric value.',
            'id_receiver.required' => 'The receiver ID is required.',
            'id_receiver.numeric' => 'The receiver ID must be a numeric value.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a numeric value.',
            'amount.min' => 'The amount be at least 00.1.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Data given is invalid.',
            'errors' => $validator->errors(),
        ], Response::HTTP_NOT_FOUND);

        throw new HttpResponseException($response);
    }
}
