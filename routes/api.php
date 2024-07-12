<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherCodeController;

Route::post('/user', [UserController::class, 'create']);

Route::post('/voucher', [VoucherCodeController::class, 'create'])->middleware('auth:sanctum');
