<li>

    <div class="md:grid sm:grid-cols-6 md:gap-4">
        <div class="sm:col-span-4">
            <a href="{{route('databaseBackups.download', $databaseBackupFile)}}" class="block hover:bg-gray-50">
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-indigo-600 truncate">
                            {{$databaseBackupFile}}
                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="sm:col-span-2 mt-5 md:mt-0">
            <form action="{{ route('databaseBackups.destroy',$databaseBackupFile) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')

                <button type="submit" class="inline-flex items-center border font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 border-transparent text-red-700 bg-red-100 hover:bg-red-200 px-2.5  text-xs rounded shadow-sm mt-4">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <div class="inline-block">Delete</div>
                </button>
            </form>
        </div>
    </div>
</li>
