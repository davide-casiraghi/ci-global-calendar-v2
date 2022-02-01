<!-- Static sidebar for desktop -->
<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex flex-col h-0 flex-1">
            <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                <img class="h-8 w-auto"
                     src="{{asset('images/images_pages/ci_globa_calendar_logo_backend_transp_spaced.jpg')}}"
                     alt="Workflow"/>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('dashboard*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                        'label' => 'Dashboard',
                        'url' => route('dashboard.index'),
                    ])

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('users*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>',
                        'label' => 'Users',
                        'url' => route('users.index'),
                    ])

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('teams*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>',
                        'label' => 'Teams',
                        'url' => route('teams.index'),
                    ])

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('posts*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>',
                        'label' => 'Posts',
                        'url' => route('posts.index'),
                    ])

                    {{--@include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('glossaries*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>',
                        'label' => 'Glossaries',
                        'url' => route('glossaries.index'),
                    ])--}}

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('events*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
                        'label' => 'Events',
                        'url' => route('events.index'),
                    ])

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('homepageMessages*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path fill-rule="evenodd" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" clip-rule="evenodd"></path>',
                        'label' => 'Homepage message',
                        'url' => route('homepageMessages.index'),
                    ])

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('statistics'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path fill-rule="evenodd" d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" clip-rule="evenodd"></path>',
                        'label' => 'Statistics',
                        'url' => route('statistics'),
                    ])

                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('donationOffers*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
                        'label' => 'Donation offers',
                        'url' => route('donationOffers.index'),
                    ])

                    {{--@include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('testimonials*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"></path>',
                        'label' => 'Testimonials',
                        'url' => route('testimonials.index'),
                    ])--}}

                    {{--@include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('insights*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>',
                        'label' => 'Insights',
                        'url' => route('insights.index'),
                    ])--}}
                    
                    @include('partials.dashboard.navigation.menuItem', [
                        'active' => request()->routeIs('backgroundImages*'),
                        'kind' => 'desktop',
                        'heroIconPath' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />',
                        'label' => 'Background Images',
                        'url' => route('backgroundImages.index'),
                    ])
                    
                    
                </nav>
            </div>
        </div>
    </div>
</div>
