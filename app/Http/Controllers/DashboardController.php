<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private PostService $postService;

    /**
     * DashboardController constructor.
     *
     * @param  \App\Services\PostService  $postService
     */
    public function __construct(
        PostService $postService,
    ) {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $searchParameters = [];
        $searchParameters['is_published'] = 0;

        $totalPublishedPostsNumber = $this->postService->getPublishedPostsNumber();
        return view('dashboard.index', [
            'totalPosts' => $totalPublishedPostsNumber,
        ]);
    }
}
