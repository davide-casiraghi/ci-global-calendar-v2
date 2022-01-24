@extends('layouts.backend')

@section('title')
    @lang('teams.edit_team')
@endsection

@section('buttons')
    @livewire('delete-model', [
    'model' => $team,
    'modelName' => 'team',
    'redirectRoute' => 'teams.index'
    ])
@endsection

@section('content')

    @include('partials.messages')

    <div class="container mt-4">

        <form method="POST" action="{{ route('teams.update', $team->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">{{ __('teams.team_name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="" value="{{ old('name', $team->name)}}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ url()->previous() }}" class="grayButton mediumButton mr-2">
                    @lang('general.back')
                </a>
                <button type="submit" class="blueButton mediumButton">
                    @lang('general.submit')
                </button>
            </div>
        </form>

    </div>
@endsection

