<?php

namespace App\Contracts;

interface TransferInterface
{
    public function execute(User $sender, User $receiver, float $amount): bool;
}
