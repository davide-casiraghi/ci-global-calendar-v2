<?php

namespace Tests\Unit\Helpers;

use App\Helpers\DateHelpers;
use App\Helpers\Helper;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class DateHelpersTest extends TestCase
{
    use WithFaker;

    private DateHelpers $dateHelpers;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->dateHelpers = $this->app->make('App\Helpers\DateHelpers');
    }

    /** @test */
    public function itShouldReturnTrueSinceSpecifiedDateIsAWednesday()
    {
        $date = "2021-02-24";
        $dayOfTheWeek = 3; // Wednesday
        $isSpecifiedWeekDay = $this->dateHelpers->isSpecifiedWeekDay($date, $dayOfTheWeek);

        $this->assertEquals(true, $isSpecifiedWeekDay);
    }

    /** @test */
    public function itShouldReturnFalseSinceSpecifiedDateIsAFriday()
    {
        $date = "2021-02-26";
        $dayOfTheWeek = 3; // Wednesday
        $isSpecifiedWeekDay = $this->dateHelpers->isSpecifiedWeekDay($date, $dayOfTheWeek);

        $this->assertEquals(false, $isSpecifiedWeekDay);
    }

    /** @test */
    public function itShouldReturnThreeSinceTheSpecifiedDayIsInTheThirdWeek()
    {
        $date = "2021-12-16"; // the 3rd Thursday of the month
        $dateTimestamp = strtotime($date);
        $dayOfWeekValue = date('N', $dateTimestamp);

        $isSpecifiedWeekDay = $this->dateHelpers->monthWeekNumber($date, $dayOfWeekValue);

        $this->assertEquals(3, $isSpecifiedWeekDay);
    }

    /** @test */
    public function itShouldReturnOneSinceTheSpecifiedDayIsInTheLastWeekOfTheMonth()
    {
        $date = "2019-10-30"; // Last week of the month
        $dateTimestamp = strtotime($date);

        $numberOfWeekFromEndOfMonth = $this->dateHelpers->monthWeekNumberFromTheEnd($dateTimestamp);

        $this->assertEquals(1, $numberOfWeekFromEndOfMonth);
    }

    /** @test */
    public function itShouldReturnTwoSinceTheSpecifiedDayIsInTheSecondToLastWeekOfTheMonth()
    {
        $date = "2019-10-23"; // Second to last week of the month
        $dateTimestamp = strtotime($date);

        $numberOfWeekFromEndOfMonth = $this->dateHelpers->monthWeekNumberFromTheEnd($dateTimestamp);

        $this->assertEquals(2, $numberOfWeekFromEndOfMonth);
    }

    /** @test */
    public function itShouldReturnThreeSinceTheSpecifiedDayIsInTheThirdToLastWeekOfTheMonth()
    {
        $date = "2019-10-16"; // Third to last week of the month
        $dateTimestamp = strtotime($date);

        $numberOfWeekFromEndOfMonth = $this->dateHelpers->monthWeekNumberFromTheEnd($dateTimestamp);

        $this->assertEquals(3, $numberOfWeekFromEndOfMonth);
    }

    /** @test */
    public function itShouldReturnFourSinceTheSpecifiedDayIsInTheFourToLastWeekOfTheMonth()
    {
        $date = "2019-10-9"; // Fourth to last week of the month
        $dateTimestamp = strtotime($date);

        $numberOfWeekFromEndOfMonth = $this->dateHelpers->monthWeekNumberFromTheEnd($dateTimestamp);

        $this->assertEquals(4, $numberOfWeekFromEndOfMonth);
    }

    /** @test */
    public function itShouldReturnFiveSinceTheSpecifiedDayIsInTheFifthToLastWeekOfTheMonth()
    {
        $date = "2019-10-2"; // Fifth to last week of the month
        $dateTimestamp = strtotime($date);

        $numberOfWeekFromEndOfMonth = $this->dateHelpers->monthWeekNumberFromTheEnd($dateTimestamp);

        $this->assertEquals(5, $numberOfWeekFromEndOfMonth);
    }

    /** @test */
    public function itShouldReturnTheDayOfTheMonthFromTheEnd()
    {
        $date = "2010-10-26"; // the 5th to last day of the month
        $dateTimestamp = strtotime($date);

        $dayOfMonthFromTheEnd = $this->dateHelpers->dayOfMonthFromTheEnd($dateTimestamp);
        $this->assertEquals($dayOfMonthFromTheEnd, 5);
    }

    /** @test */
    public function itShouldReturnMonday()
    {
        $repeatWeeklyOn = '1';
        $repeatWeeklyDecoded = $this->dateHelpers->decodeRepeatWeeklyOn($repeatWeeklyOn);
        $this->assertEquals($repeatWeeklyDecoded, 'Monday');
    }

    /** @test */
    public function itShouldReturnWednesday()
    {
        $repeatWeeklyOn = '3';
        $repeatWeeklyDecoded = $this->dateHelpers->decodeRepeatWeeklyOn($repeatWeeklyOn);
        $this->assertEquals($repeatWeeklyDecoded, 'Wednesday');
    }





}
