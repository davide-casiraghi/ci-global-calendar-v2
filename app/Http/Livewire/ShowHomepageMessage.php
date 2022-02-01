<?php

namespace App\Http\Livewire;

use App\Services\HomepageMessageService;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class ShowHomepageMessage extends Component
{
    public function render()
    {
        $homepageMessageService = App::make(HomepageMessageService::class);
        $message = $homepageMessageService->getThePublishedMessage();

        return view('livewire.show-homepage-message', [
            'message' => $message,
        ]);
    }
}
