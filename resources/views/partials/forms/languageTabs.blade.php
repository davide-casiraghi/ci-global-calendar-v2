

<div>

    <div class="text-gray-700 text-sm font-medium mt-8">
        Translations
    </div>

    {{-- Language Tabs buttons --}}
    <div class="hidden sm:block mt-2">
        <nav class="flex space-x-2" aria-label="Tabs">
            @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)

                <div class="flex w-10 h-10 text-sm font-medium rounded-md bg-gray-100 text-gray-500 hover:text-gray-700"
                        x-on:click.prevent="translationActive = '{{$key}}'"
                        x-bind:class="{'border-solid border-4 border-indigo-200': translationActive === '{{$key}}'}"
                        >
                    <div class="m-auto">
                        {{$key}}
                    </div>
                </div>
            @endforeach
        </nav>
    </div>

</div>

