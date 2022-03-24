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

        // Redirect to homepage or dashboard
        if($value){
            return redirect()->to('/dashboard');
        }
        else{
            return redirect()->to('/');
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.toggle-button-backend-frontend');
    }
}
