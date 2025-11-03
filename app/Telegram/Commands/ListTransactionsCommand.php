<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use App\Models\Transaction;

class ListTransactionsCommand extends Command
{
    protected string $name = 'list';
    protected string $description = 'Oxirgi transactionlarni ko‘rsatadi';

    public function handle()
    {
        $transactions = Transaction::latest()->take(10)->get();

        $message = "Oxirgi 10 transaction:\n";
        foreach ($transactions as $t) {
            $message .= "{$t->date} | {$t->category->name} | {$t->amount} {$t->currency->code} | {$t->note}\n";
        }

        $this->replyWithMessage(['text' => $message]);
    }
}
