<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    public function webhook(Request $request): void
    {
        $message = $request->input('message');
        $text = $message['text'] ?? '';
        $chatId = $message['chat']['id'];
        $name = $message['chat']['first_name'] ?? 'User';

        if ($text === '/start') {
            TelegramUser::query()->updateOrCreate(
                ['telegram_id' => $chatId],
                ['name' => $name, 'subscribed' => true]
            );
            $this->sendMessage($chatId, "Вы подписаны на уведомления.");
        } elseif ($text === '/stop') {
            TelegramUser::query()->where('telegram_id', $chatId)->update(['subscribed' => false]);
            $this->sendMessage($chatId, "Вы отписались от уведомлений.");
        } else {
            $this->sendMessage($chatId, "Доступные команды:\n/start - Подписаться на уведомления\n/stop - Отписаться от уведомлений");
        }
    }

    protected function sendMessage($chatId, $text): void
    {
        $token = config('services.telegram.token');
        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
        ]);
    }
}
