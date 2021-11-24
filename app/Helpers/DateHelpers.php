<?php

namespace App\Helpers;

/*
 * How to use one of this helper functions:
 *
 * In a blade template:
 * {!! DateHelpers::cleanStringSpaces('this is how to use') !!}
 *
 * Anywhere else in your Laravel app:
 * DateHelpers::cleanStringSpaces('this is how to use');
 *
 * https://stackoverflow.com/questions/28290332/best-practices-for-custom-helpers-in-laravel-5#32772686
 *
 */

class DateHelpers
{

    /**
     * Check the date and return true if the weekday is the one specified in $dayOfTheWeek.
     *
     * eg. if $dayOfTheWeek = 3, is true if the $date is a Wednesday
     * $dayOfTheWeek: 1|2|3|4|5|6|7 (MONDAY-SUNDAY)
     * https://stackoverflow.com/questions/2045736/getting-all-dates-for-mondays-and-tuesdays-for-the-next-year.
     *
     * @param  string $date
     * @param  int $dayOfTheWeek  (Y-m-d)
     * @return bool
     */
    public static function isSpecifiedWeekDay(string $date, int $dayOfTheWeek): bool
    {
        // Fix the bug that was avoiding to save Sunday. Date 'w' identify sunday as 0 and not 7.
        if ($dayOfTheWeek == 7) {
            $dayOfTheWeek = 0;
        }

        return date('w', strtotime($date)) == $dayOfTheWeek;
    }

    /**
     * Return the number of the week (1|2|3|4|5) in the month of the weekday specified.
     *
     * $dateTimestamp - unix timestamp of the date specified
     * $dayOfWeekValue -  1 (for Monday) through 7 (for Sunday)
     *
     * @param  string $dateTimestamp
     * @param  string $dayOfWeekValue
     * @return int
     */
    public static function monthWeekNumber(string $dateTimestamp, string $dayOfWeekValue): int
    {
        $cut = substr($dateTimestamp, 0, 8);
        $daylen = 86400;
        $timestamp = strtotime($dateTimestamp);
        $first = strtotime($cut . '01');
        $elapsed = (($timestamp - $first) / $daylen) + 1;
        $weeks = 0;
        for ($i = 1; $i <= $elapsed; $i++) {
            $dayFind = $cut . (strlen((string) $i) < 2 ? '0' . $i : $i);
            $dayTimestamp = strtotime($dayFind);
            $day = strtolower(date('N', $dayTimestamp));
            if ($day == strtolower($dayOfWeekValue)) {
                $weeks++;
            }
        }
        if ($weeks == 0) {
            $weeks++;
        }

        return $weeks;
    }

    /**
     * GET number of week from the end of the month
     *
     * https://stackoverflow.com/questions/5853380/php-get-number-of-week-for-month
     *
     * Week of the month = Week of the year - Week of the year of first day of month + 1.
     *
     * @param int $dateTimestamp
     *
     * @return int
     */
    public static function monthWeekNumberFromTheEnd(int $dateTimestamp): int
    {
        $numberOfDayOfTheMonth = strftime('%e', $dateTimestamp); // Day of the month 1-31
        $lastDayOfMonth = strftime('%e', strtotime(date('Y-m-t', $dateTimestamp)));

        $dayDifference = (int) $lastDayOfMonth - (int) $numberOfDayOfTheMonth;

        switch (true) {
            case $dayDifference < 7:
                $weekFromTheEnd = 1;
                break;

            case $dayDifference < 14:
                $weekFromTheEnd = 2;
                break;

            case $dayDifference < 21:
                $weekFromTheEnd = 3;
                break;

            case $dayDifference < 28:
                $weekFromTheEnd = 4;
                break;

            default:
                $weekFromTheEnd = 5;
                break;
        }

        return $weekFromTheEnd;
    }

    /**
     * Return the number of day of the month from end
     *
     * @param int $dateTimestamp
     *
     * @return int
     */
    public static function dayOfMonthFromTheEnd(int $dateTimestamp): int
    {
        $numberOfDayOfTheMonth = strftime('%e', $dateTimestamp); // Day of the month 1-31
        $lastDayOfMonth = strftime('%e', strtotime(date('Y-m-t', $dateTimestamp)));
        $dayDifference = (int) $lastDayOfMonth - (int) $numberOfDayOfTheMonth;

        return $dayDifference;
    }

    /**
     * Decode the event repeat_weekly_on field - used in event.show.
     * Return a string like "Monday".
     *
     * @param  string $repeatWeeklyOn
     * @return string
     */
    public static function decodeRepeatWeeklyOn(string $repeatWeeklyOn): string
    {
        $weekdayArray = [
            '',
            __('general.monday'),
            __('general.tuesday'),
            __('general.wednesday'),
            __('general.thursday'),
            __('general.friday'),
            __('general.saturday'),
            __('general.sunday'),
        ];
        $ret = $weekdayArray[$repeatWeeklyOn];

        return $ret;
    }



}