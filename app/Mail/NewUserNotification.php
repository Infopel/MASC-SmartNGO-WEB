<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.new_user')->with([
            'name' => 'Edilson Mucanze',
            'link' => null,
            'subject' => 'subject'
        ]);

        return $this->from(env('MAIL_FROM_ADDRESS', 'sistema@cescmoz.org'), env('MAIL_FROM_NAME'))
            ->subject('Mailtrap Confirmation')
            ->markdown('mails.new_user')
            ->with([
                'name' => 'New Mailtrap User',
                'link' => 'https://mailtrap.io/inboxes'
            ]);
    }
}
