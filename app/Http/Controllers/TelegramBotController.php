<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class TelegramBotController extends Controller
{
    public function webhook(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $message = $request->input('message.text') ?? null;
        $chatId = $request->input('message.chat.id') ?? null;

        if (!$message || !$chatId) {
            return response('ok', 200);
        }

        $telegramId = $request->input('message.from.id');
        $telegramName = $request->input('message.from.first_name') ?? 'Foydalanuvchi';
        $telegramUsername = $request->input('message.from.username') ?? null;

        $stateKey = "transaction_state_$chatId";
        $state = Cache::get($stateKey);

        $messageLower = strtolower(trim($message));

        // 🔹 1. /start
        if ($messageLower === '/start') {
            Cache::forget($stateKey);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "👋 Assalomu alaykum, {$telegramName}!\nBu Finance Bot.\n\n💰 Transaction qo‘shish uchun /add buyrug‘ini yuboring.\n📜 Transactionlaringizni ko‘rish uchun /list buyrug‘ini yuboring.",
            ]);

            return response('ok', 200);
        }

        // 🔹 2. /cancel
        if ($messageLower === '/cancel') {
            Cache::forget($stateKey);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "❌ Amal bekor qilindi.\nYangi transaction qo‘shish uchun /add buyrug‘ini yuboring.",
            ]);

            return response('ok', 200);
        }

        // 🔹 3. /list
        if ($messageLower === '/list') {
            $user = User::where('telegram_id', $telegramId)->first();

            if (!$user) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "ℹ️ Sizda hali hech qanday transaction yo‘q. /add buyrug‘ini yuborib yangi qo‘shing.",
                ]);
                return response('ok', 200);
            }

            $transactions = Transaction::where('user_id', $user->id)
                ->latest()
                ->take(10)
                ->with(['category', 'currency'])
                ->get();

            if ($transactions->isEmpty()) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "📭 Sizda hali transactionlar yo‘q.",
                ]);
                return response('ok', 200);
            }

            $text = "📋 So‘nggi 10 ta transaction:\n\n";
            foreach ($transactions as $t) {
                $text .= "💰 {$t->amount} {$t->currency->code}\n";
                $text .= "📂 {$t->category->name}\n";
                if ($t->note) {
                    $text .= "📝 {$t->note}\n";
                }
                $text .= "🗓 " . $t->date->format('Y-m-d') . "\n";
                $text .= "------------------------\n";
            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
            ]);

            return response('ok', 200);
        }

        // 🔹 4. /add
        if ($messageLower === '/add') {
            $newState = [
                'step' => 'amount',
                'amount' => null,
                'category' => null,
                'currency' => null,
                'note' => null,
            ];

            Cache::put($stateKey, $newState, now()->addMinutes(5));

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "💰 Yangi transaction qo‘shishni boshlaymiz!\nIltimos, summani kiriting (masalan: 20000).",
            ]);

            return response('ok', 200);
        }

        // 🔹 5. State davom etadi
        if ($state) {
            switch ($state['step']) {
                case 'amount':
                    if (!is_numeric($message)) {
                        Telegram::sendMessage([
                            'chat_id' => $chatId,
                            'text' => "❌ Iltimos, summani faqat raqamda kiriting (masalan: 20000)",
                        ]);
                        return response('ok', 200);
                    }

                    $state['amount'] = $message;
                    $state['step'] = 'category';
                    Cache::put($stateKey, $state, now()->addMinutes(5));

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "✅ Summani qabul qildim.\nEndi kategoriyani yozing (masalan: Ovqatlanish, Transport, Boshqa).",
                    ]);
                    break;

                case 'category':
                    $state['category'] = $message;
                    $state['step'] = 'currency';
                    Cache::put($stateKey, $state, now()->addMinutes(5));

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "💵 Endi valyutani yozing (masalan: USD, UZS).",
                    ]);
                    break;

                case 'currency':
                    $state['currency'] = strtoupper($message);
                    $state['step'] = 'note';
                    Cache::put($stateKey, $state, now()->addMinutes(5));

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "📝 Izoh (note) yozing yoki 'yo‘q' deb yozing.",
                    ]);
                    break;

                case 'note':
                    $note = $messageLower === 'yo‘q' ? null : $message;

                    $user = User::updateOrCreate(
                        ['telegram_id' => $telegramId],
                        [
                            'name' => $telegramName,
                            'username' => $telegramUsername,
                            'email' => $telegramId . '@telegram.local',
                        ]
                    );

                    $category = Category::firstOrCreate(
                        ['name' => $state['category']],
                        ['type' => 'expense']
                    );
                    $currency = Currency::firstOrCreate(
                        ['code' => $state['currency']],
                        ['name' => $state['currency']]
                    );

                    Transaction::create([
                        'user_id' => $user->id,
                        'category_id' => $category->id,
                        'currency_id' => $currency->id,
                        'amount' => $state['amount'],
                        'date' => now(),
                        'note' => $note,
                    ]);

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "✅ Transaction muvaffaqiyatli qo‘shildi!\n\n💰 {$state['amount']} {$currency->code}\n📂 {$category->name}\n🗓 " . now()->format('Y-m-d'),
                    ]);

                    Cache::forget($stateKey);
                    break;
            }

            return response('ok', 200);
        }

        // 🔹 6. Default javob
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "ℹ️ Iltimos, /add orqali transaction qo‘shing yoki /list orqali ro‘yxatni ko‘ring.",
        ]);

        return response('ok', 200);
    }
}
