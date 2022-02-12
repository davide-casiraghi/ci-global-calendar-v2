@extends('layouts.backend')

@section('title')
    Database backup files
@endsection

@section('content')

    {{-- Tailwind Component: https://tailwindui.com/components/application-ui/lists/stacked-lists--}}
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($databaseBackupFiles as $databaseBackup)
                @include('partials.dbBackupFiles.indexItem', [
                    'databaseBackup' => $databaseBackup
                ])
            @endforeach
        </ul>
    </div>

@endsection
