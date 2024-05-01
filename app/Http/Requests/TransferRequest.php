<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Constants\StringConstants;

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
            'id_sender.required' => StringConstants::ID_SENDER_REQUIRED,
            'id_sender.numeric' => StringConstants::ID_SENDER_NUMERIC,
            'id_receiver.required' => StringConstants::ID_RECEIVER_REQUIRED,
            'id_receiver.numeric' => StringConstants::ID_RECEIVER_NUMERIC,
            'amount.required' => StringConstants::AMOUNT_REQUIRED,
            'amount.numeric' => StringConstants::AMOUNT_NUMERIC,
            'amount.min' => StringConstants::AMOUNT_MIN
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => StringConstants::INVALID_DATA_GIVEN,
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
}
