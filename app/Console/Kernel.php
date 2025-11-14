<?php

namespace App\Console;

use App\Console\Commands\SendDailySummary;
use App\Models\NotificationSetting;
use App\Models\SchedulerLog;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Artisan;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Wrapper rond onze interne taken, zodat we logging hebben
        $schedule->call(function () {
            $start = microtime(true);

            try {
                // Check of we nu op het ingestelde tijdstip zitten
                $settings = NotificationSetting::first();
                if ($settings && $settings->enable_daily_summary) {
                    $now = Carbon::now()->format('H:i');
                    if ($now === $settings->daily_time) {
                        Artisan::call('werkrooster:daily-summary');
                    }
                }

                SchedulerLog::create([
                    'ran_at'   => now(),
                    'duration' => microtime(true) - $start,
                    'success'  => true,
                    'error'    => null,
                ]);
            } catch (\Throwable $e) {
                SchedulerLog::create([
                    'ran_at'   => now(),
                    'duration' => microtime(true) - $start,
                    'success'  => false,
                    'error'    => $e->getMessage(),
                ]);
            }
        })->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
