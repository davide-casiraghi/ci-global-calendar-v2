<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Organizer;
use App\Models\Statistic;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StatisticRepository
{
    /**
     * Updates the statistics writing a new line in the statistics table.
     *
     * @param  array  $data
     * @return void
     */
    public static function updateStatistics(array $data): void
    {
        $todayDate = Carbon::now()->format('d-m-Y');
        $lastUpdateStatistic = Statistic::max('id');
        $lastUpdateDate = ($lastUpdateStatistic != null) ? $lastUpdateStatistic->created_at->format('d-m-Y') : null;

        if ($lastUpdateDate != $todayDate) {
            $statistics = new self();
            $statistics->registered_users_number = User::count();
            $statistics->organizers_number = Organizer::count();
            $statistics->teachers_number = Teacher::count();
            $statistics->active_events_number = Event::getActiveEvents()->count();

            $statistics->save();

            Log::notice('statistics updated');
        } else {
            Log::notice('the statistics have been already updated today');
        }
    }

}
