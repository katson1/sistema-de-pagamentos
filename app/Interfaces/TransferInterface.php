<?php

namespace App\Interfaces;
use App\Models\User;

interface TransferInterface
{
    public function execute(User $sender, User $receiver, float $amount): bool;
}
