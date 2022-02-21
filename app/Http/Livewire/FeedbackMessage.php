<?php

namespace App\Http\Livewire;

use App\Rules\CaptchaSessionMatch;
use App\Services\NotificationService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

/**
 * Display the button "Send a feedback or Report a bug" in the footer.
 * The button opens a modal that allow the user to write an email to the administrator.
 *
 * @author Davide Casiraghi
 */
class FeedbackMessage extends Component
{
    public $showModal = false;
    public $data;

    /*
    protected $rules = [
        'data.name' => ['required', 'string', 'max:255'],
        'data.email' => ['required', 'string', 'email', 'max:255'],
        'data.message' => ['required', 'string'],
        'data.captcha' => ['required', new CaptchaSessionMatch],
    ];
*/
    protected $messages = [
        'data.name.required' => 'The Name cannot be empty.',
        'data.email.required' => 'The Email address cannot be empty.',
        'data.email.email' => 'The Email Address format is not valid.',
        'data.message.required' => 'The Message cannot be empty.',
        'data.captcha.required' => 'Invalid captcha.',
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
        $validatedData = $this->validate([
           'data.name' => ['required', 'string', 'max:255'],
           'data.email' => ['required', 'string', 'email', 'max:255'],
           'data.message' => ['required', 'string'],
           //'data.captcha' => ['required', new CaptchaSessionMatch],
           'data.captcha' => ['required','captcha'],
       ]);

        //$this->validate();

        $notificationService->sendEmailFeedback($this->data);

        $this->showModal = false;
        $message = __('general.feedback_thanks');
        $this->emit('livewireContextualFeedback', ['message' => $message, 'status' => 'success']);

        $this->data = [];
    }
}
