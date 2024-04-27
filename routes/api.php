<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransferController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/users', [UserController::class, 'store']);

Route::post('/transfer', [TransferController::class, 'transfer']);
