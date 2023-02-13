<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IssuesDBNotification extends Notification
{
    use Queueable;

    public $issue;
    public $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue, $title)
    {
        $this->issue = $issue;
        $this->title = $title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'title' => $this->title,
            'issue' => $this->issue,
            'project' => $this->issue->project ?? null,
        ];
    }

}
