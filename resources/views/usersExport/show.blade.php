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
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Export
            </button>
        </div>
    </form>
@endsection
