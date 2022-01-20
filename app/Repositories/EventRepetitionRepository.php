<?php


namespace App\Repositories;

use App\Helpers\DateHelpers;
use App\Models\EventRepetition;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class EventRepetitionRepository implements EventRepetitionRepositoryInterface
{

    /**
     * Get all EventRepetitions.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return EventRepetition::all();
    }

    /**
     * Get EventRepetition by id.
     *
     * @param int $eventRepetitionId
     * @return EventRepetition
     */
    public function getById(int $eventRepetitionId): EventRepetition
    {
        return EventRepetition::findOrFail($eventRepetitionId);
    }

    /**
     * Get the event first repetition of this event.
     * If the future variable is true, it returns the first repetition of this event in the future.
     *
     * @param int $eventId
     *
     * @return EventRepetition
     */
    public function getFirstByEventId(int $eventId, bool $future = false): EventRepetition
    {
        $query = EventRepetition::select('id', 'start_repeat', 'end_repeat')
                ->where('event_id', '=', $eventId);
        if($future){
            $query->where('start_repeat', '>=', Carbon::today());
        }

        return $query->first();
    }

    /**
     * Store EventRepetition.
     *
     * $dateStart and $dateEnd are in the format Y-m-d
     * $timeStart and $timeEnd are in the format H:i:s.
     *
     * @param  int $eventId
     * @param  string $dateStart
     * @param  string $dateEnd
     * @param  string $timeStart
     * @param  string $timeEnd
     *
     * @return \App\Models\EventRepetition
     */
    public static function store(int $eventId, string $dateStart, string $dateEnd, string $timeStart, string $timeEnd): EventRepetition
    {
        $eventRepetition = new EventRepetition();
        $eventRepetition->event_id = $eventId;
        //dd($timeStart);
        //dd($dateStart . ' ' . $timeStart);
        $eventRepetition->start_repeat = Carbon::createFromFormat('Y-m-d H:i:s', $dateStart . ' ' . $timeStart);
        $eventRepetition->end_repeat = Carbon::createFromFormat('Y-m-d H:i:s', $dateEnd . ' ' . $timeEnd);

        $eventRepetition->save();

        return $eventRepetition->fresh();
    }


    /**
     * To save event repetitions for create and update methods.
     *
     * @param array $data
     * @param int $eventId
     *
     * @return void
     */
    public function updateEventRepetitions(array $data, int $eventId): void
    {
        self::deletePreviousRepetitions($eventId);
        //dd($data);

        //$timeStart = date('H:i:s', strtotime($data['timeStartHours'].':'.$data['timeStartMinutes'].' '.$data['timeStartAmpm']));
        //$timeEnd = date('H:i:s', strtotime($data['timeEndHours'].':'.$data['timeEndMinutes'].' '.$data['timeEndAmpm']));

        $timeStart = date('H:i:s',strtotime($data['startTime']));
        $timeEnd = date('H:i:s',strtotime($data['endTime']));
        //dd($timeStart);
        //$timeStart = date('H:i:s', strtotime(explode(' ', $data['startDateAndTime'], 2)[1]));
        //$timeEnd = date('H:i:s', strtotime(explode(' ', $data['endDateAndTime'], 2)[1]));

        //dd($timeStart2);

        switch ($data['repeat_type']) {
            case '1':  // noRepeat
                $eventRepetition = new EventRepetition();
                $eventRepetition->event_id = $eventId;

                $dateStart = implode('-', array_reverse(explode('/', $data['startDate'])));
                //$dateStart = implode('-', array_reverse(explode('/', strtok($data['startDateAndTime'],  ' '))));

                $dateEnd = implode('-', array_reverse(explode('/', $data['endDate'])));
                //$dateEnd = implode('-', array_reverse(explode('/', strtok($data['endDateAndTime'],  ' '))));

                $eventRepetition->start_repeat = $dateStart . ' ' . $timeStart;
                $eventRepetition->end_repeat = $dateEnd . ' ' . $timeEnd;
                $eventRepetition->save();

                break;

            case '2':   // repeatWeekly
                // Convert the start date in a format that can be used for strtotime
                $startDate = implode('-', array_reverse(explode('/', $data['startDate'])));
                //$startDate = implode('-', array_reverse(explode('/', strtok($data['startDateAndTime'],  ' '))));

                // Calculate repeat until day
                $repeatUntilDate = implode('-', array_reverse(explode('/', $data['repeat_until'])));
                self::saveWeeklyRepeatDates($eventId, array_keys($data['repeat_weekly_on']), $startDate, $repeatUntilDate, $timeStart, $timeEnd);

                break;

            case '3':  //repeatMonthly
                // Same of repeatWeekly
                $startDate = implode('-', array_reverse(explode('/', $data['startDate'])));
                //$startDate = implode('-', array_reverse(explode('/', strtok($data['startDateAndTime'],  ' '))));
                $repeatUntilDate = implode('-', array_reverse(explode('/', $data['repeat_until'])));

                // Get the array with month repeat details
                $monthRepeatDatas = explode('|', $data['on_monthly_kind']);
                self::saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

                break;

            case '4':  //repeatMultipleDays
                // Same of repeatWeekly
                $startDate = implode('-', array_reverse(explode('/', $data['startDate'])));
                //$startDate = implode('-', array_reverse(explode('/', strtok($data['startDateAndTime'],  ' '))));

                // Get the array with single day repeat details
                $singleDaysRepeatDatas = explode(',', $data['multiple_dates']);

                self::saveMultipleRepeatDates($eventId, $singleDaysRepeatDatas, $startDate, $timeStart, $timeEnd);

                break;
        }
    }

    /**
     * Delete EventRepetition
     *
     * @param int $id
     * @return void
     */
    /*public function delete(int $id)
    {
        EventRepetition::destroy($id);
    }*/


    /**
     * Delete all the previous repetitions from the event_repetitions table.
     *
     * @param int $eventId
     * @return void
     */
    public static function deletePreviousRepetitions($eventId): void
    {
        EventRepetition::where('event_id', $eventId)->delete();
        //self::where('event_id', $eventId)->delete();
    }

    /**
     * Save all the weekly repetitions in the event_repetitions table.
     * $dateStart and $dateEnd are in the format Y-m-d
     * $timeStart and $timeEnd are in the format H:i:s.
     * $weekDays - $request->get('repeat_weekly_on_day').
     * @param  int $eventId
     * @param  array  $weekDays
     * @param  string  $startDate
     * @param  string  $repeatUntilDate
     * @param  string  $timeStart
     * @param  string  $timeEnd
     * @return void
     */
    public static function saveWeeklyRepeatDates(int $eventId, array $weekDays, string $startDate, string $repeatUntilDate, string $timeStart, string $timeEnd): void
    {
        $beginPeriod = Carbon::createFromFormat('Y-m-d', $startDate);
        $endPeriod = Carbon::createFromFormat('Y-m-d', $repeatUntilDate);
        //$interval = CarbonInterval::days(1);
        $interval = CarbonInterval::make('1day');
        $period = CarbonPeriod::create($beginPeriod, $interval, $endPeriod);
        foreach ($period as $day) {  // Iterate for each day of the period
            foreach ($weekDays as $weekDayNumber) { // Iterate for every day of the week (1:Monday, 2:Tuesday, 3:Wednesday ...)
                if (DateHelpers::isSpecifiedWeekDay($day->format('Y-m-d'), $weekDayNumber)) {
                    self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);
                }
            }
        }
    }

    /**
     * Save all the weekly repetitions in the event_repetitions table
     * useful: http://thisinterestsme.com/php-get-first-monday-of-month/.
     *
     * @param  int  $eventId
     * @param  array   $monthRepeatDatas - explode of $request->get('on_monthly_kind')
     *                      0|28 the 28th day of the month
     *                      1|2|2 the 2nd Tuesday of the month
     *                      2|17 the 18th to last day of the month
     *                      3|1|3 the 2nd to last Wednesday of the month
     * @param  string  $startDate (Y-m-d)
     * @param  string  $repeatUntilDate (Y-m-d)
     * @param  string  $timeStart (H:i:s)
     * @param  string  $timeEnd (H:i:s)
     * @return void
     */
    public static function saveMonthlyRepeatDates(int $eventId, array $monthRepeatDatas, string $startDate, string $repeatUntilDate, string $timeStart, string $timeEnd): void
    {
        $month = Carbon::createFromFormat('Y-m-d', $startDate);
        $end = Carbon::createFromFormat('Y-m-d', $repeatUntilDate);
        $weekdayArray = [Carbon::MONDAY, Carbon::TUESDAY, Carbon::WEDNESDAY, Carbon::THURSDAY, Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY];

        switch ($monthRepeatDatas[0]) {
            case '0':  // Same day number - eg. "the 28th day of the month"
                while ($month < $end) {
                    $day = $month;
                    self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);
                    $month = $month->addMonth();
                }
                break;
            case '1':  // Same weekday/week of the month - eg. the "1st Monday"
                $numberOfTheWeek = $monthRepeatDatas[1]; // eg. 1(first) | 2(second) | 3(third) | 4(fourth) | 5(fifth)
                $weekday = $weekdayArray[$monthRepeatDatas[2] - 1]; // eg. monday | tuesday | wednesday

                while ($month < $end) {
                    $month_number = (int) Carbon::parse($month)->isoFormat('M');
                    $year_number = (int) Carbon::parse($month)->isoFormat('YYYY');
                    $day = Carbon::create($year_number, $month_number, 1, 0, 0, 0)->nthOfMonth($numberOfTheWeek, $weekday);  // eg. Carbon::create(2014, 5, 30, 0, 0, 0)->nthOfQuarter(2, Carbon::SATURDAY);

                    self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);

                    $month = $month->addMonth();
                }
                break;
            case '2':  // Same day of the month (from the end) - the 3rd to last day (0 if last day, 1 if 2nd to last day, 2 if 3rd to last day)
                $dayFromTheEnd = $monthRepeatDatas[1];
                while ($month < $end) {
                    $month_number = (int) Carbon::parse($month)->isoFormat('M');
                    $year_number = (int) Carbon::parse($month)->isoFormat('YYYY');

                    $day = Carbon::create($year_number, $month_number, 1, 0, 0, 0)->lastOfMonth()->subDays($dayFromTheEnd);

                    self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);
                    $month = $month->addMonth();
                }
                break;
            case '3':  // Same weekday/week of the month (from the end) - the last Friday - (0 if last Friday, 1 if the 2nd to last Friday, 2 if the 3nd to last Friday)
                $weekday = $weekdayArray[$monthRepeatDatas[2] - 1]; // eg. monday | tuesday | wednesday
                $weeksFromTheEnd = $monthRepeatDatas[1];

                while ($month < $end) {
                    $month_number = (int) Carbon::parse($month)->isoFormat('M');
                    $year_number = (int) Carbon::parse($month)->isoFormat('YYYY');

                    $day = Carbon::create($year_number, $month_number, 1, 0, 0, 0)->lastOfMonth($weekday)->subWeeks($weeksFromTheEnd);
                    //dump("ee_2");
                    self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);
                    $month = $month->addMonth();
                }
                break;
        }
    }

    /**
     * Save multiple single dates in the event_repetitions table
     * useful: http://thisinterestsme.com/php-get-first-monday-of-month/.
     * $singleDaysRepeatDatas - explode of $request->get('multiple_dates') - eg. ["19/03/2020","20/05/2020","29/05/2020"]
     * $startDate (Y-m-d)
     * $timeStart (H:i:s)
     * $timeEnd (H:i:s).
     *
     * @param  int  $eventId
     * @param  array   $singleDaysRepeatDatas
     * @param  string  $startDate
     * @param  string  $timeStart
     * @param  string  $timeEnd
     * @return void
     */
    public static function saveMultipleRepeatDates(int $eventId, array $singleDaysRepeatDatas, string $startDate, string $timeStart, string $timeEnd): void
    {
        $day = Carbon::createFromFormat('Y-m-d', $startDate);

        self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);

        foreach ($singleDaysRepeatDatas as $key => $singleDayRepeatDatas) {
            $day = Carbon::createFromFormat('d/m/Y', $singleDayRepeatDatas);

            self::store($eventId, $day->format('Y-m-d'), $day->format('Y-m-d'), $timeStart, $timeEnd);
        }
    }
}
