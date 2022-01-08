@extends('layouts.backend')

@section('javascript')
    @parent
    <!-- Charting library -->
    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <!-- Your application script -->
    <script>
        const chart = new Chartisan({
            el: '#chartSummaryChart',
            url: "@chart('summary_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'line', fill: false }]),
                //.datasets([{ type: 'line', fill: false }, 'bar']),
        });
    </script>
@stop

@section('title')
    Statistics
@endsection

@section('content')


    {{--<div class="col-12 mt-2">
        {!! $eventsByCountriesChart->container() !!}
    </div>--}}

    <!-- Chart's container -->
    <div id="chartSummaryChart" style="height: 300px;"></div>


@endsection
