<?php

namespace App\Repositories;

class StatisticRepository
{
    public static function updateStatistics()
    {
        $todayDate = Carbon::now()->format('d-m-Y');
        $lastUpdateStatistic = self::find(\DB::table('statistics')->max('id'));
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
