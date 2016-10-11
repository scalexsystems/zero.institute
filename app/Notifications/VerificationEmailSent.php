<?php namespace Scalex\Zero\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VerificationEmailSent extends Notification implements ShouldQueue
{
    use Queueable;

    public $email;

    public function __construct(string $email) {
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable) {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable) {
        return [
            'message' => 'Verification email has been sent to '.$this->email.'.',
        ];
    }

    public function toBroadcast($notifiable) {
        return $this->toArray($notifiable);
    }
}
