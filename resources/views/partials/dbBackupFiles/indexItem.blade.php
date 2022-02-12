<li class="px-4 py-4 text-sm font-medium">
    <div class="flex justify-between">
        <div class="flex items-center">
            <a href="{{route('databaseBackups.download', $databaseBackup)}}" class="hover:bg-gray-50">
                <div class="text-indigo-600 truncate">
                    {{$databaseBackup['fileName']}}
                </div>
            </a>
            <div>- {{$databaseBackup['size']}}</div>
        </div>
        <div>
            <form action="{{ route('databaseBackups.destroy',$databaseBackup) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')

                <button type="submit" class="redButton smallButton">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <div class="inline-block">Delete</div>
                </button>
            </form>
        </div>
    </div>
</li>
