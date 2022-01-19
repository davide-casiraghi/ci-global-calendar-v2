<div>
    <div class="mb-4 px-4 py-3 leading-normal text-blue-700 bg-blue-100 rounded-lg" role="alert">
        You can filter the data by searching for name, surname or country.
    </div>
    <table class="table min-w-full mb-8">
        <thead>
        <tr class="bg-gray-200">
            <th wire:click="sortByColumn('name')" class="px-6 py-3 text-left text-sm leading-4 tracking-wider">
                Name
                @if ($sortColumn == 'name')
                    @include('partials.teachers.icons.sort-'.$sortDirection)
                @else
                    @include('partials.teachers.icons.filterOff')
                @endif
            </th>
            <th wire:click="sortByColumn('surname')" class="px-6 py-3 text-left text-sm leading-4 tracking-wider">
                Surname
                @if ($sortColumn == 'surname')
                    @include('partials.teachers.icons.sort-'.$sortDirection)
                @else
                    @include('partials.teachers.icons.filterOff')
                @endif
            </th>
            <th wire:click="sortByColumn('country_name')" class="px-6 py-3 text-left text-sm leading-4 tracking-wider">
                Country name
                @if ($sortColumn == 'country_name')
                    @include('partials.teachers.icons.sort-'.$sortDirection)
                @else
                    @include('partials.teachers.icons.filterOff')
                @endif
            </th>
        </tr>
        <tr>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                <input wire:model="searchColumns.name" type="text" placeholder="Search..."
                       class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border border-gray-400 w-full py-1 focus:outline-none focus:border-blue-400" />
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                <input wire:model="searchColumns.surname" type="text" placeholder="Search..."
                       class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border border-gray-400 w-full py-1 focus:outline-none focus:border-blue-400" />
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-sm leading-5">
                <select wire:model="searchColumns.country_id"
                        class="mt-2 text-sm sm:text-base pl-2 pr-4 rounded-lg border border-gray-400 w-full py-1 focus:outline-none focus:border-blue-400">
                    <option value="">-- choose country --</option>
                    @foreach($countries as $id => $country)
                        <option value="{{ $id }}">{{ $country }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach($teachers as $teacher)
            <tr class="@if ($loop->iteration % 2 == 0) bg-white @else bg-gray-100 @endif">
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">{{ $teacher->name }}</td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">{{ $teacher->surname }}</td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">{{ $teacher->country->name ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $teachers->links() }}
</div>