<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiringEventMailNotification extends Notification
{
    use Queueable;

    protected array $senderData;
    protected Event $event;

    /**
     * Create a new notification instance.
     *
     * @param array $senderData
     * @param \App\Models\Event $event
     */
    public function __construct(array $senderData, Event $event)
    {
        $this->senderData = $senderData;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Expiring Event - CI Global Calendar')
            ->markdown('mail.expiringEvent', [
                'event' => $this->event,
                'senderData' => $this->senderData
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
