<div>


    <div x-data="{ active: @entangle('showBackend') }"
            {{--  !!}x-data="{ showBackend: false }"--}}
            class="flex items-center justify-center mt-2 ml-4"
            x-id="['toggle-label']"
            wire:model="showBackend"
    >
        <input type="hidden" :value="active">

        {{-- Label --}}
        <label
                @click="$refs.toggle.click(); $refs.toggle.focus()"
                :id="$id('toggle-label')"
                class="text-black transition-colors dark:text-white"
        >

            {{-- Door Open Icon --}}
            <svg class="h-5 w-5 text-gray-600" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path fill="currentColor" d="M288 288c13.25 0 24-14.33 24-32s-10.75-32-24-32-24 14.33-24 32 10.75 32 24 32zm336 176H512V113.45C512 86.19 490.47 64 464 64h-80V33.18C384 14.42 369.21 0 352.06 0c-2.57 0-5.19.32-7.83 1.01l-192 49.74C137.99 54.44 128 67.7 128 82.92V464H16c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h608c8.84 0 16-7.16 16-16v-16c0-8.84-7.16-16-16-16zm-288 0H176V94.18l160-41.45V464zm128 0h-80V112h80v352z"/>
            </svg>

        </label>

        {{-- Button --}}
        <button
                x-data
                x-ref="toggle"
                @click="active = ! active; $dispatch('input', active)"
                type="button"
                role="switch"
                :aria-checked="active"
                :aria-labelledby="$id('toggle-label')"
                :class="active ? 'bg-black border-2 border-white' : 'bg-white border-2 border-black'"
                class="ml-2 relative w-14 py-1 px-0 inline-flex rounded-full"
        >
        <span
                :class="active ? 'bg-white translate-x-6' : 'bg-black translate-x-1'"
                class="w-6 h-6 rounded-full transition"
                aria-hidden="true"
        ></span>
        </button>
    </div>

</div>
