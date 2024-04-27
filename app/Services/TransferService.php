<?php

namespace App\Services;
use App\Interfaces\TransferInterface;

use App\Models\User;

class TransferService implements TransferInterface
{
    public function execute(User $sender, User $receiver, float $amount): bool
    {
        if (!$sender->canSendMoney()) {
            return "Sender cannot send money.";
            throw new \Exception("Sender cannot send money.");
        }

        if (!$receiver->canReceiveMoney()) {
            return "Receiver cannot receive money.";
            throw new \Exception("Receiver cannot receive money.");
        }

        if ($sender->balance < $amount) {
            return "Sender does not have enough balance.";
            throw new \Exception("Sender does not have enough balance.");
        }

        return $sender->balancerue;

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
