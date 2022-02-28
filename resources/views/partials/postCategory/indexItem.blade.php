<li>
    <a href="{{route('postCategories.edit', $postCategory)}}" class="block hover:bg-gray-50">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-indigo-600 truncate">
                    {{$postCategory->name}}
                </p>
                <div class="ml-2 flex-shrink-0 flex">

                </div>
            </div>
        </div>
    </a>
</li>
