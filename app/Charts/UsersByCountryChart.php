<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Services\StatisticService;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class UsersByCountryChart extends BaseChart
{
    private StatisticService $statisticService;

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