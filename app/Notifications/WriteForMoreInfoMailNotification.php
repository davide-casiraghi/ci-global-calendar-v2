<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WriteForMoreInfoMailNotification extends Notification
{
    use Queueable;

    protected array $data;
    protected Event $event;

    /**
     * Create a new notification instance.
     *
     * @param array $data
     * @param Event $event
     */
    public function __construct(array $data, Event $event)
    {
        $this->data = $data;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Request from the CI Global Calendar')
            ->markdown('mail.writeForMoreInfo', ['data' => $this->data, 'event' => $this->event]);
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
