<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityStarted extends Notification
{
    use Queueable;

    protected array $parameters;

    /**
     * Create a new notification instance.
     *
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
        $mailMessage->line($this->parameters['mail']['line'])
            ->salutation($this->parameters['mail']['salutation'])
            ->action('Ver',$this->parameters['mail']['url'])
            ->greeting($this->parameters['mail']['greeting']);
        return $mailMessage;

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
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

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
