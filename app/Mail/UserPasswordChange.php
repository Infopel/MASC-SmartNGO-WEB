<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPasswordChange extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $firstname = $this->user['firstname'] ?? 'Primeio Nome';
        $lastname = $this->user['lastname'] ?? null;
        $user_id = $this->user['id'];
        return $this->from(env('MAIL_FROM_ADDRESS', 'sistema@cescmoz.org'), env('MAIL_FROM_NAME'))
            ->subject('MASC - Notificação de segurança')
            ->markdown('mails.user.password_change')
            ->with([
                'name' => $firstname . ' ' . $lastname,
                'password' => $this->user['unhashed_password'] ?? 'password',
                'pathToImage' => 'https://laravel.com/img/logotype.min.svg',
                'url_app' => 'http://3.130.36.108/',
                'url' => 'http://gespro.co.mz/account/' . $firstname . '/' . 'activation/' . $user_id,
            ]);
    }
}
