<?php
namespace App\Models;

use App\Models\User;
use App\Interfaces\Transferable;

class StoreUser extends User implements Transferable
{
    protected $table = 'users';

    public function sendMoney($destination, $amount)
    {
        throw new \Exception("Stores cannot send money.");
    }

    public function receiveMoney($source, $amount)
    {
        echo "Recieving {$amount} of {$source->name}.";
    }
}
