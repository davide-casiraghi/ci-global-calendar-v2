@extends('layouts.backend')

@section('javascript')
    @parent
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <!-- Your application script -->
    <script>
        const chart1 = new Chartisan({
            el: '#chartSummaryChart',
            url: "@chart('summary_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'line', fill: false }]),
                //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        const chart2 = new Chartisan({
            el: '#chartUsersByCountry',
            url: "@chart('users_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'bar', fill: false }]),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        const chart3 = new Chartisan({
            el: '#chartTeachersByCountry',
            url: "@chart('teachers_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'bar', fill: false }]),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });
    </script>
@stop

@section('title')
    Statistics
@endsection

@section('content')

    <!-- Summart chart container -->
    <div id="chartSummaryChart" style="height: 300px;"></div>

    <!-- Users by country container -->
    <div id="chartUsersByCountry" style="height: 300px;"></div>

    <!-- Teachers by country container -->
    <div id="chartTeachersByCountry" style="height: 300px;"></div>
@endsection
