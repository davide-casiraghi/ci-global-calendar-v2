<div x-show="open" x-transition:enter="duration-200 ease-out" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="duration-100 ease-in" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-description="Mobile menu, show/hide based on mobile menu state." class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden z-10" x-ref="panel" @click.away="open = false" style="display: none;">
    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
        <div class="pt-5 pb-6 px-5">
            <div class="flex items-center justify-between">
                <div>
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                </div>
                <div class="-mr-2">
                    <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="toggle">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-6">
                <nav class="grid gap-y-8">
                    @include('partials.navigation.submenus.about-sub-voices')
                </nav>
            </div>
        </div>
        <div class="py-6 px-5 space-y-6">
            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    @lang('menu.new_event')
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    @lang('menu.my_events')
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    @lang('menu.my_venues')
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    @lang('menu.my_teachers')
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    @lang('menu.my_organizers')
                </a>
            </div>

            {{-- When The user is not authenticated --}}
            @guest
                <div>
                    <a href="{{route('login')}}" class="blueButton flex items-center justify-center w-full px-4 py-2">
                        @lang('menu.login')
                    </a>
                    <p class="mt-6 text-center text-base font-medium text-gray-500">
                        Not yet registered?
                        <!-- space -->
                        <a href="{{route('register')}}" class="text-blue-600 hover:text-indigo-500">
                            @lang('menu.create_account')
                        </a>
                    </p>
                </div>
            @endguest
        </div>
    </div>
</div>