<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use App\Services\StatisticService;
use App\Traits\CheckPermission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    use CheckPermission;

    private StatisticService $statisticService;

    public function __construct(
        StatisticService $statisticService,
    ) {
        $this->statisticService = $statisticService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request)
    {
        $this->checkPermission('users.view');

        $lastUpdateStatistic = Statistic::find(\DB::table('statistics')->max('id'));

        //$registeredUsersChart = $this->statisticService->createLinesChart(12);

        //$usersByCountryChart = $this->statisticService->createUsersByCountryChart();
        //$teachersByCountriesChart = $this->statisticService->createTeachersByCountriesChart();
        //$eventsByCountriesChart = $this->statisticService->createEventsByCountriesChart();
        //$organizersByCountriesChart = $this->statisticService->createOrganizersByCountriesChart();






        return view('statistics.index');
            //->with('statsDatas', $lastUpdateStatistic)
            //->with('registeredUsersChart', $registeredUsersChart)
            //->with('usersByCountryChart', $usersByCountryChart)
            //->with('teachersByCountriesChart', $teachersByCountriesChart)

            //->with('usersChart', $usersChart)
            //->with('eventsByCountriesChart', $eventsByCountriesChart);
        //->with('organizersByCountriesChart', $organizersByCountriesChart);
    }

}
