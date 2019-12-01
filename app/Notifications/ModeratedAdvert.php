<?php

namespace App\Notifications;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class ModeratedAdvert extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    private $advert;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Advert $advert)
    {
        //
        $this->advert = $advert;
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
                    ->line('Your advert was moderated')
                    ->action('Show your advert', route('adverts.show',['advert'=>$this->advert]))
                    ->line('Thank you for using our application!');
    }

}
