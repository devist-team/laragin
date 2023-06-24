<?php

namespace Devist\Laragin\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTPNotification extends Notification
{
    public string $otp;
    public string $channel;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $otp, string $channel)
    {
        $this->otp     = $otp;
        $this->channel = $channel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->channel];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('OTP Code')
            ->line(
                'As a security measure, we require you to enter a one-time password (OTP) to access your account. Your OTP is:'
            )
            ->line("**$this->otp**")
            ->line(
                'Please enter this code on the login page to gain access to your account. Please note that this code is only valid for a limited time and can only be used once.'
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
