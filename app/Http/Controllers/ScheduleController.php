<?php

namespace App\Http\Controllers;

use App\Models\ScheduleEntry;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $entries = ScheduleEntry::orderBy('day_order')->get();

        if ($entries->isEmpty()) {
            $defaults = [
                ['day' => 'Maandag',   'order' => 1, 'start' => '08:00', 'end' => '16:30', 'subtasks' => ''],
                ['day' => 'Dinsdag',   'order' => 2, 'start' => '08:00', 'end' => '16:30', 'subtasks' => ''],
                ['day' => 'Woensdag',  'order' => 3, 'start' => '08:00', 'end' => '15:00', 'subtasks' => 'Studio 08:45–09:00; Strafstudie 12:00–15:00'],
                ['day' => 'Donderdag', 'order' => 4, 'start' => '11:30', 'end' => '17:00', 'subtasks' => 'Refter 12:00–13:20; Afsluiten 16:30–17:00'],
                ['day' => 'Vrijdag',   'order' => 5, 'start' => '08:00', 'end' => '16:30', 'subtasks' => ''],
            ];
            foreach ($defaults as $d) {
                ScheduleEntry::create([
                    'day_label' => $d['day'],
                    'day_order' => $d['order'],
                    'start'     => $d['start'],
                    'end'       => $d['end'],
                    'subtasks'  => $d['subtasks'],
                ]);
            }
            $entries = ScheduleEntry::orderBy('day_order')->get();
        }

        $schedule = $entries->map(fn (ScheduleEntry $e) => [
            'day'      => $e->day_label,
            'start'    => $e->start,
            'end'      => $e->end,
            'subtasks' => $e->subtasks,
        ])->values();

        return view('schedule.index', [
            'schedule' => $schedule,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'schedule'              => 'required|array',
            'schedule.*.day'        => 'required|string',
            'schedule.*.start'      => 'required|string',
            'schedule.*.end'        => 'required|string',
            'schedule.*.subtasks'   => 'nullable|string',
        ]);

        foreach ($data['schedule'] as $idx => $row) {
            ScheduleEntry::updateOrCreate(
                ['day_order' => $idx + 1],
                [
                    'day_label' => $row['day'],
                    'start'     => $row['start'],
                    'end'       => $row['end'],
                    'subtasks'  => $row['subtasks'] ?? '',
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    }
}
