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
    @lang('user.edit_user')
@endsection

@section('buttons')
    @livewire('delete-model', [
    'model' => $user,
    'modelName' => 'user',
    'redirectRoute' => 'users.index'
    ])
@endsection

@section('content')

    @include('partials.messages')

    <form class="space-y-6" method="POST" action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.email_address'),
                                    'name' => 'email',
                                    'placeholder' => '',
                                    'value' => old('email', $user->email),
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
                                    'value' => old('name', $user->profile->name),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.input', [
                                    'label' => __('general.surname'),
                                    'name' => 'surname',
                                    'placeholder' => '',
                                    'value' => old('surname', $user->profile->surname),
                                    'required' => true,
                                    'disabled' => false,
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.select', [
                                'label' => __('general.country'),
                                'name' => 'country_id',
                                'placeholder' => '',
                                'records' => $countries,
                                'selected' => $user->profile->country_id,
                                'required' => true,
                                'extraClasses' => 'select2',
                            ])
                        </div>

                        <div class="col-span-6">
                            @include('partials.forms.textarea', [
                                   'label' => __('general.description'),
                                   'name' => 'description',
                                   'placeholder' => '',
                                   'value' => old('description', $user->profile->description),
                                   'required' => false,
                                   'disabled' => false,
                                   'style' => 'tinymce',
                                   //'extraDescription' => '',
                               ])
                        </div>

                        <div class="col-span-6 @can('users.edit') inline @else hidden @endcan">
                            <label for="role" class="block text-sm font-medium text-gray-700 inline">{{ __('user.user_level') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Choose...</option>
                                @foreach($userLevels as $userLevel)
                                    <option value="{{$userLevel->name}}" {{ old('role', $assignedRole) == $userLevel->name ? 'selected' : ''}}>{{ucwords($userLevel->name)}}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-span-6 @can('users.edit') inline @else hidden @endcan">
                            <div class="team_block hidden"> <!-- hidden -->
                                <label for="role" class="block text-sm font-medium text-gray-700 inline">{{ __('user.team_membership') }}</label>
                                <select class="custom-select d-block w-full select2-multiple" id="team_membership" name="team_membership[]" multiple="multiple">
                                    @foreach($allTeams as $team)
                                        @if (old('team_membership'))
                                            <option value="{{$team->id}}" {{ in_array($team->id, old("team_membership")) ? "selected":"" }}>{{ $team->name }}</option>
                                        @else
                                            <option value="{{$team->id}}" {{ $user->roles->contains($team->id) ? 'selected' : '' }}>{{ $team->name }}</option>
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
                                $checked = isset($user->profile->accept_terms) ? "checked" : "";
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

                        <div class="col-span-6">
                            @php
                                $checked = ($user->isEnabled()) ? "checked" : "";
                            @endphp
                            @include('partials.forms.checkbox', [
                                'label' => __('views.enabled'),
                                'id'  => 'status',
                                'name' => 'status',
                                'size' => 'small',
                                'required' => false,
                                'checked' => $checked,
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="grayButton mediumButton mr-2">
                    @lang('general.back')
                </a>
                <button type="submit" class="blueButton mediumButton">
                    @lang('general.submit')
                </button>
            </div>
        </div>
    </form>

@endsection
