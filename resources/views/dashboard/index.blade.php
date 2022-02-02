@extends('layouts.backend')

@section('title')
    Dashboard
@endsection


@section('javascript')
    @parent

    <script>
        const chart1 = new Chartisan({
            el: '#chartSummaryChart',
            url: "@chart('summary_chart')",
            hooks: new ChartisanHooks()
                .datasets([{ type: 'line', fill: false }])
                .title('Summary chart')
                .legend({ position: 'bottom' })
                .responsive(true)
                //.beginAtZero(true)
                .colors(['#2669A0', '#a12d97', '#e8af17', '#297446'])
                .borderColors(['#2669A0', '#a12d97', '#e8af17', '#297446']),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        const chart2 = new Chartisan({
            el: '#chartUsersByCountry',
            url: "@chart('users_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors(['#2669A0'])
                .borderColors(['#2669A0'])
                .datasets([{ type: 'bar', fill: false }])
                .title('Users by country')
                .responsive(true)
                .beginAtZero(true),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        //todo - check this good example for documentation.
        //https://github.com/Chartisan/Chartisan/issues/7#issuecomment-774745067
        // version 3.0 - https://www.chartjs.org/docs/latest/getting-started/v3-migration.html
        const chart3 = new Chartisan({
            el: '#chartTeachersByCountry',
            url: "@chart('teachers_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors(['#e8af17'])
                .borderColors(['#e8af17'])
                .datasets([{ type: 'bar', fill: false }])
                .title('Teachers by country')
                .responsive(true)
                .beginAtZero(true)
                .options({  //https://chartisan.dev/documentation/frontend/hooks#Chartisan-hooks

                }),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        const chart4 = new Chartisan({
            el: '#chartEventsByCountry',
            url: "@chart('events_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors(['#297446'])
                .borderColors(['#297446'])
                .datasets([{ type: 'bar', fill: false }])
                .title('Active events by country')
                .responsive(true)
                .beginAtZero(true),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });



    </script>
@stop

@section('content')

    <!-- STATS -->
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Last 30 days
        </h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg relative">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Published Insights
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{--{{$totalInsights}}--}}
                    </dd>
                </div>

                {{-- change percentage --}}
                <div class="absolute top-5 right-5 inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
                        Increased by
                    </span>
                    12%
                </div>
            </div>

            <div class="relative bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Published Posts
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{$totalPosts}}
                    </dd>
                </div>

                {{-- change percentage --}}
                <div class="absolute top-5 right-5 inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
                        Increased by
                    </span>
                    12%
                </div>
            </div>

            <div class="relative bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Published Testimonials
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{--{{$totalTestimonials}}--}}
                    </dd>
                </div>

                {{-- change percentage --}}
                <div class="absolute top-5 right-5 inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                    <!-- Heroicon name: solid/arrow-sm-up -->
                    <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
                        Increased by
                    </span>
                    12%
                </div>
            </div>
        </dl>
    </div>

    @ray($lastUpdateStatistics)


    @include('partials.statistics.lastUpdatedStatisticTable')

    {{-- Summary chart container --}}
    <div id="chartSummaryChart" style="height: 300px;"></div>

    {{-- Users by country container --}}
    <div id="chartUsersByCountry" class="mt-8" style="height: 300px;"></div>

    {{-- Teachers by country container --}}
    <div id="chartTeachersByCountry" class="mt-8" style="height: 300px;"></div>

    {{-- Events by country container --}}
    <div id="chartEventsByCountry" class="mt-8" style="height: 300px;"></div>
@endsection
