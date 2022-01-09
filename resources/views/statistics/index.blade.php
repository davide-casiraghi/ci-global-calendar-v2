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
                .datasets([{ type: 'line', fill: false }])
                .title('Summary chart')
                .legend({ position: 'bottom' })
                .tooltip({
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return '$' + addCommas(tooltipItems.yLabel) + '.00';
                        }
                    }
                }),
                //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        const chart2 = new Chartisan({
            el: '#chartUsersByCountry',
            url: "@chart('users_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'bar', fill: false }])
                .title('Users by country'),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        //todo - check this good example for documentation.
        //https://github.com/Chartisan/Chartisan/issues/7#issuecomment-774745067
        const chart3 = new Chartisan({
            el: '#chartTeachersByCountry',
            url: "@chart('teachers_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'bar', fill: false }])
                .title('Teachers by country')
                .tooltip({
                    enabled: true,
                    mode: 'single',
                    callbacks: {
                        label: function(tooltipItems, data) {
                            return '$' + addCommas(tooltipItems.yLabel) + '.00';
                        }
                    }
                })
                .custom(function({ data, merge, server }) {
                    // data ->   Contains the current chart configuration
                    //           data that will be passed to the chart instance.
                    // merge ->  Contains a function that can be called to merge
                    //           two javascript objects and returns its merge.
                    // server -> Contains the server information in case you need
                    //           to acces the raw information provided by the server.
                    //           This is mostly used to access the `extra` field.

                    return merge(data, {
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 90,
                                        minRotation: 90
                                    }
                                }]
                            }
                        }
                    });

                    // The function must always return the new chart configuration.
                }),
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
