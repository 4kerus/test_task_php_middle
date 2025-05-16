<?php

namespace App\Console\Commands;

use App\Jobs\SendTelegramMessage;
use App\Models\TelegramUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send incomplete tasks to subscribed Telegram users';

    public function handle(): void
    {
        $this->info('Получение задач из внешнего API...');

        $response = Http::get('https://jsonplaceholder.typicode.com/todos');

        if ($response->failed()) {
            $this->error('Не удалось получить данные с внешнего API.');
            return;
        }

        $tasks = array_filter($response->json(), function ($task) {
            return !$task['completed'] && $task['userId'] <= 5;
        });

        $this->info("Найдено задач: " . count($tasks));

        $users = TelegramUser::query()->where('subscribed', true)->get();

        foreach ($users as $user) {
            $message = "📝 Невыполненные задачи:\n\n";

            foreach ($tasks as $task) {
                $message .= "• " . $task['title'] . "\n";
            }

            SendTelegramMessage::dispatch($user->telegram_id, $message);
        }

        $this->info('Уведомления поставлены в очередь.');
    }
}
