<?php

namespace App\Http\Controllers;

use App\Models\SchedulerLog;

class SystemController extends Controller
{
    public function schedulerStatus()
    {
        $logs = SchedulerLog::orderBy('ran_at', 'desc')
            ->limit(50)
            ->get();

        $lastSuccess = SchedulerLog::where('success', true)
            ->orderBy('ran_at', 'desc')
            ->first();

        $lastError = SchedulerLog::where('success', false)
            ->orderBy('ran_at', 'desc')
            ->first();

        return view('system.scheduler', [
            'logs'        => $logs,
            'lastSuccess' => $lastSuccess,
            'lastError'   => $lastError,
        ]);
    }
}
