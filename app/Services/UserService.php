<?php

namespace App\Services;

use App\Models\User;
use App\Models\CommonUser;
use App\Models\StoreUser;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser($userData): User
    {
        $user = new User();
        $this->fillUserDataAndSave($user, $userData);
        return $user;
    }

    private function fillUserDataAndSave(User $user, $userData): void
    {
        $user->name = $userData->name;
        $user->email = $userData->email;
        $user->cpf_cnpj = $userData->cpf_cnpj;
        $user->balance = $userData->balance ?? 0;
        $user->password = bcrypt($userData->password);
        $user->save();
    }
}
