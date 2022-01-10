<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Statistic;
use App\Services\StatisticService;
use Carbon\Carbon;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class EventsByCountryChart extends BaseChart
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
        $eventsNumberByCountries = $this->statisticService->getActiveEventsCountByCountry();

        $data = [];
        $labels = [];
        foreach ($eventsNumberByCountries as $key => $eventsNumberByCountry) {
            $data[] = $eventsNumberByCountry->total;
            $labels[] = $eventsNumberByCountry->country_name;
        }

        $ret = Chartisan::build();
        $ret->labels($labels);

        $ret->dataset('Active events by country', $data);

        return $ret;
    }
}