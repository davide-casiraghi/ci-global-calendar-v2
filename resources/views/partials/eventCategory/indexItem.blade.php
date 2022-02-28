<li>
    <a href="{{route('eventCategories.edit', $eventCategory)}}" class="block hover:bg-gray-50">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-indigo-600 truncate">
                    {{$eventCategory->name}}
                </p>
                <div class="ml-2 flex-shrink-0 flex">
                    {{--<p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{$eventsCategory->status()}}
                    </p>--}}
                </div>
            </div>

        </div>
    </a>
</li>
