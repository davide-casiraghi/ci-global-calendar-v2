<?php

namespace Tests\Feature\Services;

use App\Http\Requests\CountryStoreRequest;
use App\Models\Country;
use App\Models\User;
use App\Services\CountryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private CountryService $countryService;

    private User $user1;
    private Country $country1;
    private Country $country2;
    private Country $country3;

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

        $this->countryService = $this->app->make('App\Services\CountryService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

       // Countris are created by the seeder
        $this->country1 = Country::find(1);
    }

    /** @test */
    public function itShouldCreateACountry()
    {
        $request = new countryStoreRequest();
        $data = [
            'name' => 'test country',
            'continent_id' => 1,
            'code' => 'TCX',
        ];
        $request->merge($data);

        $country = $this->countryService->createcountry($request);

        $this->assertDatabaseHas('countries', ['id' => $country->id]);
    }

    /** @test */
    public function itShouldUpdateACountry()
    {
        $request = new countryStoreRequest();

        $data = [
            'name' => 'test country updated',
            'continent_id' => 1,
            'code' => 'TCX',
        ];
        $request->merge($data);

        $this->countryService->updatecountry($request, $this->country1->id);

        $this->assertDatabaseHas('countries', ['name' => "test country updated"]);
    }

    /** @test */
    public function itShouldReturnACountryById()
    {
        $country = $this->countryService->getById($this->country1->id);

        $this->assertEquals($this->country1->id, $country->id);
    }

    /** @test */
    public function itShouldReturnAllCountries()
    {
        $countrys = $this->countryService->getCountries();
        $this->assertCount(257, $countrys);
    }

    /** @test */
    public function itShouldDeleteACountry()
    {
        $this->countryService->deleteCountry($this->country1->id);
        $this->assertDatabaseMissing('countries', ['id' => $this->country1->id]);
    }
}