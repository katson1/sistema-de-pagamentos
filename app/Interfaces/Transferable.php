<?php

namespace App\Interfaces;

interface Transferable {
    public function sendMoney($destination, $amount);
    public function receiveMoney($source, $amount);
}