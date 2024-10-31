<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        // إرسال الإشعار عبر القناة التي تختارها مثل البريد أو قاعدة البيانات
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'You have a new booking from ' . $this->booking->user->name,
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You have a new booking.')
                    ->action('View Booking', url('/bookings/' . $this->booking->id))
                    ->line('Thank you for using our application!');
    }
}
