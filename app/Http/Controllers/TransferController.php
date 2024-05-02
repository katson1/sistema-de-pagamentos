<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Controllers\Controller;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Constants\StringConstants;

class TransferController extends Controller
{
    protected $TransferService;

    /**
     * Construtor injeta o serviço de transferência. (Utilizando injeção de dependência)
     * @param TransferService $transferService - Serviço que lida com a lógica de transferências.
     */
    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    /**
     * Método para realizar uma transferência financeira entre dois usuários.
     * @param TransferRequest $request - Requisição validada contendo dados da transferência.
     * @return JsonResponse - Resposta JSON contendo o resultado da operação.
     */
    public function transfer(TransferRequest $request): JsonResponse
    {
        $sender = User::find($request->id_sender);
        $receiver = User::find($request->id_receiver);
        $amount = $request->amount;  // Captura o valor a ser transferido

        try {
            $execute = $this->transferService->execute($sender, $receiver, $amount);
            
            return response()->json([
                'message' => StringConstants::TRANSFER_SUCCESSFUL,
                'notification' => $execute['notification']
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
