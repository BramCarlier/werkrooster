<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEntry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $entries = ScheduleEntry::query()
            ->orderBy('day_order')
            ->get();

        $upcoming = $entries->map(function (ScheduleEntry $e, $idx) {
            return [
                'id'          => $idx + 1,
                'date'        => $e->day_label,
                'label'       => $e->start.'–'.$e->end,
                'description' => $e->subtasks,
            ];
        })->take(5)->values();

        return view('dashboard', [
            'upcoming' => $upcoming,
        ]);
    }
}
