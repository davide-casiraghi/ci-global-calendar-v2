<?php

namespace App\Http\Livewire;

use App\Services\NotificationService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class FeedbackMessage extends Component
{
    public $showModal = false;
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

    public function render()
    {
        return view('livewire.feedback-message');
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
     * Send the message and close the modal.
     */
    public function sendMessage(): void
    {
        $notificationService = App::make(NotificationService::class);

        $this->validate();

        $notificationService->sendEmailFeedback($this->data);

        $this->showModal = false;
        $message = __('general.feedback_thanks');
        $this->emit('livewireContextualFeedback', ['message' => $message, 'status' => 'success']);

        $this->data = [];
    }
}
