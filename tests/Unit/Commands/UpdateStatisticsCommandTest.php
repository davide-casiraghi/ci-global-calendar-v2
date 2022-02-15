<?php

namespace Tests\Unit\Commands;

use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateStatisticsCommandTest extends TestCase
{
    use InteractsWithConsole;
    use RefreshDatabase; // empty the test DB

    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();
    }

    /** @test */
    public function itShouldConfirmThatNothingSentIfNoExpiring()
    {
        $this->artisan('update:statistics')
            ->assertSuccessful();
    }






}
