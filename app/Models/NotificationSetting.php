<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slack_webhook_url',
        'sms_to',
        'enable_daily_summary',
        'daily_time',
    ];

    protected $casts = [
        'enable_daily_summary' => 'bool',
    ];
}
