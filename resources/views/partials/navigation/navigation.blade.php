<div class="relative bg-calendarGold z-40"
     x-data="Components.popover({ open: false, focus: false })"
     @keydown.escape="onEscape"
     @close-popover-group.window="onClosePopoverGroup"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center md:justify-start md:space-x-10 h-14 items-stretch">
            <div class="flex justify-start lg:w-0 lg:flex-1 items-center items-stretch">

                @include('partials.navigation.items.firstLevelBasic', [
                    'label' => 'Home',
                    'route' => route('home'),
                    'svg' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>',
                ])

                @include('partials.navigation.frontend-desktop')
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                        @click="toggle"
                        @mousedown="if (open) $event.preventDefault()"
                        aria-expanded="false"
                        :aria-expanded="open.toString()">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" x-description="Heroicon name: outline/menu" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <div class="hidden md:flex items-center items-stretch justify-end md:flex-1 lg:w-0">

                {{--  When The user is authenticated --}}
                @auth
                    {{-- Manager menu --}}
                    @include('partials.navigation.items.firstLevelDropdown', [
                        'label' => 'Manager',
                        'svg' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="h-5 w-5 text-white">
                                    <path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z" class=""></path>
                                </svg>',
                        'submenu' => 'partials.navigation.submenus.manager-sub-voices'
                    ])

                    {{-- User profile and Logout--}}
                    @include('partials.navigation.items.firstLevelDropdown', [
                        'label' => '',
                        'svg' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512" class="h-5 w-5 text-white">
                                    <path fill="currentColor" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z" class=""></path>
                                </svg>',
                        'submenu' => 'partials.navigation.submenus.user-sub-voices'
                    ])

                @endauth

                {{-- When The user is not authenticated --}}
                @guest
                    @include('partials.navigation.items.firstLevelBasic', [
                        'label' => __('menu.create_account'),
                        'route' => route('register'),
                        'svg' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="h-5 w-5 text-white">
                                    <path fill="currentColor" d="M624 208h-64v-64c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v64h-64c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h64v64c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-64h64c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm-400 48c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z" class=""></path>
                                </svg>',
                    ])

                    @include('partials.navigation.items.firstLevelBasic', [
                        'label' => __('menu.login'),
                        'route' => route('login'),
                        'svg' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-in" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-5 w-5 text-white">
                                    <path fill="currentColor" d="M137.2 110.3l21.9-21.9c9.3-9.3 24.5-9.4 33.9-.1L344.9 239c9.5 9.4 9.5 24.7 0 34.1L193 423.7c-9.4 9.3-24.5 9.3-33.9-.1l-21.9-21.9c-9.7-9.7-9.3-25.4.8-34.7l77.6-71.1H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h191.5l-77.6-71.1c-10-9.1-10.4-24.9-.7-34.5zM512 352V160c0-53-43-96-96-96h-84c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h84c17.7 0 32 14.3 32 32v192c0 17.7-14.3 32-32 32h-84c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h84c53 0 96-43 96-96z" class=""></path>
                                </svg>',
                    ])
                @endguest

                @include('partials.navigation.language-switcher')
            </div>
        </div>
    </div>

    @include('partials.navigation.frontend-mobile')

</div>