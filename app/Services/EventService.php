<?php

namespace App\Services;

use App\Helpers\DateHelpers;
use App\Helpers\Helper;
use App\Helpers\ImageHelpers;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Repositories\EventRepositoryInterface;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Spatie\CalendarLinks\Link;

class EventService
{
    private EventRepositoryInterface $eventRepository;
    private EventRepetitionService $eventRepetitionService;
    private NotificationService $notificationService;

    /**
     * EventService constructor.
     *
     * @param  EventRepositoryInterface  $eventRepository
     * @param  EventRepetitionService  $eventRepetitionService
     * @param  NotificationService  $notificationService
     */
    public function __construct(
        EventRepositoryInterface $eventRepository,
        EventRepetitionService $eventRepetitionService,
        NotificationService $notificationService
    ) {
        $this->eventRepository = $eventRepository;
        $this->eventRepetitionService = $eventRepetitionService;
        $this->notificationService = $notificationService;
    }

    /**
     * Create a event
     *
     * @param  EventStoreRequest  $request
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createEvent(EventStoreRequest $request): Event
    {
        $event = $this->eventRepository->store($request->all());
        ImageHelpers::storeImages($event, $request, 'introimage');

        $this->eventRepetitionService->updateEventRepetitions($request->all(), $event->id);

        $this->cleanActiveEventsCaches();

        return $event;
    }

    /**
     * Update the Event
     *
     * @param  EventStoreRequest  $request
     * @param  Event  $event
     * @return Event
     */

    public function updateEvent(EventStoreRequest $request, Event $event): Event
    {
        $event = $this->eventRepository->update($request->all(), $event);

        ImageHelpers::storeImages($event, $request, 'introimage');
        ImageHelpers::deleteImages($event, $request, 'introimage');

        $this->eventRepetitionService->updateEventRepetitions($request->all(), $event->id);
        $this->cleanActiveEventsCaches();

        return $event;
    }

    /**
     * Return the event from the database
     *
     * @param int $eventId
     *
     * @return Event
     */
    public function getById(int $eventId): Event
    {
        return $this->eventRepository->getById($eventId);
    }

    /**
     * Return the event from the database by SLUG
     *
     * @param  string  $eventSlug
     * @return Event|null
     */
    public function getBySlug(string $eventSlug): ?Event
    {
        return $this->eventRepository->getBySlug($eventSlug);
    }

    /**
     * Get all the Events.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @param  string  $orderDirection sorting direction: 'asc' = from oldest to newest | 'desc' = from newest to oldest
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getEvents(int $recordsPerPage = null, array $searchParameters = null, string $orderDirection = 'asc')
    {
        return $this->eventRepository->getAll($recordsPerPage, $searchParameters, $orderDirection);
    }

    /**
     * Get all the future Events.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllFutureEvents()
    {
        $searchParameters = [];
        $searchParameters['startDate'] = Carbon::today()->format('d/m/Y');
        $searchParameters['is_published'] = true;

        return $this->eventRepository->getAll(null, $searchParameters);
    }

    /**
     * Delete the event from the database
     *
     * @param int $eventId
     */
    public function deleteEvent(int $eventId): void
    {
        $this->eventRepository->delete($eventId);
        $this->cleanActiveEventsCaches();
    }

    /**
     * Get the number of event created in the last 30 days.
     *
     * @return int
     */
    public function getNumberEventsCreatedLastThirtyDays(): int
    {
        return Event::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Get the number of active events.
     * todo - create a test
     *
     * @return int
     */
    public function getActiveEventsNumber(): int
    {
        $searchParameters = [];
        $searchParameters['startDate'] = Carbon::today()->format('d/m/Y');
        $searchParameters['is_published'] = true;

        $activeEvents = self::getEvents(10, $searchParameters);
        $activeEventsNumber = count($activeEvents);

        return $activeEventsNumber;
    }

    /**
     * Return an array with the event data related to:
     * - date and time start
     * - date and time end
     * - repeat until
     * - multiple dates
     *
     * @param Event $event
     * @param EventRepetition $eventFirstRepetition
     *
     * @return array
     */
    public function getEventDateTimeParameters(Event $event, EventRepetition $eventFirstRepetition): array
    {
        $dateTime = [];
        $dateTime['startDate'] = (isset($eventFirstRepetition->start_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['endDate'] = (isset($eventFirstRepetition->end_repeat)) ? date('d/m/Y', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['startTime'] = (isset($eventFirstRepetition->start_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['endTime'] = (isset($eventFirstRepetition->end_repeat)) ? date('g:i A', strtotime($eventFirstRepetition->end_repeat)) : '';

        /*$dateTime['timeStartHours'] = (isset($eventFirstRepetition->start_repeat)) ? date('g', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeStartMinutes'] = (isset($eventFirstRepetition->start_repeat)) ? date('i', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeStartAmpm'] = (isset($eventFirstRepetition->start_repeat)) ? date('A', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['timeEndHours'] = (isset($eventFirstRepetition->end_repeat)) ? date('g', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['timeEndMinutes'] = (isset($eventFirstRepetition->end_repeat)) ? date('i', strtotime($eventFirstRepetition->end_repeat)) : '';
        $dateTime['timeEndAmpm'] = (isset($eventFirstRepetition->end_repeat)) ? date('A', strtotime($eventFirstRepetition->end_repeat)) : '';*/

/*
        $dateTime['startDateAndTime'] = (isset($eventFirstRepetition->start_repeat)) ? date('d/m/Y h:i A', strtotime($eventFirstRepetition->start_repeat)) : '';
        $dateTime['endDateAndTime'] =(isset($eventFirstRepetition->start_repeat)) ? date('d/m/Y h:i A', strtotime($eventFirstRepetition->end_repeat)) : '';
*/
        $dateTime['repeatUntil'] = is_null($event->repeat_until) ? null : date('d/m/Y', strtotime($event->repeat_until));
        $dateTime['multipleDates'] = $event->multiple_dates;

        return $dateTime;
    }

    /**
     * Return the HTML of the monthly select dropdown - inspired by - https://www.theindychannel.com/calendar
     * - Used by the AJAX in the event repeat view -
     * - The HTML contain a <select></select> with four <options></options>.
     *
     * @param string $date
     *
     * @return string
     */
    public function getMonthlySelectOptions(string $date): string
    {
        $monthlySelectOptions = [];
        $date = implode('-', array_reverse(explode('/', $date)));  // Our YYYY-MM-DD date string
        $unixTimestamp = strtotime($date);  // Convert the date string into a unix timestamp.
        $dayOfWeekString = date('l', $unixTimestamp); // Monday | Tuesday | Wednesday | ..

        // Add option: Same day number.
        // eg. "the 28th day of the month"
        $dateArray = explode('-', $date);
        $dayNumber = ltrim($dateArray[2], '0'); // remove the 0 in front of a day number eg. 02/10/2018

        $format = __('ordinalDays.the_' . ($dayNumber) . '_x_of_the_month');
        $repeatText = sprintf($format, 'day');

        array_push($monthlySelectOptions, [
            'value' => '0|' . $dayNumber,
            'text' => $repeatText,
        ]);

        // Add option: Same weekday/week of the month.
        // eg. the "1st Monday" 1|1|1 (first week, monday)
        $dayOfWeekValue = date('N', $unixTimestamp); // 1 (for Monday) through 7 (for Sunday)
        $weekOfTheMonth = DateHelpers::monthWeekNumber($date, $dayOfWeekValue); // 1 | 2 | 3 | 4 | 5

        $format = __('ordinalDays.the_' . ($weekOfTheMonth) . '_x_of_the_month');
        $repeatText = sprintf($format, $dayOfWeekString);

        array_push($monthlySelectOptions, [
            'value' => '1|' . $weekOfTheMonth . '|' . $dayOfWeekValue,
            'text' => $repeatText,
        ]);

        // Add option: Same day of the month (from the end).
        // eg. "the 3rd to last day of the month" (0 if last day, 1 if 2nd to last day, , 2 if 3rd to last day)
        $dayOfMonthFromTheEnd = DateHelpers::dayOfMonthFromTheEnd($unixTimestamp); // 1 | 2 | 3 | 4 | 5

        $format = __('ordinalDays.the_'.($dayOfMonthFromTheEnd + 1).'_to_last_x_of_the_month');
        $repeatText = sprintf($format, 'day');

        array_push($monthlySelectOptions, [
            'value' => '2|'.$dayOfMonthFromTheEnd,
            'text' => $repeatText,
        ]);

        // Add option: Same weekday/week of the month (from the end).
        // eg. the last Friday - (0 if last Friday, 1 if the 2nd to last Friday, 2 if the 3nd to last Friday)
        $monthWeekNumberFromTheEnd = DateHelpers::monthWeekNumberFromTheEnd($unixTimestamp); // 1 | 2 | 3 | 4 | 5

        if ($monthWeekNumberFromTheEnd == 1) {
            $weekValue = 0;
        } else {
            $weekValue = $monthWeekNumberFromTheEnd - 1;
        }

        $format = __('ordinalDays.the_' . ($monthWeekNumberFromTheEnd) . '_to_last_x_of_the_month');
        $repeatText = sprintf($format, $dayOfWeekString);

        array_push($monthlySelectOptions, [
            'value' => '3|' . $weekValue . '|' . $dayOfWeekValue,
            'text' => $repeatText,
        ]);

        // GENERATE the HTML to return
        $selectTitle = __('general.select_repeat_monthly_kind');
        $onMonthlyKindSelect = "<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='".$selectTitle."'>";
        foreach ($monthlySelectOptions as $key => $monthlySelectOption) {
            $onMonthlyKindSelect .= "<option value='".$monthlySelectOption['value']."'>".$monthlySelectOption['text'].'</option>';
        }
        $onMonthlyKindSelect .= '</select>';

        return $onMonthlyKindSelect;
    }

    /**
     * Return a string that describe repetition kind in the event show view.
     *
     * @param  Event  $event
     * @param \App\Models\EventRepetition $firstRpDates
     *
     * @return string $ret
     * @throws \Exception
     */
    public static function getRepetitionTextString(Event $event, EventRepetition $firstRpDates): string
    {
        $ret = '';

        switch ($event->repeat_type) {
            case '1': // noRepeat
                $dateStart = date('d/m/Y', strtotime($firstRpDates->start_repeat));
                $dateEnd = date('d/m/Y', strtotime($firstRpDates->end_repeat));

                if ($dateStart == $dateEnd) {
                    $ret = $dateStart;
                } else {
                    $ret = "From {$dateStart} to {$dateEnd}";
                }
                break;
            case '2': // repeatWeekly
                $repeatUntil = new DateTime($event->repeat_until);

                // Get the name of the weekly day when the event repeat, if two days, return like "Thursday and Sunday"
                $repetitonWeekdayNumbersArray = explode(',', $event->repeat_weekly_on);

                $repetitonWeekdayNamesArray = [];
                foreach ($repetitonWeekdayNumbersArray as $key => $repetitonWeekdayNumber) {
                    $repetitonWeekdayNamesArray[] = DateHelpers::decodeRepeatWeeklyOn($repetitonWeekdayNumber);
                }
                // create from an array a string with all the values divided by " and "
                $nameOfTheRepetitionWeekDays = implode(' and ', $repetitonWeekdayNamesArray);

                //$ret = 'The event happens every '.$nameOfTheRepetitionWeekDays.' until '.$repeatUntil->format('d/m/Y');
                $format = __('event.the_event_happens_every_x_until_x');
                $ret .= sprintf($format, $nameOfTheRepetitionWeekDays, $repeatUntil->format('d/m/Y'));
                break;
            case '3': //repeatMonthly
                $repeatUntil = new DateTime($event->repeat_until);
                $repetitionFrequency = self::decodeOnMonthlyKind($event->on_monthly_kind);

                //$ret = 'The event happens '.$repetitionFrequency.' until '.$repeatUntil->format('d/m/Y');
                $format = __('event.the_event_happens_x_until_x');
                $ret .= sprintf($format, $repetitionFrequency, $repeatUntil->format('d/m/Y'));
                break;
            case '4': //repeatMultipleDays
                $dateStart = date('d/m/Y', strtotime($firstRpDates->start_repeat));
                $singleDaysRepeatDatas = explode(', ', $event->multiple_dates);

                // Sort the datas
                usort($singleDaysRepeatDatas, function ($a, $b) {
                    $a = Carbon::createFromFormat('d/m/Y', $a);
                    $b = Carbon::createFromFormat('d/m/Y', $b);

                    return strtotime($a) - strtotime($b);
                });

                $ret .= __('event.the_event_happens_on_this_dates');
                $ret .= $dateStart . ', ';
                $ret .= Helper::getStringFromArraySeparatedByComma($singleDaysRepeatDatas);
                break;
        }

        return $ret;
    }

    /**
     * Return a string that describe the report misuse reason.
     *
     * @param  int $reason
     * @return string $ret
     */
    public static function getReportMisuseReasonDescription(int $reason): string
    {
        $ret = '';
        switch ($reason) {
            case '1':
                $ret = 'Not about Contact Improvisation';
                break;
            case '2':
                $ret = 'Contains wrong information';
                break;
            case '3':
                $ret = 'It is not translated in english';
                break;
            case '4':
                $ret = 'Other (specify in the message)';
                break;
        }

        return $ret;
    }

    /**
     * Decode the event on_monthly_kind field - used in event.show.
     * Return a string like "the 4th to last Thursday of the month".
     *
     * @param  string $onMonthlyKindCode
     * @return string
     */
    public static function decodeOnMonthlyKind(string $onMonthlyKindCode): string
    {
        $ret = '';
        $onMonthlyKindCodeArray = explode('|', $onMonthlyKindCode);
        $weekDays = [
            '',
            __('general.monday'),
            __('general.tuesday'),
            __('general.wednesday'),
            __('general.thursday'),
            __('general.friday'),
            __('general.saturday'),
            __('general.sunday'),
        ];

        switch ($onMonthlyKindCodeArray[0]) {
            case '0':  // 0|7 eg. the 7th day of the month
                $dayNumber = $onMonthlyKindCodeArray[1];
                $format = __("ordinalDays.the_{$dayNumber}_x_of_the_month");
                $ret = sprintf($format, __('general.day'));
                break;
            case '1':  // 1|2|4 eg. the 2nd Thursday of the month
                $dayNumber = $onMonthlyKindCodeArray[1];
                $weekDay = $weekDays[$onMonthlyKindCodeArray[2]]; // Monday, Tuesday, Wednesday
                $format = __("ordinalDays.the_{$dayNumber}_x_of_the_month");
                $ret = sprintf($format, $weekDay);
                break;
            case '2': // 2|20 eg. the 21st to last day of the month
                $dayNumber = (int) $onMonthlyKindCodeArray[1] + 1;
                $format = __("ordinalDays.the_{$dayNumber}_to_last_x_of_the_month");
                $ret = sprintf($format, __('general.day'));
                break;
            case '3': // 3|3|4 eg. the 4th to last Thursday of the month
                $dayNumber = (int) $onMonthlyKindCodeArray[1] + 1;
                $weekDay = $weekDays[$onMonthlyKindCodeArray[2]]; // Monday, Tuesday, Wednesday
                $format = __("ordinalDays.the_{$dayNumber}_to_last_x_of_the_month");
                $ret = sprintf($format, $weekDay);
                break;
        }

        return $ret;
    }

    /**
     * Return the list of the expiring repetitive events (the 7th day from now).
     * When the cache parameter is true, get them from the cache.
     *
     * The cache tag get invalidated once a day and also on event save, update and delete.
     * Using the function cleanActiveEventsCaches()
     * To empty the cache you can run a 'php artisan cache:clear'
     *
     * @param bool $cached
     *
     * @return Collection
     */
    public function getRepetitiveEventsExpiringInOneWeek(bool $cached): Collection
    {
        if (!$cached) {
            return $this->eventRepository->getRepetitiveExpiringInOneWeek();
        }

        $cacheTag = 'active_events';
        $seconds = 86400; // One day
        return Cache::remember($cacheTag, $seconds, function () {
            return $this->eventRepository->getRepetitiveExpiringInOneWeek();
        });
    }

    /**
     * Email the users which repetitive events are expiring.
     *
     * @return string
     */
    public function sendEmailToExpiringEventsOrganizers(): string
    {
        $data = [];
        $data['emailFrom'] = env('ADMIN_MAIL');
        $data['senderName'] = 'CI Global Calendar Administrator';

        $expiringRepetitiveEvents = self::getRepetitiveEventsExpiringInOneWeek(true);
        foreach ($expiringRepetitiveEvents as $key => $event) {
            $this->notificationService->sendEmailExpiringEvent($data, $event);
        }

        $message = $expiringRepetitiveEvents->isEmpty() ?
            'No events were expiring'
            : count($expiringRepetitiveEvents) . ' events were expiring, mails sent to the organizers.';

        Log::notice($message);
        return $message;
    }

    /**
     * Invalidate the cache tags related to active events.
     *
     * @return void
     */
    public function cleanActiveEventsCaches(): void
    {
        Cache::forget('active_events');
        //Cache::forget('active_events_map_markers_json');
        //Cache::forget('active_events_map_markers_db_data');
    }

    /**
     * Generate a link to create an event on Google calendar.
     *
     * @param  Event  $event
     * @return Link|null
     */
    public function getCalendarLink(Event $event): ?Link
    {
        try {
            $from = Carbon::createFromFormat('Y-m-d H:i:s',
                $event->repetitions()->first()->start_repeat);// TODO not first repetition!
            $to = Carbon::createFromFormat('Y-m-d H:i:s',
                $event->repetitions()->first()->end_repeat);// TODO not first repetition!
            $link = Link::create($event->title, $from, $to)
                ->description($event->description)
                ->address($event->venue->address.', '.
                    $event->venue->city.', '.
                    $event->venue->zip_code.', '.
                    $event->venue->state_province.', '.
                    $event->venue->country->code
                );
            return $link;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Return event count by country.
     *
     * @return Collection
     */
    public function activeEventsCountByCountry(): Collection
    {
        return $this->eventRepository->activeEventsCountByCountry();
    }

}
