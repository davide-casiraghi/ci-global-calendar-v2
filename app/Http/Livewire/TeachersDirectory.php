<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Services\TeacherService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Display the /teachersDirectory page.
 *
 * @author Davide Casiraghi
 */
class TeachersDirectory extends Component
{
    use WithPagination;

    public $countries = [];
    public $sortColumn = 'name';
    public $sortDirection = 'asc';
    public $searchColumns = [
        'name' => '',
        'surname' => '',
        'country_id' => 0,
    ];

    public function mount()
    {
        $this->countries = Country::pluck('name', 'id');
    }

    /**
     * Order the results by the clicked filter in the blade view.
     * Invoked with wire:click
     */
    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function updating($value, $name)
    {
        $this->resetPage();
    }

    public function render()
    {
        $teacherService = App::make(TeacherService::class);
        $teachers = $teacherService->getTeachers(20, $this->searchColumns, false, $this->sortColumn, $this->sortDirection);

        return view('livewire.teachers-directory', [
            //'teachers' => $teachers->paginate(10)
            'teachers' => $teachers
        ]);
    }
}
