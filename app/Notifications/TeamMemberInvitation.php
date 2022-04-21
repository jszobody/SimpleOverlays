<?php

namespace App\Notifications;

use App\Models\Invite;
use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberInvitation extends Notification
{
    use Queueable;

    /**
     * @var Invite
     */
    protected Invite $invite;

    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Invitation to join {$this->invite->team->name} on Eclipse")
            ->line("{$this->invite->user->name} has invited you to join the '{$this->invite->team->name}' team on Eclipse.")
            ->action('Accept invitation', route())
            ->line('Eclipse helps you rapidly develop content overlays for your video productions.');
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
