<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Issue;

class IssueDummyNotification extends Notification
{
    //use Queueable;


    protected $issue;

    protected $title;

    /**
     * Create a new notification instance.
     */
    public function __construct(Issue $issue, string $title)
    {
        $this->issue = $issue;
        $this->title = $title;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->issue->title .
                PHP_EOL
                . $this->issue->address->readable(),
        ];
    }
}
