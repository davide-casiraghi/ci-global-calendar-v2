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
                })
                .options({  //https://chartisan.dev/documentation/frontend/hooks#Chartisan-hooks
                    scales: {
                        x: [{
                            beginAtZero: true,
                        }]
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
        // version 3.0 - https://www.chartjs.org/docs/latest/getting-started/v3-migration.html
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
                .options({  //https://chartisan.dev/documentation/frontend/hooks#Chartisan-hooks
                    scales: {
                        x: [{
                            title: {
                                display: true,
                                text: 'value'
                            },
                            beginAtZero: true,
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90
                            }
                        }]
                    }
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
