@extends('layouts.backend')

@section('title',  "Users export" )

@section('subTitle')
    Click on the export button to download an excel with all the users and their emails.
@endsection

@section('content')

    <form action="{{ route('users-export-export') }}" method="POST">
        @csrf
        <div class="mt-8">
            <button type="submit"
                    class="blueButton mediumButton">
                Export
            </button>
        </div>
    </form>
@endsection
