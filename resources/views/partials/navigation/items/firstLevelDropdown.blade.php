<div class="relative flex" x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape" @close-popover-group.window="onClosePopoverGroup">
    <button type="button" x-state:on="Item active" x-state:off="Item inactive" class="group inline-flex items-center text-base font-medium hover:bg-calendarGoldHover focus:bg-calendarGoldHover text-gray-900" :class="{ 'text-gray-900': open, 'text-gray-500': !(open) }" @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true" :aria-expanded="open.toString()">
        <div class="ml-4">
            {!! $svg !!}
        </div>
        <div class="ml-2 text-base font-medium text-white">
            {{$label}}
        </div>
        <svg x-state:on="Item active" x-state:off="Item inactive" class="ml-2 h-5 w-5 text-gray-600 mr-2" :class="{ 'text-gray-400': open, 'text-white': !(open) }" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-description="'Solutions' flyout menu, show/hide based on flyout menu state." class="absolute z-10 -ml-4 top-14 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0" x-ref="panel" @click.away="open = false">
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-4 sm:p-8">
                @include($submenu)
            </div>
        </div>
    </div>
</div>