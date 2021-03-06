<div
        {{--
        x-data="Components.menu({ open: false })"
        @keydown.escape.stop="open = false; focusButton()"
        @click.outside="onClickAway($event)"
        class="relative inline-block text-left flex items-stretch"
        --}}
        class="relative flex"
        x-data="{
            open: false,
            activeIndex: 0,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.open = true
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
        x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['dropdown-button']"
>

    {{-- Selected language --}}
    <button type="button" class="flex justify-center items-center w-full px-4 text-sm font-medium text-gray-700 hover:bg-calendarGoldHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500"
            id="menu-button"
            {{--
            x-ref="button"
            @click="onButtonClick()"
            @keyup.space.prevent="onButtonEnter()"
            @keydown.enter.prevent="onButtonEnter()"
            aria-expanded="true"
            aria-haspopup="true"
            x-bind:aria-expanded="open.toString()"
            @keydown.arrow-up.prevent="onArrowUp()"
            @keydown.arrow-down.prevent="onArrowDown()"
            --}}
            x-ref="button"
            x-on:click="toggle()"
            :aria-expanded="open"
            :aria-controls="$id('dropdown-button')"
            type="button"
            class="group inline-flex items-center text-base font-medium hover:bg-calendarGoldHover focus:bg-calendarGoldHover text-gray-900"
    >
        <div class="flex">
            <img class="w-8 h-4" src="/images/flags/{{ Config::get('app.locale') }}.svg" alt="Selected language {{ LaravelLocalization::getCurrentLocaleName() }}"/>
            <svg x-state:on="Item active" x-state:off="Item inactive" class="h-5 w-5 group-hover:text-gray-500 text-gray-600" :class="{ 'text-gray-600': open, 'text-white': !(open) }" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </div>
    </button>

    {{-- Available languages --}}
    <div
            {{--
            x-show="open"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="origin-top-right absolute right-0 top-14 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
            x-ref="menu-items"
            x-description="Dropdown menu, show/hide based on menu state."
            x-bind:aria-activedescendant="activeDescendant"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="menu-button" tabindex="-1"
            @keydown.arrow-up.prevent="onArrowUp()"
            @keydown.arrow-down.prevent="onArrowDown()"
            @keydown.tab="open = false"
            @keydown.enter.prevent="open = false; focusButton()"
            @keyup.space.prevent="open = false; focusButton()"
            --}}

            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            style="display: none;"
            class="origin-top-right absolute right-0 top-14 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"

            >
        <div class="py-1" role="none">
            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                @if ($localeCode != Config::get('app.locale'))
                    <a rel="alternate" hreflang="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-200"
                       x-state:on="Active"
                       x-state:off="Not Active"
                       :class="{ 'bg-gray-100 text-gray-900': activeIndex === 0, 'text-gray-700': !(activeIndex === 0) }"
                       role="menuitem"
                       tabindex="-1"
                       id="menu-item-0"
                       @mouseenter="activeIndex = 0"
                       @mouseleave="activeIndex = -1"
                       @click="open = false; focusButton()"
                    >
                        <div class="flex items-center">
                            <object class="w-8 h-4 mr-1" type="image/svg+xml" data="/images/flags/{{ $localeCode }}.svg"></object>
                            <div>
                                {{ ucfirst($properties['native']) }}
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>

</div>