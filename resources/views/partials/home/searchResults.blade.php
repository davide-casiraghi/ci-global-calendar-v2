{{-- RESULTS of the homepage event search form --}}


{{-- List of events --}}
@isset($events)

    {{-- Results counter --}}
    @if(count($events)>0)
        <a id="dataarea"></a> {{-- Anchor to scroll on search --}}
        <div class="md:grid md:grid-cols-12 mt-5">
            <div class="col-span-7 md:col-span-9"></div>
            <div class="col-span-5 md:col-span-3 bg-gray-50 text-right py-1 px-2">
                <small>{{$events->total()}} @lang('homepage-search.results_found')</small>
            </div>
        </div>
    @endif

    {{-- Event List --}}
    @include('partials.events.list')

    {{-- Paginator --}}
    @if(count($events)>0)
        <div class="my-5">
            {{--{{ $events->links() }}--}}
            {{ $events->appends([
                    'eventCategoryId' => $searchParameters['eventCategoryId'] ?? '',
                    'continentId' => $searchParameters['continentId'] ?? '',
                    'countryId' => $searchParameters['countryId'] ?? '',
                    'regionId' => $searchParameters['regionId'] ?? '',
                    'teacherId' => $searchParameters['teacherId'] ?? '',
                    'startDate' => $searchParameters['startDate'] ?? '',
                    'endDate' => $searchParameters['endDate'] ?? '',
                    'btn_submit' => '',
                    //'city_name' => $searchCity,
                    //  'venue_name' => $searchVenue,
                ])->fragment('dataarea')->links()
            }}

        </div>
    @endif
@endisset