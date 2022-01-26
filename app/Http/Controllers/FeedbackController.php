<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackFormRequest;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeedbackController extends Controller
{
    private NotificationService $notificationService;

    public function __construct(
        NotificationService $notificationService,
    ) {
        $this->notificationService = $notificationService;
    }

    /**
     * Display the specified resource.
     *
     * @return View
     */
    public function show(): View
    {
        return view('feedback.show');
    }

    /**
     * Send email when the feedback form is submitted.
     * https://welcm.uk/blog/creating-a-contact-form-for-your-laravel-website
     * @param  FeedbackFormRequest  $message
     * @return RedirectResponse
     */
    public function sendMail(FeedbackFormRequest $message): RedirectResponse
    {
        $this->notificationService->sendEmailFeedback($message->toArray());

        session()->flash('success', __('general.feedback_thanks'));
        return redirect()->route('home');
    }
}
