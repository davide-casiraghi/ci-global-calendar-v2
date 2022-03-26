<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use App\Notifications\EventClaimMailNotification;
use App\Notifications\ExpiringEventMailNotification;
use App\Notifications\FeedbackMailNotification;
use App\Notifications\ReportMisuseMailNotification;
use App\Notifications\UserApprovedNotification;
use App\Notifications\UserRefusedNotification;
use App\Notifications\WriteForMoreInfoMailNotification;

class NotificationService
{
    private UserService $userService;

    /**
     * NotificationService constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(
        UserService $userService,
    ) {
        $this->userService = $userService;
    }

    /**
     * Sends an email to the admin when the feedback form is submitted.
     *
     * @param  array  $data
     * @return bool
     */
    public function sendEmailFeedback(array $data): bool
    {
        $adminUsers = $this->userService->getUsers(null, ['role' => 'Admin']);
        foreach ($adminUsers as $adminUser){
            $adminUser->notify(new FeedbackMailNotification($data));
        }

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
     * Email the admins to inform of an event claim.
     * Notice: The email is sent just to Admins, not to Super Admins.
     *
     * @param  array  $data
     * @param  Event  $event
     * @param  User  $user
     * @return bool
     */
    public function sendClaimEventEmailToAdmin(array $data, Event $event, User $user): bool
    {
        $adminUsers = $this->userService->getUsers(null, ['role' => 'Admin']);
        foreach ($adminUsers as $adminUser){
            $adminUser->notify(new EventClaimMailNotification($data, $event, $user));
        }
        return true;
    }

    /**
     * Email the admins and event owned to report a misuse.
     *
     * @param  array  $data
     * @param  Event  $event
     *
     * @return bool
     */
    public function sendEmailReportMisuse(array $data, Event $event): bool
    {
        switch ($data['reason']) {
            // In case the issue it's the missing translation write just to the event owner.
            case __('misuse.not_translated_english'):
                $event->user->notify(new ReportMisuseMailNotification($data, $event));
                break;

            // In any other case report to the admin.
            default:
                $adminUsers = $this->userService->getUsers(null, ['role' => 'Admin']);
                foreach ($adminUsers as $adminUser){
                    $adminUser->notify(new ReportMisuseMailNotification($data, $event));
                }
        }
        return true;
    }

    /**
     * Email notify the member that his subscription has been approved.
     *
     * @param User $user
     *
     * @return bool
     */
    public function sendEmailUserApproved(User $user): bool
    {
        $user->notify(new UserApprovedNotification($user));

        return true;
    }

    /**
     * Email notify the member that his subscription has been refused.
     *
     * @param User $user
     *
     * @return bool
     */
    public function sendEmailUserRefused(User $user): bool
    {
        $user->notify(new UserRefusedNotification($user));

        return true;
    }

}
