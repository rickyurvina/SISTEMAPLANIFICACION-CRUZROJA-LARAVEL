<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;

class ActivityDueNotification extends Notification
{
    use Queueable;

    protected array $parameters;

    /**
     * Create a new notification instance.
     *
     * @param array $parameters
     * @return void
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }


    public function via($notifiable)
    {
//        return $this->parameters['via'];
         return ['mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = new MailMessage();
        $mailMessage->subject($this->parameters['mail']['subject'])
            ->line($this->parameters['mail']['line'])
            ->action('Ver', $this->parameters['mail']['url'])
            ->salutation($this->parameters['mail']['salutation']);
        return $mailMessage;
    }

    /**
     * Get the database representation of the notification.
     *
     * @param $notifiable
     * @return CreateNotification[]
     */

    public function toDatabase($notifiable)
    {
        return [
            'username' => $this->parameters['database']['username'],
            'title' => $this->parameters['database']['title'],
            'description' => $this->parameters['database']['description'],
            'url' => $this->parameters['database']['url'],
        ];
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
