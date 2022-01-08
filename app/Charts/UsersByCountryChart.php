<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Statistic;
use App\Models\User;
use App\Services\StatisticService;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersByCountryChart extends BaseChart
{
    private StatisticService $staticService;

    public function __construct(
        StatisticService $staticService
    ) {
        $this->statisticService = $staticService;
    }

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        /*$usersNumberByCounties = User::leftJoin('user_profiles', 'users.id', '=', 'user_profiles.user_id')
            ->leftJoin('countries', 'countries.id', '=', 'user_profiles.country_id')
            ->select(DB::raw('count(*) as user_count, countries.name as country_name'))
            ->groupBy('country_id')
            ->orderBy('country_name')
            ->get();*/

        $usersNumberByCounties = $this->statisticService->getUserNumberByCountries();

        $data = [];
        $labels = [];
        foreach ($usersNumberByCounties as $key => $usersNumberByCountry) {
            $data[] = $usersNumberByCountry->user_count;
            $labels[] = $usersNumberByCountry->country_name;
        }

        $ret = Chartisan::build();
        $ret->labels($labels);
        $ret->dataset('Users by country', $data);

        return $ret;
    }
}