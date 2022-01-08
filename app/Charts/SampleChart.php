<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Statistic;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {

        $labels = [];
        $dataRegisteredUsers = [];
        $dataOrganizerProfiles = [];
        $dataTeacherProfiles = [];
        $dataActiveEvents = [];

        $daysRange = 5;
        $lastIDUpdatedStats = Statistic::max('id');


        for ($days_backwards = $daysRange; $days_backwards >= 0; $days_backwards--) {
            $dayStat = Statistic::find($lastIDUpdatedStats - $days_backwards);
            $dataRegisteredUsers[] = $dayStat->registered_users_number;
            $dataOrganizerProfiles[] = $dayStat->organizers_number;
            $dataTeacherProfiles[] = $dayStat->teachers_number;
            $dataActiveEvents[] = $dayStat->active_events_number;
            $labels[] = Carbon::parse($dayStat->created_at)->format('d/m');
        }
        

        $ret = Chartisan::build();
        $ret->labels($labels);

        $ret->dataset('Registered Users', $dataRegisteredUsers);
        $ret->dataset('Organizer profiles', $dataOrganizerProfiles);
        $ret->dataset('Teacher profiles', $dataTeacherProfiles);
        $ret->dataset('Active events', $dataActiveEvents);

        return $ret;
    }
}