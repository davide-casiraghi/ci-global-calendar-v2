<?php

namespace Tests\Feature\Services;

use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Models\User;
use App\Services\VenueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//use VCR\VCR;

class VenueServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private VenueService $venueService;

    private User $user1;
    private Venue $venue1;
    private Venue $venue2;
    private Venue $venue3;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        $this->venueService = $this->app->make('App\Services\VenueService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->venue1 = Venue::factory()->create();
        $this->venue2 = Venue::factory()->create();
        $this->venue3 = Venue::factory()->create();
    }

    /** @test */
    public function itShouldCreateAVenue()
    {
        $request = new venueStoreRequest();
        $data = [
            'name' => 'test name',
            'description' => 'test description',
            'website' => 'https://www.test.com',
            'address' => 'test address',
            'city' => 'test city',
            'country_id' => 1,
            'zip_code' => 'test zip',
        ];
        $request->merge($data);

        $venue = $this->venueService->createvenue($request);

        $this->assertDatabaseHas('venues', ['id' => $venue->id]);
    }

    /** @test */
    public function itShouldUpdateAVenue()
    {
        $request = new venueStoreRequest();

        $data = [
            'name' => 'test name updated',
            'description' => 'test description',
            'website' => 'https://www.test.com',
            'address' => 'test address',
            'city' => 'test city',
            'country_id' => 1,
            'zip_code' => 'test zip',
        ];
        $request->merge($data);

        $this->venueService->updatevenue($request, $this->venue1);

        $this->assertDatabaseHas('venues', ['name' => "test name updated"]);
    }

    /** @test */
    public function itShouldReturnAVenueById()
    {
        $venue = $this->venueService->getById($this->venue1->id);

        $this->assertEquals($this->venue1->id, $venue->id);
    }

    /** @test */
    public function itShouldReturnAllVenues()
    {
        $venues = $this->venueService->getVenues(20);
        $this->assertCount(3, $venues);
    }

    /** @test */
    public function itShouldDeleteAVenue()
    {
        $this->venueService->deletevenue($this->venue1->id);
        $this->assertDatabaseMissing('venues', ['id' => $this->venue1->id]);
    }

    /** @test */
    public function itShouldGetNumberVenuesCreatedLastThirtyDays()
    {
        $numberVenuesCreatedLastThirtyDays = $this->venueService->getNumberVenuesCreatedLastThirtyDays();
        $this->assertEquals($numberVenuesCreatedLastThirtyDays, 3);
    }

    /** @test */
   /* public function itShouldGetVenueGpsCoordinates()
    {
        // Tutorial for this test: https://laracasts.com/lessons/testing-http-requests
        // the output of the API request is saved in the tests/fixtures directory.
        // So after the first time, it reads this file instead of doing other requests.

       // on hold for missing PHP8 support - until they don't merge this - https://github.com/php-vcr/phpunit-testlistener-vcr/pull/38
        // Then install again the two packages and uncomment the test- https://stackoverflow.com/questions/36331847/laravel-api-test-how-to-test-api-that-has-external-api-call/66172537#66172537

        $address = "Milano, viale Abruzzi, 2";

        VCR::turnOn();
        VCR::insertCassette('mapquestapi');
        $coordinates = $this->venueService->getVenueGpsCoordinates($address);

        VCR::eject();
        VCR::turnOff();

        $this->assertEquals(45, number_format($coordinates['lat'], 0));
        $this->assertEquals(9, number_format($coordinates['lng'], 0));
    }*/


}