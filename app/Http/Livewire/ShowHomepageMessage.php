<?php

namespace App\Http\Livewire;

use App\Services\HomepageMessageService;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ShowHomepageMessage extends Component
{
    public bool $showHomepageMessage = true;

    public function render()
    {
        $homepageMessageService = App::make(HomepageMessageService::class);
        $message = $homepageMessageService->getThePublishedMessageCheckingCookie();

        return view('livewire.show-homepage-message', [
            'message' => $message,
        ]);
    }

    /**
     * Close the homepage message.
     * The message will be shown again 2 weeks later.
     */
    public function close(): void
    {
        $this->showHomepageMessage = false;

        // Create cookie that expires in 14 days.
        Cookie::queue('homepageMessageHide', true, 20160);
    }

}
