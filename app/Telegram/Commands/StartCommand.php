<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Boshlash komandasi';

    public function handle()
    {
        $this->replyWithMessage([
            'text' => "Assalomu alaykum 👋\nBu Finance Bot! Sizga qanday yordam bera olaman?"
        ]);
    }
}
