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

            <div class="mb-4">
                @include('partials.forms.input', [
                        'label' => __('teams.team_name'),
                        'name' => 'name',
                        'placeholder' => '',
                        'value' => old('name', $team->name),
                        'required' => true,
                        'disabled' => false,
                ])
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

