<?php

namespace Tests\Feature\Services;

use App\Http\Requests\RegionStoreRequest;
use App\Models\Region;
use App\Models\User;
use App\Services\RegionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegionServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private RegionService $regionService;

    private User $user1;
    private Region $region1;
    private Region $region2;
    private Region $region3;

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

        $this->regionService = $this->app->make('App\Services\RegionService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->region1 = Region::factory()->create(['country_id' => 1]);
        $this->region2 = Region::factory()->create(['country_id' => 1]);
        $this->region3 = Region::factory()->create(['country_id' => 1]);
    }

    /** @test */
    public function itShouldCreateARegion()
    {
        $request = new regionStoreRequest();
        $data = [
            'name' => 'test region',
            'country_id' => 1,
            'timezone' => '+1:00',
        ];
        $request->merge($data);

        $region = $this->regionService->createregion($request);

        $this->assertDatabaseHas('regions', ['id' => $region->id]);
    }

    /** @test */
    public function itShouldUpdateARegion()
    {
        $request = new regionStoreRequest();

        $data = [
          'name' => 'test region updated',
          'country_id' => 1,
          'timezone' => '+3:00',
        ];
        $request->merge($data);

        $this->regionService->updateregion($request, $this->region1->id);

        $this->assertDatabaseHas('regions', ['timezone' => '+3:00']);
    }

    /** @test */
    public function itShouldReturnARegionById()
    {
        $region = $this->regionService->getById($this->region1->id);

        $this->assertEquals($this->region1->id, $region->id);
    }

    /** @test */
    public function itShouldReturnAllRegions()
    {
        $regions = $this->regionService->getRegions();
        $this->assertCount(3, $regions);
    }

    /** @test */
    public function itShouldDeleteARegion()
    {
        $this->regionService->deleteregion($this->region1->id);
        $this->assertDatabaseMissing('regions', ['id' => $this->region1->id]);
    }
}