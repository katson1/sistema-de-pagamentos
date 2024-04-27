<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CommonUser;
use App\Models\StoreUser;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserStoreRequest $request)
    {
        $user = $this->createUserByType($request->user_type);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->cpf_cnpj = $request->cpf_cnpj;
        $user->balance = $request->balance ?? 0;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json($user, 201);
    }

    private function createUserByType($type): User
    {
        switch ($type) {
            case 'common':
                return new CommonUser();
            case 'store':
                return new StoreUser();
            default:
                throw new \InvalidArgumentException("Invalid user type specified");
        }
    }
}

