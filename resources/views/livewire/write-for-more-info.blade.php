<div>
    <button wire:click.prevent="openModal" type="button" name="btn_submit" class="blueButton mediumButton">
        @lang('event.write_for_more_info')
    </button>

    @if($showSentMessage)
        <div class="bg-green-100 rounded-lg py-5 px-6 text-base text-green-700 mt-4" role="alert">
            Message sent!
        </div>
    @endif

    {{-- MODAL --}}
    @if($showModal)
        <div class="z-10 inset-0 overflow-y-auto fixed top-10">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!--
                  Modal panel, show/hide based on modal state.

                  Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                  Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
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
                                    @lang('event.write_for_more_info')
                                </h3>

                                <div class="mt-6">
                                    @lang('event.write_for_more_info_details')
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
                                           'required' => false,
                                           'disabled' => false,
                                           'style' => 'tinymce',
                                           'extraDescription' => '',
                                           'livewireSupport' => true,
                                           'extraClasses' => 'h-48',
                                       ])
                                </div>

                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button wire:click="sendMessage" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                @lang('general.send')
                            </button>
                            <button wire:click="close" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                                @lang('general.close')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

{{--
@push('scripts')
    <script>
        $(document).ready(function () {

            // When a value is selected in the dropdown, update the selected property in the Livewire component
            $('#teacher_ids').on('change', function (e) {
                let selectedValues = $('#teacher_ids').select2("val");
            @this.set('selected', selectedValues);
            });

            // When a new teacher is added update the select2
            // The data variable is the parameter array passed to the emit('refreshDropdown') function in the Livewire component.
            Livewire.on('refreshTeachersDropdown', data => {
                var newOption = new Option(data.teacher['name'] + " " + data.teacher['surname'], data.teacher['id'], false, true);
                $('#teacher_ids').append(newOption).trigger('change');
            });

            window.livewire.on('teacherImageChoosen', () => {
                console.log('file chosen');
                let inputField = document.getElementById('image')
                let file = inputField.files[0]
                let reader = new FileReader();
                reader.onloadend = () => {
                    window.livewire.emit('fileUpload', reader.result)
                }
                reader.readAsDataURL(file);
            });
        });



    </script>
@endpush

--}}