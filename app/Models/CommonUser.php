<?php
namespace App\Models;

use App\Models\User;
use App\Interfaces\Transferable;

class CommonUser extends User implements Transferable
{
    protected $table = 'users';
    
    public function sendMoney($destination, $amount): bool
    {
        return true;
    }

    public function receiveMoney($source, $amount): bool
    {
        return true;
    }
}
