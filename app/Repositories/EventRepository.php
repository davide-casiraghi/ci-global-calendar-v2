<?php


namespace App\Repositories;

use App\Helpers\CollectionHelper;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class EventRepository implements EventRepositoryInterface
{
    /**
     * Get all Events.
     *
     * @param  int|null  $recordsPerPage
     * @param  array|null  $searchParameters
     * @param  string  $orderDirection sorting direction: 'asc' = from oldest to newest | 'desc' = from newest to oldest
     * @return \App\Models\Event[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null, string $orderDirection = 'asc')
    {
        // Upcoming events are shown first
        $query = Event::select(
                    'events.*',
                    'event_repetitions.start_repeat',
                    'event_repetitions.end_repeat',
                    //'venues.country_id'
                    //'venue.country.continent_id.'
            //, 'venue.country', 'venue.country.continent'
            )
            ->with(['category', 'teachers', 'venue'])
            ->leftJoin('event_repetitions', 'events.id', '=', 'event_repetitions.event_id')
            ->orderBy('event_repetitions.start_repeat', $orderDirection);

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where(
                    'title',
                    'like',
                    '%' . $searchParameters['title'] . '%'
                );
            }
            if (!empty($searchParameters['eventCategoryId'])) {
                $query->where('event_category_id', $searchParameters['eventCategoryId']);
            }
            if (!empty($searchParameters['teacherId'])) {
                $query->whereRelation('teachers', 'teachers.id', '=',  $searchParameters['teacherId']);
            }

            if (!empty($searchParameters['continentId'])) {
                $query->whereRelation('venue.country.continent', 'id', '=',  $searchParameters['continentId']);
            }

            if (!empty($searchParameters['countryId'])) {
                $query->whereRelation('venue', 'country_id', '=',  $searchParameters['countryId']);
            }

            if (!empty($searchParameters['regionId'])) {
                $query->whereRelation('region', 'region_id', '=',  $searchParameters['regionId']);
            }

            if (!empty($searchParameters['startDate'])) {
                $startDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $searchParameters['startDate']
                );
                $query->where('start_repeat', '>=', $startDate);
            }
            if (!empty($searchParameters['endDate'])) {
                $endDate = Carbon::createFromFormat(
                    'd/m/Y',
                    $searchParameters['endDate']
                );
                $query->where('end_repeat', '<=', $endDate);
            }
            if (!is_null($searchParameters['is_published'])) {
                $query->where('is_published', $searchParameters['is_published']);
            }
        }

        // For repetitive events only the upcoming one is shown
        $uniqueResults = $query->get()->unique('id');

        if ($recordsPerPage) {
            $results = CollectionHelper::paginate($uniqueResults, $recordsPerPage)->withQueryString();
        } else {
            $results = $uniqueResults;
        }

        return $results;
    }

    /**
     * Get Event by id
     *
     * @param int $eventId
     * @return Event
     */
    public function getById(int $eventId): Event
    {
        return Event::findOrFail($eventId);
    }

    /**
     * Get Event by slug
     *
     * @param  string  $eventSlug
     * @return Event
     */
    public function getBySlug(string $eventSlug): ?Event
    {
        return Event::where('slug', $eventSlug)->first();
    }

    /**
     * Return the list of the expiring repetitive events (the 7th day from now).
     * Consider just Weekly(2) and Monthly(3) events.
     * It returns just the events expiring the 7th day from now, not the 6th day or less.
     *
     * @return Collection
     */
    public function getRepetitiveExpiringInOneWeek(): Collection
    {
        $query = Event::orderBy('title', 'desc');
        $query->where('repeat_until', '<=', Carbon::today()->addWeek());
        $query->where('repeat_until', '>', Carbon::now()->addWeek()->subDay());
        $query->whereIn('repeat_type', [2, 3]); // Weekly(2), Monthly(3)

        return $query->get();
    }

    /**
     * Store Event
     *
     * @param array $data
     *
     * @return Event
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(array $data): Event
    {
        $event = new Event();
        $event = self::assignDataAttributes($event, $data);

        // Creator - Logged user id or 1 for factories
        $event->user_id = !is_null(Auth::id()) ? Auth::id() : 1;
        // Default 'published'
        $event->is_published = 1;

        $event->save();

        self::syncManyToMany($event, $data);

        return $event->fresh();
    }

    /**
     * Update Event
     *
     * @param array $data
     * @param int $id
     *
     * @return Event
     */
    public function update(array $data, int $id): Event
    {
        $event = $this->getById($id);
        $event = self::assignDataAttributes($event, $data);

        $event->update();

        self::syncManyToMany($event, $data);

        return $event;
    }

    /**
     * Delete Event
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Event::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\Event $event
     * @param array $data
     *
     * @return \App\Models\Event
     */
    public function assignDataAttributes(Event $event, array $data): Event
    {
        $event->event_category_id = $data['event_category_id'];
        $event->venue_id = $data['venue_id'];

        $event->title = $data['title'];
        $event->description = $data['description'];
        $event->contact_email = $data['contact_email'];
        $event->website_event_link = $data['website_event_link'];
        $event->facebook_event_link = $data['facebook_event_link'];
        $event->repeat_type = $data['repeat_type'];
        $event->is_published = (isset($data['is_published'])) ? 1 : 0;

        switch ($data['repeat_type']) {
            case 1: // No Repeat
                $event->repeat_until = null;
                break;
            case 2: // Weekly
                if (array_key_exists('repeat_weekly_on', $data)) {
                    $event->repeat_weekly_on = implode(',', array_keys($data['repeat_weekly_on']));
                }
                $event->repeat_until = Carbon::createFromFormat('d/m/Y', $data['repeat_until']);
                break;
            case 3: // Monthly
                $event->on_monthly_kind = $data['on_monthly_kind'] ?? null;
                $event->repeat_until = Carbon::createFromFormat('d/m/Y', $data['repeat_until']);
                break;
            case 4: // Multiple days
                $event->multiple_dates = $data['multiple_dates'] ?? null;
                $event->repeat_until = null;
                break;
        }

        return $event;
    }


    /**
     * Sync the many-to-many relatioships
     *
     * @param \App\Models\Event $event
     * @param array $data
     *
     * @return void
     */
    public function syncManyToMany(Event $event, array $data): void
    {
        $event->teachers()->sync($data['teacher_ids'] ?? null);
        $event->organizers()->sync($data['organizer_ids'] ?? null);
    }

}
