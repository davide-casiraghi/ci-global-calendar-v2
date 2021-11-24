@php
    $openPanelIndex = 0;
@endphp

<div class="bg-white my-24" x-data="{ openPanel: null }">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:pb-16 sm:pt-1 sm:px-6 lg:px-8">

        <h2 class="leading-headline text-gray-900 capitalize text-center font-brand text-4xl md:text-5xl pb-8 mt-10">
            Frequently asked questions
        </h2>
        <p class="mt-4 text-lg text-gray-500 text-center mb-4">Can’t find the answer you’re looking for? Feel free to <a href="{{route('contact.index')}}" class="font-medium text-primary-600 hover:text-primary-500">contact</a> me.</p>

        <div class="md:grid md:grid-cols-6 md:gap-x-24">
            {{-- COL LEFT --}}
            <div class="md:col-span-3">
                <div class=" divide-y-2 divide-gray-200">
                    <dl class="mt-6 space-y-6 divide-y divide-gray-200">

                        @foreach($left as $faqItem)
                            <div class="pt-6">
                                <dt class="text-lg">
                                    <button x-description="Expand/collapse question button" @click="openPanel = (openPanel === {{$openPanelIndex}} ? null : {{$openPanelIndex}})" x-bind:aria-expanded="openPanel === {{$openPanelIndex}}" class="text-left w-full flex justify-between items-start text-gray-400">
                                        <span class="font-medium text-gray-900">
                                            {!! $faqItem['question']!!}
                                        </span>
                                        <span class="ml-6 h-7 flex items-center">
                                            <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                                Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanel === {{$openPanelIndex}}, 'rotate-0': !(openPanel === {{$openPanelIndex}}) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </dt>
                                <dd class="mt-2 pr-12" x-show="openPanel === {{$openPanelIndex}}" style="display: none;">
                                    <p class="text-base text-gray-500">
                                        {!! $faqItem['answer'] !!}
                                    </p>
                                </dd>
                            </div>
                            @php
                                $openPanelIndex++;
                            @endphp
                        @endforeach
                    </dl>
                </div>
            </div>

            {{-- COL RIGHT --}}
            <div class="md:col-span-3">
                <div class=" divide-y-2 divide-gray-200">
                    <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                        @foreach($right as $faqItem)
                            <div class="pt-6">
                                <dt class="text-lg">
                                    <button x-description="Expand/collapse question button" @click="openPanel = (openPanel === {{$openPanelIndex}} ? null : {{$openPanelIndex}})" x-bind:aria-expanded="openPanel === {{$openPanelIndex}}" class="text-left w-full flex justify-between items-start text-gray-400">
                                        <span class="font-medium text-gray-900">
                                            {!! $faqItem['question']!!}
                                        </span>
                                        <span class="ml-6 h-7 flex items-center">
                                            <svg class="h-6 w-6 transform rotate-0" x-description="Expand/collapse icon, toggle classes based on question open state.
                                                Heroicon name: outline/chevron-down" x-state:on="Open" x-state:off="Closed" x-bind:class="{ '-rotate-180': openPanel === {{$openPanelIndex}}, 'rotate-0': !(openPanel === {{$openPanelIndex}}) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </dt>
                                <dd class="mt-2 pr-12" x-show="openPanel === {{$openPanelIndex}}" style="display: none;">
                                    <p class="text-base text-gray-500">
                                        {!! $faqItem['answer'] !!}
                                    </p>
                                </dd>
                            </div>
                            @php
                                $openPanelIndex++;
                            @endphp
                        @endforeach

                    </dl>
                </div>
            </div>
        </div>

    </div>
</div>
