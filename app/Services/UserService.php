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
        switch ($userData->user_type) {
            case 'common':
                return $this->createCommonUser($userData);
            case 'store':
                return $this->createStoreUser($userData);
            default:
                throw new \InvalidArgumentException("Invalid user type specified");
        }
    }

    private function createCommonUser($userData): CommonUser
    {
        $user = new CommonUser();
        $this->fillUserData($user, $userData);
        return $user;
    }

    private function createStoreUser($userData): StoreUser
    {
        $user = new StoreUser();
        $this->fillUserData($user, $userData);
        return $user;
    }

    private function fillUserData(User $user, $userData): void
    {
        $user->name = $userData->name;
        $user->email = $userData->email;
        $user->cpf_cnpj = $userData->cpf_cnpj;
        $user->balance = $userData->balance ?? 0;
        $user->password = bcrypt($userData->password);
        $user->save();
    }
}
