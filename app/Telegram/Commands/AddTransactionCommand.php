<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Illuminate\Support\Facades\Cache;

class AddTransactionCommand extends Command
{
    protected string $name = 'add';
    protected string $description = 'Yangi transaction qo‘shish';

    public function handle()
    {
        $chatId = $this->getUpdate()->getMessage()->getChat()->id;

        Cache::put("transaction_state_$chatId", [
            'step' => 'amount'
        ], now()->addMinutes(5));

        $this->replyWithMessage([
            'text' => "💰 Yangi transaction qo‘shish.\nIltimos, summani kiriting (masalan: 25000)",
        ]);
    }
}
