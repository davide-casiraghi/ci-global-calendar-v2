<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;

class WriteForMoreInfo extends Component
{
    public $showModal = false;

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
}
