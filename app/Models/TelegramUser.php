<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'telegram_id',
        'subscribed',
    ];


    protected $casts = [
        'subscribed' => 'boolean',
    ];
}
