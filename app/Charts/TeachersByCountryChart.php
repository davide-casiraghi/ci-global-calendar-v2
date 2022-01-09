<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Services\StatisticService;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class TeachersByCountryChart extends BaseChart
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
        $teachersNumberByCountries = $this->statisticService->getTeachersNumberByCountries();

        $data = [];
        $labels = [];
        foreach ($teachersNumberByCountries as $key => $teachersNumberByCountry) {
            $data[] = $teachersNumberByCountry->teacher_count;
            $labels[] = $teachersNumberByCountry->country_name;
        }

        $ret = Chartisan::build();
        $ret->labels($labels);

        $ret->dataset('Teachers by country', $data);


        return $ret;
    }
}