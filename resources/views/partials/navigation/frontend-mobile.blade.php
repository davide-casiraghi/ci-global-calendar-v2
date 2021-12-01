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

                    @include('partials.navigation.about-sub-voices')

                </nav>
            </div>
        </div>
        <div class="py-6 px-5 space-y-6">
            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    New Event
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    My Events
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    My Venues
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    My Teachers
                </a>

                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    My Organizers
                </a>

                {{--<a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                    Security
                </a>--}}

            </div>
            <div>
                <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Sign up
                </a>
                <p class="mt-6 text-center text-base font-medium text-gray-500">
                    Existing customer?
                    <!-- space -->
                    <a href="#" class="text-indigo-600 hover:text-indigo-500">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>