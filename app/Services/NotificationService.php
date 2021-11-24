<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Insight;
use App\Models\User;
use App\Notifications\ContactMeMailNotification;
use App\Notifications\ExpiringEventMailNotification;
use App\Notifications\GetATreatmentMailNotification;
use App\Notifications\InsightNotification;
use App\Notifications\NewTestimonialMailNotification;

class NotificationService
{

    /**
     * Send an email when the contact form is submitted
     *
     * @param array $data
     * @param int $userId
     *
     * @return bool
     */
    public function sendEmailContactMe(array $data, int $userId): bool
    {
        $user = User::find($userId);
        $user->notify(new ContactMeMailNotification($data));

        return true;
    }

    /**
     * Send an email when the get a treatment form is submitted
     *
     * @param array $data
     * @param int $userId
     *
     * @return bool
     */
    public function sendEmailGetATreatment(array $data, int $userId): bool
    {
        $user = User::find($userId);
        $user->notify(new GetATreatmentMailNotification($data));

        return true;
    }

    /**
     * Send an email when the new testimonial form is submitted
     *
     * @param  array  $data
     * @param  int  $userId
     *
     * @return bool
     */
    public function sendEmailNewTestimonial(array $data, int $userId): bool
    {
        $user = User::find($userId);
        $user->notify(new NewTestimonialMailNotification($data));

        return true;
    }

    /**
     * Send an email to expiring event organizer
     *
     * @param  array  $data
     * @param  Event  $event
     *
     * @return bool
     */
    public function sendEmailExpiringEvent(array $data, Event $event): bool
    {
        $event->user->notify(new ExpiringEventMailNotification($data, $event));
        return true;
    }

    /**
     * Send a tweet with an insight
     *
     * @param  array  $data
     * @param  Insight  $insight
     *
     * @return bool
     */
    public function sendTwitterInsight(array $data, Insight $insight): bool
    {
        $insight->notify(new InsightNotification($data));

        return true;
    }
}
