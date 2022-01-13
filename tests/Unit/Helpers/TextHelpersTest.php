<?php

namespace Tests\Unit\Helpers;

use App\Helpers\TextHelpers;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TextHelpersTest extends TestCase
{
    use WithFaker;

    private TextHelpers $textHelpers;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->textHelpers = $this->app->make('App\Helpers\TextHelpers');
    }

    /** @test */
    public function itShouldReturnTwoAsEstimateReadingTimeInMinutes()
    {
        $content = $this->faker->words(400, true);
        $wpm = 200;
        $format = 'minutes';
        $estimateReadingTime = $this->textHelpers->estimateReadingTime($content, $wpm, $format);

        $this->assertEquals('2', $estimateReadingTime);
    }

    /** @test */
    public function itShouldReturnLessThenOneAsEstimateReadingTimeInMinutes()
    {
        $content = $this->faker->words(100, true);
        $wpm = 200;
        $format = 'minutes';
        $estimateReadingTime = $this->textHelpers->estimateReadingTime($content, $wpm, $format);

        $this->assertEquals('Less then one minute', $estimateReadingTime);
    }

    /** @test */
    public function itShouldReturnThirtySecondsAsEstimateReadingTimeInMinutesAndSeconds()
    {
        $content = $this->faker->words(100, true);
        $wpm = 200;
        $format = 'minutesAndSeconds';
        $estimateReadingTime = $this->textHelpers->estimateReadingTime($content, $wpm, $format);

        $this->assertEquals('30 seconds', $estimateReadingTime);
    }

    /** @test */
    public function itShouldReturnOneMinuteAndThirtySecondsAsEstimateReadingTimeInMinutesAndSeconds()
    {
        $content = $this->faker->words(300, true);
        $wpm = 200;
        $format = 'minutesAndSeconds';
        $estimateReadingTime = $this->textHelpers->estimateReadingTime($content, $wpm, $format);

        $this->assertEquals('1 minute, 30 seconds', $estimateReadingTime);
    }
}
