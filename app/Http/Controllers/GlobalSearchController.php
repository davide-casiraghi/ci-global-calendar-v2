<?php

namespace App\Http\Controllers;

use App\Http\Requests\GlobalSearchRequest;
use App\Models\Glossary;
use App\Models\Insight;
use App\Models\Post;
use App\Models\Quote;
use Illuminate\View\View;
use Spatie\Searchable\Search;

class GlobalSearchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\GlobalSearchRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function index(GlobalSearchRequest $request): View
    {
        $query = $request->keyword;

        $searchResults = (new Search())
            ->registerModel(Post::class, ['title'])
            ->registerModel(Glossary::class, ['term', 'definition'])
            ->registerModel(Quote::class, ['author', 'description'])
            ->registerModel(Insight::class, ['title', 'body'])

            ->search($query);

        return view('globalSearch.index', [
            'searchResults' => $searchResults,
        ]);
    }
}
