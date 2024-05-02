<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private $userService;

    /**
     * Construtor que injeta o UserService. (Utilizando injeção de dependência)
     * @param UserService $userService - Serviço que lida com operações relacionadas a usuários.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Método para armazenar um novo usuário no banco de dados.
     * @param UserStoreRequest $request - Requisição validada contendo dados do usuário.
     * @return JsonResponse - Resposta JSON com os dados do usuário criado ou uma mensagem de erro.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request);

            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
