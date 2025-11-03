<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\TransactionController;

Route::post('webhook', [TelegramBotController::class, 'webhook']);
Route::apiResource('transactions', TransactionController::class);
