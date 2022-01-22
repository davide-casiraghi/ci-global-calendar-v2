<?php

namespace App\Services;

use App\Repositories\EventRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class GeomapService
{
    private EventRepositoryInterface $eventRepository;

    /**
     * GeomapService constructor.
     *
     * @param  EventRepositoryInterface  $eventRepository
     */
    public function __construct(
        EventRepositoryInterface $eventRepository,
    ) {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Return event count by country.
     *
     * @return Collection
     */
    public function getGeomapEvents(): Collection
    {
        /*$seconds = 86400; // One day (this cache tag get invalidates also on event save)
        $ret = Cache::remember('active_events_map_markers_db_data', $seconds, function () {
            date_default_timezone_set('Europe/Rome');
            $searchStartDate = Carbon::now()->format('Y-m-d');

            return $this->eventRepository->getActiveEventsMapMarkersData();
        });
        */

        /* EVERY TIME THIS QUERY CHANGE REMEMBER TO FLUSH THE CACHE
            (php artisan cache:clear) */

        return $this->eventRepository->getActiveEventsMapMarkersData();
    }


    /**
     * Return the json to pass to the Leaflet map for the GeoMap.
     *
     * @param Collection $geomapEvents
     * @return false|string
     */
    public static function getGeomapLeafletJson(Collection $geomapEvents)
    {
        $eventsLeafletData = [];
        foreach ($geomapEvents as $key => $event) {

            // Generates event link
            //$eventLinkFormat = 'event/%s/%s';   //event/{{$event->slug}}/{{$event->rp_id}}
            //$eventLink = sprintf($eventLinkFormat, $event->event_slug, $event->first_rp_id);

            $eventLinkFormat = 'events/%s';   //event/{{$event->slug}}/{{$event->rp_id}}
            $eventLink = sprintf($eventLinkFormat, $event->event_slug);

            // Get Next event occurrence date
            $nextDate = Carbon::parse($event->first_rp_start_date)->isoFormat('D MMM YYYY');

            // Add one element to the Geo array
            $eventsLeafletData[] = [
                'type' => 'Feature',
                'id' => $event->id,
                'properties' => [
                    'Title' => $event->title,
                    'Category' => $event->category->name,
                    'VenueName' => $event->venue->name,
                    'City' => $event->city ?? '',
                    'Address' => $event->address ?? '',
                    'Link' => $eventLink,
                    'NextDate' => $nextDate,
                    'IconColor' => 'greenIcon',
                    //'IconColor' => LaravelEventsCalendar::getMapMarkerIconColor($event->category_id),
                ],
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$event->lng, $event->lat],
                ],
            ];
        }
        return json_encode($eventsLeafletData);
    }





}