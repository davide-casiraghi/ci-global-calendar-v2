<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToggleButtonBackendFrontend extends Component
{
    public bool $showBackend;

    public function mount()
    {
        $this->showBackend = (bool) session()->get('showBackend');
    }

    /**
     * Update the value of the showBackend variable in the session.
     */
    public function updating($field, $value)
    {
        session()->put('showBackend', (bool) $value);

        // Reload the page.
        return redirect(request()->header('Referer'));
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.toggle-button-backend-frontend');
    }
}
