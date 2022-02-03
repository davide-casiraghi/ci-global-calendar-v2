<?php

namespace App\Http\Controllers;

use App\Http\Requests\GlobalSearchRequest;
use App\Models\Event;
use App\Models\Organizer;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use Illuminate\View\View;
use Spatie\Searchable\Search;

class GlobalSearchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  GlobalSearchRequest  $request
     *
     * @return View
     */
    public function index(GlobalSearchRequest $request): View
    {
        $query = $request->keyword;

        $searchResults = (new Search())
            ->registerModel(User::class, ['email'])
            ->registerModel(UserProfile::class, ['name', 'surname'])
            ->registerModel(Post::class, ['title'])
            ->registerModel(Event::class, ['title'])
            ->registerModel(Teacher::class, ['name', 'surname'])
            ->registerModel(Organizer::class, ['name', 'surname'])
            ->registerModel(Venue::class, ['name'])

            ->search($query);

        return view('globalSearch.index', [
            'searchResults' => $searchResults,
        ]);
    }
}
