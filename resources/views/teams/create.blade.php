@extends('layouts.backend')

@section('title')
    @lang('teams.create_team')
@endsection

@section('content')
    <div class="container mt-4">
        @include('partials.messages')

        <form method="POST" action="{{ route('teams.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name">{{ __('teams.team_name') }}</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="" value="{{ old('name')}}" required>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                    <div class="flex justify-end mt-4">
                        <a href="{{ route('teams.index') }}">
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
    </div>
@endsection

