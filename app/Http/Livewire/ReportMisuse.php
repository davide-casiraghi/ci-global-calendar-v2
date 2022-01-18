<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Services\NotificationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class ReportMisuse extends Component
{
    public $showModal = false;
    public $showSentMessage = false;
    public $data;

    protected $rules = [
        'data.reason' => ['required'],
        'data.email' => ['required', 'string', 'email', 'max:255'],
        'data.message' => ['required', 'string'],
    ];

    protected $messages = [
        'data.reason.required' => 'The Reason cannot be empty.',
        'data.email.required' => 'The Email address cannot be empty.',
        'data.email.email' => 'The Email Address format is not valid.',
        'data.message.required' => 'The Message cannot be empty.',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->possibleMisuses = $this->getPossibleMisuse();
    }

    public function render()
    {
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
    public function close(): void
    {
        $this->showModal = false;
    }

    /**
     * Return the possible misuse cases.
     * They are encoded as collection of objects to be used in
     * the select blade partial that accept a collection of object
     * as record attribute.
     *
     * @return Collection
     */
    public function getPossibleMisuse(): Collection
    {
        return collect([
            (object)['id'=> __('misuse.not_about_ci'), 'name'=> __('misuse.not_about_ci')],
            (object)['id'=> __('misuse.contains_wrong_info'), 'name'=> __('misuse.contains_wrong_info')],
            (object)['id'=> __('misuse.not_translated_english'), 'name'=> __('misuse.not_translated_english')],
            (object)['id'=> __('misuse.other'), 'name'=> __('misuse.other')],
        ]);
    }

    /**
     * Store a newly created teacher in storage.
     */
    public function sendMessage(): void
    {
        $notificationService = App::make(NotificationService::class);

        $this->validate();

        $notificationService->sendEmailReportMisuse($this->data, $this->event);

        $this->showModal = false;
        $this->showSentMessage = true;
        $this->data = [];
    }

}
