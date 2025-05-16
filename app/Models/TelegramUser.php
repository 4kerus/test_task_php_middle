<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    protected $fillable = [
        'name',
        'telegram_id',
        'subscribed',
    ];


    protected $casts = [
        'subscribed' => 'boolean',
    ];
}
