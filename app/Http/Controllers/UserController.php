<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserStoreRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cpf_cnpj = $request->cpf_cnpj;
        $user->user_type = $request->user_type;
        $user->balance = $request->balance ?? 0;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json($user, 201);
    }
}
