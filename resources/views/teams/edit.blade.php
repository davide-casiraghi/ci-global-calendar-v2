@extends('layouts.backend')

@section('content')
    <div class="container mt-4">
        @include('partials.messages')

        <div class="row">
            <div class="col-6">
                <h2 class="font-weight-bolder">{{ __('teams.edit_team') }}</h2>
            </div>
            <div class="col-6">
                <form action="{{ route('teams.destroy',$team->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger float-right">{{ __('ui.delete') }}</button>
                </form>
            </div>
        </div>


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

            <div class="row mt-4">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">
                        {{ __('ui.save') }}
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection

