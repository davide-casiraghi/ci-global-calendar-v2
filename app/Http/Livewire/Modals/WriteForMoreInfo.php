<?php

namespace App\Http\Livewire\Modals;

use App\Models\Event;
use App\Rules\CaptchaSessionMatch;
use App\Services\NotificationService;
use Livewire\Component;
use function __;
use function view;

/**
 * Display the button "Write for more info" in the event show view.
 * The button opens a modal that allow the user to request info sending an email to the event organizer.
 *
 * @author Davide Casiraghi
 */
class WriteForMoreInfo extends Component
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
        return view('livewire.modals.write-for-more-info');
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
     * Reload captcha image.
     */
    public function reloadCaptchaLivewire(): void
    {
        $this->emit('reload_captcha');
    }

    /**
     * Send the message and close the modal.
     */
    public function sendMessage(NotificationService $notificationService): void
    {
        $this->validate();

        $notificationService->sendEmailWriteForMoreInfo($this->data, $this->event);

        $this->showModal = false;
        $message = __('event.message_sent_to_organizers');
        $this->emit('livewireContextualFeedback', ['message' => $message, 'status' => 'success']);

        $this->data = [];
    }
}
