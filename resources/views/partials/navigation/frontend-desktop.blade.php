<nav class="hidden md:flex space-x-10 ml-4" x-data="Components.popoverGroup()" x-init="init()">
    <div class="relative" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
        <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-gray-900" :class="{ 'text-gray-900': open, 'text-gray-500': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true" :aria-expanded="open.toString()">
            <span>About</span>
            <svg x-state:on="Item active" x-state:off="Item inactive" class="ml-2 h-5 w-5 group-hover:text-gray-500 text-gray-600" :class="{ 'text-gray-600': open, 'text-gray-400': !(open) }" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-description="'Solutions' flyout menu, show/hide based on flyout menu state." class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0" x-ref="panel" @click.away="open = false">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                    @include('partials.navigation.about-sub-voices')
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
        Get Involved
    </a>
    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
        Help
    </a>

    <div class="relative" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
        {{--
        <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-gray-500" :class="{ 'text-gray-900': open, 'text-gray-500': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="false" :aria-expanded="open.toString()">
            <span>More</span>
            <svg x-state:on="Item active" x-state:off="Item inactive" class="ml-2 h-5 w-5 group-hover:text-gray-500 text-gray-400" :class="{ 'text-gray-600': open, 'text-gray-400': !(open) }" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>


        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-description="'More' flyout menu, show/hide based on flyout menu state." class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-md sm:px-0" x-ref="panel" @click.away="open = false" style="display: none;">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">

                    <a href="#" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                        <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" x-description="Heroicon name: outline/support" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-base font-medium text-gray-900">
                                Help Center
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Get all of your questions answered in our forums or contact support.
                            </p>
                        </div>
                    </a>

                    <a href="#" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                        <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" x-description="Heroicon name: outline/bookmark-alt" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-base font-medium text-gray-900">
                                Guides
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Learn how to maximize our platform to get the most out of it.
                            </p>
                        </div>
                    </a>

                    <a href="#" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                        <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" x-description="Heroicon name: outline/calendar" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div class="ml-4">
                            <p class="text-base font-medium text-gray-900">
                                Events
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                See what meet-ups and other events we might be planning near you.
                            </p>
                        </div>
                    </a>

                </div>
                <div class="px-5 py-5 bg-gray-50 sm:px-8 sm:py-8">
                    <div>
                        <h3 class="text-sm tracking-wide font-medium text-gray-500 uppercase">
                            Recent Posts
                        </h3>
                        <ul role="list" class="mt-4 space-y-4">

                            <li class="text-base truncate">
                                <a href="#" class="font-medium text-gray-900 hover:text-gray-700">
                                    Boost your conversion rate
                                </a>
                            </li>

                            <li class="text-base truncate">
                                <a href="#" class="font-medium text-gray-900 hover:text-gray-700">
                                    How to use search engine optimization to drive traffic to your site
                                </a>
                            </li>

                            <li class="text-base truncate">
                                <a href="#" class="font-medium text-gray-900 hover:text-gray-700">
                                    Improve your customer experience
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="mt-5 text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500"> View all posts <span aria-hidden="true">→</span></a>
                    </div>
                </div>
            </div>
        </div>
        --}}


    </div>


</nav>