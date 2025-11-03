<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramBotController;


Route::get('/', function () {
    return 'Finance Bot is running 🚀';
});

// Telegram webhook (POST)
//Route::post('/api/webhook', [TelegramBotController::class, 'webhook']);
