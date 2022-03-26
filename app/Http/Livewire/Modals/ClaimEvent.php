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
        'data.message' => ['required', 'string'],
        'data.captcha' => ['required','captcha'],
    ];

    protected $messages = [
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

        $notificationService->sendClaimEventEmailToAdmin($this->data, $this->event, Auth::user());
        $eventService->setClaimEventUserId($this->event, Auth::id());

        $this->showModal = false;
        $message = __('event.claim_message_sent');
        $this->emit('livewireContextualFeedback', ['message' => $message, 'status' => 'success']);

        $this->data = [];
    }
}
