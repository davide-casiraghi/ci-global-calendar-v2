<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Helper;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class HelperTest extends TestCase
{
    use WithFaker;

    private Helper $helper;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->helper = $this->app->make('App\Helpers\Helper');
    }

    /** @test */
    public function itShouldGetSearchParameters()
    {
        $request = new Request();
        $data = [
            'title' => 'test title',
            'status' => 'published',
        ];
        $request->merge($data);

        $parameterNames = ['title', 'status'];

        $searchParameters = $this->helper->getSearchParameters($request, $parameterNames);

        $this->assertEquals($searchParameters['title'], 'test title');
        $this->assertEquals($searchParameters['status'], 'published');
    }
}
