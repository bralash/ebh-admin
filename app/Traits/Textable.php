<?php

namespace App\Traits;

use NotificationChannels\Hubtel\HubtelMessage;
use NotificationChannels\Hubtel\HubtelChannel;

trait Textable
{
    /**
     * The username of the reciever
     * @var string
     */
    protected $username;

    /**
     * The phone number of the reciever
     * @var string
     */
    protected $phone;

    /**
     * Body text of the notification
     * @var string
     */
    protected $body;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [HubtelChannel::class];
    }

    /**
     * Construct the Notification instance + initializes the phone and username props
     *
     * @param  \stdClass  $notification
     * @return void
     */
    protected function construct()
    {
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSMS($notifiable)
    {
        $this->phone = $notifiable->phone;
        $this->username = $notifiable->username;

        self::construct($notifiable);

        return (new HubtelMessage)
                    ->from("iincomerGh")
                    ->to($this->phone)
                    ->content($this->body);
    }
}
