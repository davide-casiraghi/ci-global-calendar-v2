@extends('layouts.backend')

@section('javascript-document-ready')
    @parent
    {{-- Show Teams when Admin get loaded --}}
    var selectedRole = $( "#role" ).val();

    if ( selectedRole == 'Admin'){
        $(".team_block").show();
    }

    {{-- Show Teams when Admin is selected --}}
    $('#role').on('change', function() {
        if ( this.value == 'Admin'){
            $(".team_block").show();
        }
        else{
            $(".team_block").hide();
            $('#team_membership').val(null).trigger('change');
        }
    });
@stop

@section('title')
    @lang('user.create_new_user')
@endsection

@section('content')

    <form class="space-y-6" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Edit user</h3>
                    {{--
                      <p class="mt-1 text-sm text-gray-500">
                        Edit the user data
                    </p>
                  --}}

                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    @csrf

                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.email_address'),
                                    'name' => 'email',
                                    'placeholder' => '',
                                    'value' => old('email'),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.password', [
                                    'label' => __('general.password'),
                                    'name' => 'password',
                                    'placeholder' => '',
                                    'value' => old('email'),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.name'),
                                    'name' => 'name',
                                    'placeholder' => '',
                                    'value' => old('name'),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.surname'),
                                    'name' => 'surname',
                                    'placeholder' => '',
                                    'value' => old('surname'),
                                    'required' => false,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.country'),
                                'name' => 'country_id',
                                'placeholder' => '',
                                'records' => $countries,
                                //'selected' => $user->country_id,
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('general.description'),
                                   'name' => 'description',
                                   'placeholder' => '',
                                   'value' => old('description'),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'tinymce',
                                   //'extraDescription' => 'Anything to show jumbo style after the content',
                               ])
                        </div>


                        <div class="col-span-6 @can('users.edit') inline @else hidden @endcan">
                            <label for="role" class="block text-sm font-medium text-gray-700 inline">{{ __('user.user_level') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Choose...</option>
                                @foreach($userLevels as $userLevel)
                                    <option value="{{$userLevel->name}}" {{ old('role') == $userLevel->name ? 'selected' : ''}}>{{ucwords($userLevel->name)}}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 @can('users.edit') inline @else hidden @endcan">
                            <div class="team_block hidden"> {{-- hidden --}}
                                <label for="role" class="block text-sm font-medium text-gray-700 inline">{{ __('user.team_membership') }}</label>
                                <select class="custom-select d-block w-full select2-multiple" id="team_membership" name="team_membership[]" multiple="multiple">
                                    @foreach($allTeams as $team)
                                        @if (old('team_membership'))
                                            <option value="{{$team->id}}" {{ in_array($team->id, old("team_membership")) ? "selected":"" }}>{{ $team->name }}</option>
                                        @else
                                            <option value="{{$team->id}}">{{ $team->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-6">
                            @php
                                $checked = old('accept_terms') ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('user.accept_terms'),
                                'id'  => 'accept_terms',
                                'name' => 'accept_terms',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-6 gap-6">
            {{--<div class="col-span-3">
                @include('partials.forms.button',[
                    'title' => 'View',
                    'url' => route('users.show',$user->id),
                    'color' => 'indigo',
                    'icon' => '<svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>',
                    'size' => 1,
                    'extraClasses' => 'mt-4',
                    'kind' => 'secondary',
                    'target' => '_blank',
                ])
            </div>--}}

            <div class="col-span-6">
                <div class="flex justify-end mt-4">
                    <a href="{{ route('users.index') }}">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                    </button>
                </div>
            </div>
        </div>


    </form>




@endsection
