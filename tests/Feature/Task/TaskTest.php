<?php

use Illuminate\Support\Facades\Http;
use App\Models\TelegramUser;

test('telegram webhook sends message', function () {

    Http::fake([
        'api.telegram.org/*' => Http::response(['ok' => true], 200),
    ]);

    $payload = [
        'update_id' => 61,
        'message' => [
            'message_id' => 61,
            'from' => [
                'id' => 61,
                'is_bot' => false,
                'first_name' => 'Nikolay',
                'last_name' => 'Antohi',
                'username' => 'kevinsmakai',
                'language_code' => 'ru',
            ],
            'chat' => [
                'id' => 61,
                'first_name' => 'Nikolay',
                'last_name' => 'Antohi',
                'username' => 'kevinsmakai',
                'type' => 'private',
            ],
            'date' => 1747402573,
            'text' => '/start',
            'entities' => [
                [
                    'offset' => 0,
                    'length' => 6,
                    'type' => 'bot_command',
                ],
            ],
        ],
    ];

    $response = $this->postJson('/telegram', $payload);

    $response->assertStatus(200);

    Http::assertSent(function ($request) use ($payload) {
        return $request->url() === 'https://api.telegram.org/bot' . config('services.telegram.token') . '/sendMessage' &&
            $request['chat_id'] === $payload['message']['chat']['id'] &&
            $request['text'] === 'Вы подписаны на уведомления.';
    });

    $this->assertDatabaseHas('telegram_users', [
        'telegram_id' => $payload['message']['chat']['id'],
        'name' => $payload['message']['chat']['first_name'],
        'subscribed' => true,
    ]);
});

test('telegram webhook handles message without text', function () {
    // Фейковый HTTP-клиент для Telegram API
    Http::fake([
        'api.telegram.org/*' => Http::response(['ok' => true], 200),
    ]);

    // Данные в формате Telegram webhook, без поля text
    $payload = [
        'update_id' => 659239645,
        'message' => [
            'message_id' => 61,
            'from' => [
                'id' => 6929915723,
                'is_bot' => false,
                'first_name' => 'Nikolay',
                'last_name' => 'Antohi',
                'username' => 'kevinsmakai',
                'language_code' => 'ru',
            ],
            'chat' => [
                'id' => 6929915723,
                'first_name' => 'Nikolay',
                'last_name' => 'Antohi',
                'username' => 'kevinsmakai',
                'type' => 'private',
            ],
            'date' => 1747402573,
            // Поле text отсутствует (например, пользователь отправил стикер)
        ],
    ];

    // Выполняем POST-запрос на /telegram
    $response = $this->postJson('/telegram', $payload);

    // Проверяем, что вернулся статус 200 (контроллер возвращает void)
    $response->assertStatus(200);

    // Проверяем, что запрос к Telegram API был отправлен
    Http::assertSent(function ($request) use ($payload) {
        return $request->url() === 'https://api.telegram.org/bot' . config('services.telegram.token') . '/sendMessage' &&
            $request['chat_id'] === $payload['message']['chat']['id'] &&
            $request['text'] === "Доступные команды:\n/start - Подписаться на уведомления\n/stop - Отписаться от уведомлений";
    });
});
