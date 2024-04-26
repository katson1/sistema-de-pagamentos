<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'cpf_cnpj' => 'required|string|unique:users,cpf_cnpj',
            'user_type' => 'required|in:common,store',
            'balance' => 'numeric|min:0',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de e-mail válido.',
            'email.unique' => 'Este endereço de e-mail já está em uso.',
            'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
            'cpf_cnpj.unique' => 'Este CPF/CNPJ já está em uso.',
            'user_type.required' => 'O tipo de usuário é obrigatório.',
            'user_type.in' => 'O tipo de usuário deve ser "common" ou "store".',
            'balance.numeric' => 'O saldo deve ser um valor numérico.',
            'balance.min' => 'O saldo não pode ser inferior a 0.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ];
    }
}
