<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VoucherCodeController;
use Illuminate\Support\Facades\Route;

Route::post('/user', [UserController::class, 'create']);

Route::post('/voucher', [VoucherCodeController::class, 'create'])->middleware('auth:sanctum');
