<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\Snippets\GalleryMasonryService;
use App\Services\StaticPageService;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    private StaticPageService $staticPageService;

    public function __construct(
        StaticPageService $staticPageService
    ) {
        $this->staticPageService = $staticPageService;
    }

    /**
     * Show the about me page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutMe()
    {
      return view('pages.aboutMe');
    }

    /**
     * Show the treatments page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function treatments()
    {
        return view('pages.treatments');
    }

    /**
     * Show the treatmentsLearnMore page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function treatmentsLearnMore()
    {
        return view('pages.treatmentsLearnMore');
    }

    /**
     * Show the Contact Improvisation page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function contactImprovisation()
    {
        //$gallery1Html = $this->staticPageService->getStaticGalleryHtml('contact improvisation', true);

        return view('pages.contactImprovisation', [
            //'gallery1Html' => $gallery1Html,
        ]);
    }

    /**
     * Show the Water Contact page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function waterContact()
    {
        return view('pages.waterContact');
    }


}
