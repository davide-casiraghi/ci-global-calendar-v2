<?php

namespace App\Repositories;

use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
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
        $lastUpdateStatistic = Statistic::find(Statistic::max('id'));
        $lastUpdateDate = ($lastUpdateStatistic != null) ? $lastUpdateStatistic->created_at->format('d-m-Y') : null;

        if ($lastUpdateDate != $todayDate) {
            $statistics = new Statistic();
            $statistics->registered_users_number = $data['registered_users_number'];
            $statistics->organizers_number = $data['organizers_number'];
            $statistics->teachers_number = $data['teachers_number'];
            $statistics->active_events_number = $data['active_events_number'];

            $statistics->save();

            Log::notice('statistics updated');
        } else {
            Log::notice('the statistics have been already updated today');
        }
    }

    /**
     * Return the latest statistics data.
     *
     * @return Statistic|null
     */
    public static function getLatestStatistics(): ?Statistic
    {
        $lastUpdateStatisticsId = Statistic::max('id');
        return Statistic::find($lastUpdateStatisticsId);
    }


}
