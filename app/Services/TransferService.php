<?php

namespace App\Services;

use App\Interfaces\TransferInterface;
use App\Services\Authorization\ExternalAuthorizationService;
use App\Services\NotificationService;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        if (!$sender->canSendMoney()) {
            throw new \Exception("Sender cannot send money.");
        }

        if (!$receiver->canReceiveMoney()) {
            throw new \Exception("Receiver cannot receive money.");
        }

        if ($sender->balance < $amount) {
            throw new \Exception("Sender does not have enough balance.");
        }
    }

    private function authorizeTransaction(): void
    {
        if (!$this->authorizationService->authorize()) {
            throw new \Exception("Transaction not authorized by external service.");
        }
    }
}
