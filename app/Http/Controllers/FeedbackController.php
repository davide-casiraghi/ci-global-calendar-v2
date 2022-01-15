<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeedbackController extends Controller
{
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
    public function sendMail(FeedbackFormRequest $message, Recipient $recipient)
    {
        $recipient->notify(new ContactFormMessage($message));

        return redirect()->back()->with('message', 'Thanks for your message! We will get back to you soon!');
    }
}
