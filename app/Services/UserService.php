<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Classe de serviço para gerenciamento de usuários.
 */
class UserService
{
    /**
     * Cria um novo usuário com base nos dados fornecidos.
     * @param object $userData - Dados do usuário recebidos do Controller via api.
     * @return User - Retorna o usuário recém-criado.
     */
    public function createUser($userData): User
    {
        $user = new User();
        $this->fillUserDataAndSave($user, $userData);
        return $user;
    }

    /**
     * Preenche os dados do usuário e salva no banco de dados.
     * @param User $user - Instância de User que será preenchida e salva.
     * @param object $userData - Dados do usuário para preenchimento.
     */
    private function fillUserDataAndSave(User $user, $userData): void
    {
        $user->name = $userData->name;
        $user->email = $userData->email;
        $user->cpf_cnpj = $userData->cpf_cnpj;
        $user->user_type = $userData->user_type;
        $user->balance = $userData->balance ?? 0;
        $user->password = bcrypt($userData->password);
        $user->save();
    }
}
