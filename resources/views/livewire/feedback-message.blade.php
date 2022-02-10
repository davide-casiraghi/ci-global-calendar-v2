<div>
    <button wire:click.prevent="openModal" type="button" class="p-4 cursor-pointer hover:bg-calendarGoldHover flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
        <div class="ml-1">
            @lang('general.send_a_feedback')
        </div>
    </button>

    {{-- MODAL --}}
    @if($showModal)
        <div class="z-10 inset-0 overflow-y-auto fixed top-10 text-gray-600">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div>
                        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                            <button wire:click="close" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Close</span>
                                <!-- Heroicon name: x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="">

                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-xl leading-6 font-medium text-gray-900 mb-4" id="modal-headline">
                                    @lang('general.send_a_feedback')
                                </h3>

                                <div class="contextualFeedback warning rounded-lg py-5 px-6 text-base">
                                    @lang('views.please_write_in_english')
                                </div>

                                <div class="mt-6">
                                    @include('partials.forms.input', [
                                            'label' => __('general.your_name'),
                                            'name' => 'data.name',
                                            'placeholder' => '',
                                            'value' => old('name'),
                                            'required' => true,
                                            'disabled' => false,
                                            'livewireSupport' => true,
                                    ])
                                </div>

                                <div class="mt-2">
                                    @include('partials.forms.input', [
                                            'label' => __('general.your_email'),
                                            'name' => 'data.email',
                                            'placeholder' => '',
                                            'value' => old('email'),
                                            'required' => true,
                                            'disabled' => false,
                                            'livewireSupport' => true,
                                    ])
                                </div>

                                <div class="mt-2">
                                    @include('partials.forms.textarea', [
                                           'label' => __('general.message'),
                                           'name' => 'data.message',
                                           'placeholder' => '',
                                           'value' => old('message'),
                                           'required' => true,
                                           'disabled' => false,
                                           'style' => 'tinymce',
                                           'extraDescription' => '',
                                           'livewireSupport' => true,
                                           'extraClasses' => 'h-48',
                                       ])
                                </div>

                                <div class="mt-2">
                                    @include('partials.forms.captcha', [
                                        'label' => 'Captcha',
                                        'name' => 'data.captcha',
                                        'livewireSupport' => true,
                                    ])
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button wire:click="sendMessage" type="button" class="blueButton mediumButton">
                                @lang('general.send')
                            </button>
                            <button wire:click="close" type="button" class="grayButton mediumButton mr-2">
                                @lang('general.close')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>