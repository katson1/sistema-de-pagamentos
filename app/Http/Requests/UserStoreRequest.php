<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use App\Constants\StringConstants;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'cpf_cnpj' => 'required|numeric|digits_between:11,14|unique:users,cpf_cnpj',
            'user_type' => 'required|in:common,store',
            'balance' => 'numeric|min:0',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => StringConstants::NAME_REQUIRED,
            'email.required' => StringConstants::EMAIL_REQUIRED,
            'email.email' => StringConstants::EMAIL_EMAIL,
            'email.unique' => StringConstants::EMAIL_UNIQUE,
            'cpf_cnpj.required' => StringConstants::CPF_CNPJ_REQUIRED,
            'cpf_cnpj.unique' => StringConstants::CPF_CNPJ_UNIQUE,
            'cpf_cnpj.numeric' => StringConstants::CPF_CNPJ_NUMERIC,
            'cpf_cnpj.digits_between' => StringConstants::CPF_CNPJ_DIGITS_BETWEEN,
            'user_type.required' => StringConstants::USER_TYPE_REQUIRED,
            'user_type.in' => StringConstants::USER_TYPE_IN,
            'balance.numeric' => StringConstants::BALANCE_NUMERIC,
            'balance.min' => StringConstants::BALANCE_MIN,
            'password.required' => StringConstants::PASSWORD_REQUIRED,
            'password.min' => StringConstants::PASSWORD_MIN,
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
