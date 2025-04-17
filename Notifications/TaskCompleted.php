<?php

declare(strict_types=1);

namespace Modules\Job\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Modules\Job\Models\Task;

class TaskCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    private string $output;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $output)
    {
        $this->output = $output;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param Task $notifiable
     */
    // public function via(mixed $notifiable): array {
    public function via($notifiable): array
    {
        $channels = [];
        if ($notifiable->notification_email_address) {
            $channels[] = 'mail';
        }
        if ($notifiable->notification_phone_number) {
            $channels[] = 'nexmo';
        }
        if ($notifiable->notification_slack_webhook) {
            $channels[] = 'slack';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(Task $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject($notifiable->description)
            ->greeting('Hi,')
            ->line("{$notifiable->description} just finished running.")
            ->line($this->output);
    }

    /*
     * Get the Nexmo / SMS representation of the notification.

    public function toNexmo(mixed $notifiable): NexmoMessage
    {
        return (new NexmoMessage())
            ->content($notifiable->description.' just finished running.');
    }
    */

    /*
     * Get the Slack representation of the notification.

    public function toSlack(mixed $notifiable): SlackMessage
    {
        return (new SlackMessage())
            ->content(config('app.name'))
            ->attachment(function (SlackAttachment $attachment) use ($notifiable) {
                $attachment
                    ->title('Totem Task')
                    ->content($notifiable->description.' just finished running.');
            });
    }
    */
}
