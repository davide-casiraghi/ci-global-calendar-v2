<?php

namespace App\Http\Livewire;

use App\Helpers\ImageHelpers;
use App\Repositories\TeacherRepository;
use App\Services\CountryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Show the organizer dropdown and 'Add teacher' button in the event create and edit views.
 *
 * @author Davide Casiraghi
 */
class AddTeacher extends Component
{
    use WithFileUploads;

    public $teachers;
    public $selected;
    public $showModal = false;
    public $newTeacher;
    public $profilePicture;

    protected $rules = [
        'newTeacher.country_id' => ['required', 'string'],
        'newTeacher.name' => ['required', 'string', 'max:255'],
        'newTeacher.surname' => ['required', 'string', 'max:255'],
        'newTeacher.bio' => ['required', 'string'],
        'newTeacher.year_starting_practice' => ['required', 'integer','min:1972'],
        'newTeacher.year_starting_teach' => ['required', 'integer','min:1972'],
        'newTeacher.significant_teachers' => ['required', 'string'],
        'newTeacher.facebook' => ['nullable', 'url'],
        'newTeacher.website' => ['nullable', 'url'],
        'profilePicture' => ['nullable'], // 5MB Max - , 'image','mimes:jpg,jpeg,png','max:5120'
    ];

    protected $listeners = [
        'fileUpload' => 'handleFileUpload',
    ];

    public function handleFileUpload($imageData)
    {
        $this->profilePicture = $imageData;
    }

    /**
     * The component constructor
     *
     * @param  Collection  $teachers
     * @param array|null $selected
     */
    public function mount(Collection $teachers, ?array $selected)
    {
        $this->teachers = $teachers;
        $this->selected = $selected;
    }

    /**
     * Default component render method
     */
    public function render()
    {
        $countryService = App::make(CountryService::class);
        $countries = $countryService->getCountries();

        return view('livewire.add-teacher', ['countries' => $countries]);
    }

    /**
     * Open the modal
     */
    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * Close the modal
     */
    public function close(): void
    {
        $this->showModal = false;
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function saveTeacher(TeacherRepository $teacherRepository): void
    {
        $this->validate();

        $teacher = $teacherRepository->store($this->newTeacher);
        ImageHelpers::storeImageFromLivewireComponent($teacher, $this->profilePicture, 'profile_picture');

        $this->selected[] = $teacher->id;
        $this->teachers = $teacherRepository->getAll();

        $this->emit('refreshTeachersDropdown', ['teacher' => $teacher]);

        $this->showModal = false;

        $this->newTeacher = [];
    }
}
