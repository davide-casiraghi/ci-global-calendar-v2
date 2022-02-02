<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    private StatisticService $statisticService;

    /**
     * DashboardController constructor.
     *
     * @param  StatisticService  $statisticService
     */
    public function __construct(
        StatisticService $statisticService,
    ) {
        $this->statisticService = $statisticService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $lastUpdateStatistics = $this->statisticService->getLatestStatistics();

        return view('dashboard.index', [
            'lastUpdateStatistics' => $lastUpdateStatistics
        ]);
    }
}
