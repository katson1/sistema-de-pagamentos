<?php

namespace App\Services;

use App\Interfaces\TransferInterface;
use App\Services\Authorization\ExternalAuthorizationService;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Constants\StringConstants;

class TransferService implements TransferInterface
{
    private ExternalAuthorizationService $authorizationService;
    private NotificationService $notificationService;

    public function __construct(ExternalAuthorizationService $authorizationService, NotificationService $notificationService)
    {
        $this->authorizationService = $authorizationService;
        $this->notificationService = $notificationService;
    }

    public function execute(User $sender, User $receiver, float $amount): array
    {
        $this->validateTransaction($sender, $receiver, $amount);

        $notificationResult = false;

        DB::beginTransaction();
        try {
            $sender->decrement('balance', $amount);
            $this->authorizeTransaction();
            $receiver->increment('balance', $amount);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        $notificationResult = $this->notificationService->notifyUsers($sender, $receiver, $amount);

        return [
            'transaction' => true,
            'notification' => $notificationResult
        ];
    }

    private function validateTransaction(User $sender, User $receiver, float $amount): void
    {   
        if ($sender == $receiver) {
            throw new \Exception(StringConstants::SAME_SENDER_RECEIVER);
        }
    
        if (!$sender->canSendMoney()) {
            throw new \Exception(StringConstants::SENDER_CANNOT_SEND);
        }
    
        if (!$receiver->canReceiveMoney()) {
            throw new \Exception(StringConstants::RECEIVER_CANNOT_RECEIVE);
        }
    
        if ($sender->balance < $amount) {
            throw new \Exception(StringConstants::INSUFFICIENT_BALANCE);
        }
    }
    
    private function authorizeTransaction(): void
    {
        if (!$this->authorizationService->authorize()) {
            throw new \Exception(StringConstants::AUTHORIZATION_FAILED);
        }
    }
    
}
