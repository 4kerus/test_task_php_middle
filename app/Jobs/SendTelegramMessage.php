<?php

namespace App\Jobs;

use Brick\Math\BigInteger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class SendTelegramMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */

    protected int $chatId;
    protected string $text;

    public function __construct($chatId, $text)
    {
        $this->chatId = $chatId;
        $this->text = $text;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $token = config('services.telegram.token');

        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $this->chatId,
            'text' => $this->text,
        ]);
    }
}
