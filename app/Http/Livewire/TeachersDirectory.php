<?php

namespace App\Http\Livewire;

use App\Models\Country;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

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
        $teachers = Teacher::select([
            'teachers.name',
            'teachers.surname',
            'teachers.country_id as country_id',
            'countries.name as country_name',
        ])
            ->leftJoin('countries',
                'teachers.country_id',
                '=',
                'countries.id');

        foreach ($this->searchColumns as $column => $value) {
            if (!empty($value)) {
                if ($column == 'country_id') {
                    $teachers->where($column, $value);
                } else {
                    $teachers->where('teachers.'.$column, 'LIKE', '%'.$value.'%');
                }
            }
        }

        $teachers->orderBy($this->sortColumn, $this->sortDirection);

        return view('livewire.teachers-directory', [
            'teachers' => $teachers->paginate(5)
        ]);
    }
}
