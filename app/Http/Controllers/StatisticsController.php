<?php

namespace App\Http\Controllers;

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
    public function index(Request $request): View
    {
        $this->checkPermission('users.view');

        $lastUpdateStatistics = $this->statisticService->getLatestStatistics();

        return view('statistics.index')
            ->with('lastUpdateStatistics', $lastUpdateStatistics);
    }

}
