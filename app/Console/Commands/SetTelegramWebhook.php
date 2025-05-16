<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SetTelegramWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-telegram-webhook {url?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $token = config('services.telegram.token');
        $url = $this->argument('url') ?? config('app.url') . '/telegram';

        $response = Http::post("https://api.telegram.org/bot{$token}/setWebhook", [
            'url' => $url,
        ]);

        if ($response->successful()) {
            $this->info("Webhook установлен: {$url}");
        } else {
            $this->error("Ошибка при установке webhook:");
            $this->error($response->body());
        }
    }
}
