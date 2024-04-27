<?php

namespace App\Interfaces;

use App\Models\User;

interface NotificationServiceInterface
{
    public function notifyUsers(User $sender, User $receiver, float $amount): bool;
}
