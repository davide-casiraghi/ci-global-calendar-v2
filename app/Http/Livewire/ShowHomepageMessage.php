<?php

namespace App\Http\Livewire;

use App\Services\HomepageMessageService;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

/**
 * Shows the Homepage Messages created from the backend by the administrators.
 * When the user close the message, a cookie get stored and the message is not shown anymore for 14 days.
 *
 * @author Davide Casiraghi
 */
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
