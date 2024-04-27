<?php
namespace App\Models;

use App\Models\User;
use App\Interfaces\Transferable;

class StoreUser extends User implements Transferable
{
    protected $table = 'users';

    public function canSendMoney($destination, $amount): bool
    {
        return false;
    }

    public function canReceiveMoney(): bool
    {
        return true;
    }
}
