<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'registered_users_number', 'organizers_number', 'teachers_number', 'active_events_number',
    ];
}
