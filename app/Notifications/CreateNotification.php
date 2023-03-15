<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use  Illuminate\Notifications\Messages\SimpleMessage\SimpleMediaMessage;

class CreateNotification extends Notification
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

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->parameters['via'];
        // return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = new MailMessage();
        $mailMessage->subject($this->parameters['mail']['subject'])
            ->line($this->parameters['mail']['line'])
            ->action('Ver', $this->parameters['mail']['url'])
            ->greeting($this->parameters['mail']['greeting'])
            ->salutation($this->parameters['mail']['salutation']);
        if (isset($this->parameters['mail']['attach'])) {
            $mailMessage->attach($this->parameters['mail']['attach']->getRealPath(), [
                'as' => $this->parameters['mail']['as'],
                'mime' => $this->parameters['mail']['mime']
            ]);
        }
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
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
