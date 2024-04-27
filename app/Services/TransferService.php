<?php

namespace App\Services;
use App\Interfaces\TransferInterface;

use App\Models\User;

class TransactionService implements TransactionInterface
{
    public function execute(User $sender, User $receiver, float $amount): bool
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

        DB::beginTransaction();
        try {
            $sender->decrement('balance', $amount);
            $receiver->increment('balance', $amount);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
