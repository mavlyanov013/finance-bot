<?php

namespace App\Providers;

use App\Telegram\Commands\AddTransactionCommand;
use App\Telegram\Commands\ListTransactionsCommand;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Telegram\Commands\StartCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Telegram::addCommand(StartCommand::class);
        Telegram::addCommand(AddTransactionCommand::class);
        Telegram::addCommand(ListTransactionsCommand::class);
    }
}
