<li>
    <a href="{{route('quotes.edit', $quote->id)}}" class="block hover:bg-gray-50">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-indigo-600 truncate">
                    {{$quote->author}}
                </p>
                <div class="ml-2 flex-shrink-0 flex">
                    <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($quote->isPublished())bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                        {{ucfirst($quote->publishingStatus())}}
                    </div>
                </div>
            </div>
            <div class="md:grid md:grid-cols-6 md:gap-2 mt-1">
                <div class="md:col-span-4 text-sm text-gray-500">
                    {{$quote->description}}
                </div>
                <div class="md:col-span-2 mt-5 md:mt-0 text-sm text-gray-500 sm:mt-0 mb-10 sm:mb-0">
                    <div class="float-right flex items-center">
                        <div class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                            {{ucfirst($quote->show_where)}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</li>
