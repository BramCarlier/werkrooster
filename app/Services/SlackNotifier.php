<?php

namespace App\Services;

use App\Models\NotificationSetting;
use Illuminate\Support\Facades\Http;

class SlackNotifier
{
    public function send(string $message): void
    {
        $settings = NotificationSetting::first();
        if (!$settings || !$settings->slack_webhook_url) {
            return;
        }

        Http::post($settings->slack_webhook_url, [
            'text' => $message,
        ]);
    }
}
