<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use App\Services\StatisticService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    private PostService $postService;
    private StatisticService $statisticService;

    /**
     * DashboardController constructor.
     *
     * @param  PostService  $postService
     * @param  StatisticService  $statisticService
     */
    public function __construct(
        PostService $postService,
        StatisticService $statisticService,
    ) {
        $this->postService = $postService;
        $this->statisticService = $statisticService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $totalPublishedPostsNumber = $this->postService->getPublishedPostsNumber();
        $lastUpdateStatistics = $this->statisticService->getLatestStatistics();

        return view('dashboard.index', [
            'totalPosts' => $totalPublishedPostsNumber,
            'lastUpdateStatistics' => $lastUpdateStatistics
        ]);
    }
}
