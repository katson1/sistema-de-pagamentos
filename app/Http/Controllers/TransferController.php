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

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transfer(TransferRequest $request)
    {
        $sender = User::find($request->id_sender);
        $receiver = User::find($request->id_receiver);
        $amount = $request->amount;
        try {
            $execute = $this->transferService->execute($sender, $receiver, $amount);
            return response()->json([
                'message' => StringConstants::TRANSFER_SUCCESSFUL,
                'notification' => $execute['notification']], 
                200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
