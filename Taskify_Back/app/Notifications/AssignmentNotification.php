<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentNotification extends Notification
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Hello,'.$notifiable->name)
            ->line('You have been assigned a new task:')
            ->line('Title: '.$this->task->title)
            ->line('In '.$this->task->workspace->title)
            ->line('By: '.$this->task->createdBy()->first()->name)
            ->action('View Task', url('/tasks/'.$this->task->id))
            ->line('Good luck!');
    }
}
