

{{--
https://tailwindui.com/components/application-ui/elements/dropdowns
--}}

<div x-data="{ open: false }" @keydown.escape.stop="open = false" @click.away="open = false" class="relative inline-block">
    <div>
        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" @click="open = !open" aria-haspopup="true" x-bind:aria-expanded="open">
            <div class="flex">
                <img class="flex-shrink-0 mr-2 mt-1 h-3 w-5" src="{{asset('images/flags/'.LaravelLocalization::getCurrentLocale())}}.gif" alt="{{LaravelLocalization::getCurrentLocaleName()}} flag">
                {{LaravelLocalization::getCurrentLocaleName()}}
                <svg class="-mr-1 ml-2 h-5 w-5" x-description="Heroicon name: solid/chevron-down" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </button>
    </div>

    <div x-description="Dropdown menu, show/hide based on menu state." x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-left absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="display: none;">
        <div class="py-1" role="none">
            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $locale)
                {{--<option value="{{$key}}" @if(app()->getLocale() == $key) selected @endif>{{$locale['name']}}</option>--}}

                <a href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                    <div class="flex">
                        <img class="flex-shrink-0 mr-1.5 mt-1 h-3 w-5" src="/images/flags/{{ $localeCode }}.gif" alt="{{$locale['name']}} flag">
                        {{$locale['name']}}
                    </div>
                </a>
            @endforeach
        </div>
    </div>




</div>
