<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\CustomerOrderController;

Route::post('/customer/login', [CustomerAuthController::class, 'login']);
Route::get('/customer/orders/{customerId}', [CustomerOrderController::class, 'index']);