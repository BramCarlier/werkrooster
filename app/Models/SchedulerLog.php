<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulerLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ran_at',
        'duration',
        'success',
        'error',
    ];

    protected $casts = [
        'ran_at' => 'datetime',
        'success' => 'bool',
    ];
}
