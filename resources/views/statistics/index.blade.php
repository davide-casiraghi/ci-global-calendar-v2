@extends('layouts.backend')

@section('javascript')
    @parent
 
    <script>
        const chart1 = new Chartisan({
            el: '#chartSummaryChart',
            url: "@chart('summary_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'line', fill: false }])
                .title('Summary chart')
                .legend({ position: 'bottom' })
                .responsive()
                .beginAtZero(),
                //.datasets([{ type: 'line', fill: false }, 'bar']),
        });

        const chart2 = new Chartisan({
            el: '#chartUsersByCountry',
            url: "@chart('users_by_country_chart')",
            hooks: new ChartisanHooks()
                .colors()
                .datasets([{ type: 'bar', fill: false }])
                .title('Users by country')
                .responsive()
                .beginAtZero(),
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
                .beginAtZero()
                .responsive()
                .options({  //https://chartisan.dev/documentation/frontend/hooks#Chartisan-hooks

                }),
            //.datasets([{ type: 'line', fill: false }, 'bar']),
        });
    </script>
@stop

@section('title')
    Statistics
@endsection

@section('content')

    {{-- Recap table --}}
    <div class="md:grid md:grid-cols-8 md:gap-4 mb-8">
        <div class="md:col-span-2 bg-white border-gray-400 p-3">
            <div class="flex items-center">
                <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="a">
                    <div class="text-3xl font-semibold text-gray-800">300</div>
                    <div class="text-xs text-gray-500 font-bold tracking-wide uppercase">Registered users</div>
                </div>
            </div>
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0 bg-white border-gray-400 p-3">
            <div class="flex items-center">
                <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                    </svg>
                </div>
                <div class="a">
                    <div class="text-3xl font-semibold text-gray-800">300</div>
                    <div class="text-xs text-gray-500 font-bold tracking-wide uppercase">Organizer profiles</div>
                </div>
            </div>
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0 bg-white border-gray-400 p-3">
            <div class="flex items-center">
                <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="a">
                    <div class="text-3xl font-semibold text-gray-800">300</div>
                    <div class="text-xs text-gray-500 font-bold tracking-wide uppercase">Teachers profiles</div>
                </div>
            </div>
        </div>
        <div class="md:col-span-2 mt-5 md:mt-0 bg-white border-gray-400 p-3">
            <div class="flex items-center">
                <div class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="a">
                    <div class="text-3xl font-semibold text-gray-800">300</div>
                    <div class="text-xs text-gray-500 font-bold tracking-wide uppercase">Active events</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summart chart container -->
    <div id="chartSummaryChart" style="height: 300px;"></div>

    <!-- Users by country container -->
    <div id="chartUsersByCountry" style="height: 300px;"></div>

    <!-- Teachers by country container -->
    <div id="chartTeachersByCountry" style="height: 300px;"></div>
@endsection
