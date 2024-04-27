<?php
namespace App\Models;

use App\Models\User;
use App\Interfaces\Transferable;

class CommonUser extends User implements Transferable
{
    protected $table = 'users';
    
    public function sendMoney($destination, $amount)
    {
        echo "Sending {$amount} to {$destination->name}.";
    }

    public function receiveMoney($source, $amount)
    {
        echo "Recieving {$amount} of {$source->name}.";
    }
}
