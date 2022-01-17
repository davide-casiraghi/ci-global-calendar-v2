<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Services\NotificationService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class WriteForMoreInfo extends Component
{
    public $showModal = false;
    public $showSentMessage = false;
    public $data;

    protected $rules = [
        'data.name' => ['required', 'string', 'max:255'],
        'data.email' => ['required', 'string', 'email', 'max:255'],
        'data.message' => ['required', 'string'],
    ];

    protected $messages = [
        'data.name.required' => 'The Name cannot be empty.',
        'data.email.required' => 'The Email address cannot be empty.',
        'data.email.email' => 'The Email Address format is not valid.',
        'data.message.required' => 'The Message cannot be empty.',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.write-for-more-info');
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
    public function sendMessage(): void
    {
        $notificationService = App::make(NotificationService::class);

        $this->validate();

        $notificationService->sendEmailWriteForMoreInfo($this->data, $this->event);

        /*$this->emit('refreshTeachersDropdown', ['teacher' => $teacher]);*/

        $this->showModal = false;
        $this->showSentMessage = true;
        $this->data = [];
    }
}
