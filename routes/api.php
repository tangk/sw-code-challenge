<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VoucherCodeController;
use Illuminate\Support\Facades\Route;

Route::prefix(config('app.api_version'))->group(function () {
    Route::post('/user', [UserController::class, 'create']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix(config('app.api_version'))->middleware('auth:sanctum')->group(function () {
    Route::get('/voucher', [VoucherCodeController::class, 'index']);
    Route::post('/voucher', [VoucherCodeController::class, 'create']);
    Route::delete('/voucher/{id}', [VoucherCodeController::class, 'delete']);
});
