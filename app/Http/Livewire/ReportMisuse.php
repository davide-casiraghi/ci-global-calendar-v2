<?php

namespace App\Http\Livewire;

use App\Helpers\Helper;
use App\Models\Event;
use App\Rules\CaptchaSessionMatch;
use App\Services\CaptchaService;
use App\Services\NotificationService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

/**
 * Display the button "Report misuse" in the event show view.
 * The button opens a modal that allow the user to report a misuse sending an email to the administrator.
 *
 * @author Davide Casiraghi
 */
class ReportMisuse extends Component
{
    public $showModal = false;
    public $data;
    public $captchaImage;

    /*
    protected $rules = [
        'data.reason' => ['required'],
        'data.email' => ['required', 'string', 'email', 'max:255'],
        'data.message' => ['required', 'string'],
        'data.captcha' => ['required', new CaptchaSessionMatch],
    ];*/

    protected $messages = [
        'data.reason.required' => 'The Reason cannot be empty.',
        'data.email.required' => 'The Email address cannot be empty.',
        'data.email.email' => 'The Email Address format is not valid.',
        'data.message.required' => 'The Message cannot be empty.',
        'data.captcha.required' => 'Invalid captcha.',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->possibleMisuses = Helper::getObjectsCollectionTranslated(Event::MISUSE_KIND);
    }

    public function render()
    {
        $captchaService = App::make(CaptchaService::class);

        // If there is no captcha stored in the session generate a new one.
        if(!session()->has('captcha')){
            $captchaService->prime();
        }
        $this->captchaImage = $captchaService->draw();

        return view('livewire.report-misuse');
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
    public function closeMisuse(): void
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
        $validatedData = $this->validate([
            'data.reason' => ['required'],
            'data.email' => ['required', 'string', 'email', 'max:255'],
            'data.message' => ['required', 'string'],
            'data.captcha' => ['required', new CaptchaSessionMatch],
        ]);

        //$this->validate();

        $notificationService = App::make(NotificationService::class);
        $notificationService->sendEmailReportMisuse($this->data, $this->event);

        $this->showModal = false;
        $message = __('event.report_sent'). ".<br>".__('event.administrator_will_check');
        $this->emit('livewireContextualFeedback', ['message' => $message, 'status' => 'success']);

        $this->data = [];
    }

}
