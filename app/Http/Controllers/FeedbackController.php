<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackFormRequest;
use App\Services\NotificationService;
use Illuminate\Contracts\Foundation\Application;
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
     * @return View
     */
    public function sendMail(FeedbackFormRequest $message)
    {
        $this->notificationService->sendEmailFeedback($message->toArray());
        return redirect()->back()->with('message', 'Thanks for your message! We will get back to you soon!');
    }
}
