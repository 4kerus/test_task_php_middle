<?php

namespace Database\Seeders;

use App\Models\TelegramUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        TelegramUser::factory()->create([
            'telegram_id' => 123456789,
            'name' => 'Test Telegram User',
            'subscribed' => false
        ]);
    }
}
