<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_label',
        'day_order',
        'start',
        'end',
        'subtasks',
    ];
}
