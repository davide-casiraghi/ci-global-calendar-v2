@extends('layouts.backend')

@section('title', "Users export")

@section('subTitle')
    Click on the export button to download an excel with all the users and their emails.
@endsection

@section('content')

    <form action="{{ route('users-export-export') }}" method="GET">
        @csrf
        <button type="submit" class="blueButton mediumButton mt-8">
            Export
        </button>
    </form>
@endsection
