<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

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
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'cpf_cnpj.required' => 'The CPF/CNPJ field is required.',
            'cpf_cnpj.unique' => 'This CPF/CNPJ is already in use.',
            'cpf_cnpj.numeric' => 'The CPF/CNPJ is not valid.',
            'cpf_cnpj.digits_between' => 'The CPF/CNPJ must be between 11 and 14 digits long.',
            'user_type.required' => 'The user type is required.',
            'user_type.in' => 'The user type must be "common" or "store".',
            'balance.numeric' => 'The balance must be a numeric value.',
            'balance.min' => 'The balance cannot be less than 0.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Data given is invalid.',
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST);

        throw new HttpResponseException($response);
    }
}
