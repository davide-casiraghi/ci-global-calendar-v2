<li>
    <a href="{{ $searchResult->url }}" class="block hover:bg-gray-50">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-indigo-600 truncate">
                    {{ $searchResult->title }}
                </p>
                <div class="ml-2 flex-shrink-0 flex">
                    aaa
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    {{--<p class="flex items-center text-sm text-gray-500">
                        <!-- Heroicon name: tag -->
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                        {{$postsCategory->category->name}}
                    </p>--}}

                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                    <!-- Heroicon name: calendar -->
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    <p>
                        cccc
                    </p>
                </div>
            </div>
        </div>
    </a>
</li>


{{-- <div class="container max-w-md">
        <div class="card">
            <div class="card-header"><b>{{ $searchResults->count() }} results found for "{{ request('keyword') }}"</b></div>

            <div class="card-body">

                @foreach($searchResults->groupByType() as $type => $modelSearchResults)
                    <h2>{{ ucfirst($type) }}</h2>

                    @foreach($modelSearchResults as $searchResult)
                        <ul>
                            <li><a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a></li>
                        </ul>
                    @endforeach
                @endforeach

            </div>
        </div>
    </div>--}}