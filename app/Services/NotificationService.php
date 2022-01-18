<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use App\Notifications\ExpiringEventMailNotification;
use App\Notifications\FeedbackMailNotification;
use App\Notifications\ReportMisuseMailNotification;
use App\Notifications\WriteForMoreInfoMailNotification;
use App\Repositories\UserRepositoryInterface;

class NotificationService
{
    private UserRepositoryInterface $userRepository;

    /**
     * NotificationService constructor.
     *
     * @param \App\Repositories\UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Sends an email to the admin when the feedback form is submitted.
     *
     * @param  array  $data
     * @return bool
     */
    public function sendEmailFeedback(array $data): bool
    {
        $adminUser = $this->userRepository->getByEmail(env('ADMIN_MAIL'));
        $adminUser->notify(new FeedbackMailNotification($data));

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
     * Email the event owner to get more information.
     *
     * @param  array  $data
     * @param  Event  $event
     *
     * @return bool
     */
    public function sendEmailWriteForMoreInfo(array $data, Event $event): bool
    {
        $event->user->notify(new WriteForMoreInfoMailNotification($data, $event));
        return true;
    }

    /**
     * Email the admin and event owned to report a misuse.
     *
     * @param  array  $data
     * @param  Event  $event
     *
     * @return bool
     */
    public function sendEmailReportMisuse(array $data, Event $event): bool
    {
        dd($data);
        switch ($data['reason']) {

            case 'It is not translated in english':
                $event->user->notify(new ReportMisuseMailNotification($data, $event));
            default:
                $event->user->notify(new ReportMisuseMailNotification($data, $event));
        }

        //$event->user->notify(new ReportMisuseMailNotification($data, $event));
        return true;
    }


}
