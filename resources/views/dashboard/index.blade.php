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
