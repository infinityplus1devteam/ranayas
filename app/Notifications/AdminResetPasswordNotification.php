<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('Reset Admin Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your admin account.'))
            ->action(Lang::get('Reset Password'), url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false)))
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.admins.expire', 60)]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }
}
