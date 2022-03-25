<?php

namespace App\Http\Livewire\Modals;

use App\Models\Event;
use App\Rules\CaptchaSessionMatch;
use App\Services\EventService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use function __;
use function view;

class ClaimEvent extends Component
{
    public $showModal = false;
    public $data;

    protected $rules = [
        'data.name' => ['required', 'string', 'max:255'],
        'data.email' => ['required', 'string', 'email', 'max:255'],
        'data.message' => ['required', 'string'],
        'data.captcha' => ['required','captcha'],
    ];

    protected $messages = [
        'data.name.required' => 'The Name cannot be empty.',
        'data.email.required' => 'The Email address cannot be empty.',
        'data.email.email' => 'The Email Address format is not valid.',
        'data.message.required' => 'The Message cannot be empty.',
        'data.captcha.required' => 'Invalid captcha.',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.modals.claim-event');
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
    public function closeClaim(): void
    {
        $this->showModal = false;
    }

    /**
     * Reload captcha image.
     */
    public function reloadCaptchaLivewire(): void
    {
        $this->emit('reload_captcha');
    }

    /**
     * Send the message and close the modal.
     */
    public function sendMessage(): void
    {
        $this->validate();

        $notificationService = App::make(NotificationService::class);
        $eventService = App::make(EventService::class);

        $notificationService->sendClaimEventEmailToAdmin($this->data, $this->event);
        $eventService->setClaimEventUserId($this->event, Auth::id());

        $this->showModal = false;
        $message = __('event.message_sent_to_organizers');
        $this->emit('livewireContextualFeedback', ['message' => $message, 'status' => 'success']);

        $this->data = [];
    }
}
