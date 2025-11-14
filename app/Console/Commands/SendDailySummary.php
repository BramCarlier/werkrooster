<?php

namespace App\Console\Commands;

use App\Models\NotificationSetting;
use App\Models\ScheduleEntry;
use App\Services\SlackNotifier;
use App\Services\SmsNotifier;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDailySummary extends Command
{
    protected $signature = 'werkrooster:daily-summary';
    protected $description = 'Stuur dagelijkse samenvatting via Slack/SMS';

    public function handle(SlackNotifier $slack, SmsNotifier $sms): int
    {
        $settings = NotificationSetting::first();
        if (!$settings || !$settings->enable_daily_summary) {
            return self::SUCCESS;
        }

        $now = Carbon::now();
        // De tijd-check doen we in de scheduler, hier mag hij altijd draaien:
        $weekday = $now->dayOfWeekIso; // 1 = maandag
        $entry = ScheduleEntry::where('day_order', $weekday)->first();
        if (!$entry) {
            return self::SUCCESS;
        }

        $text = sprintf(
            'Vandaag (%s) werk je van %s tot %s. Subtaken: %s',
            $entry->day_label,
            $entry->start,
            $entry->end,
            $entry->subtasks ?: 'geen'
        );

        $slack->send($text);

        if ($settings->sms_to) {
            $sms->send($settings->sms_to, $text);
        }

        return self::SUCCESS;
    }
}
