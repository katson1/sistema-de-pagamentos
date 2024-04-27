<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Http\Controllers\Controller;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;


class TransferController extends Controller
{
    protected $TransferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function transfer(Request $request)
    {
        $sender = User::find($request->sender_id);
        $receiver = User::find($request->receiver_id);
        $amount = $request->amount;
        try {
            $this->transferService->execute($sender, $receiver, $amount);
            return response()->json(['message' => 'Transfer successful!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
