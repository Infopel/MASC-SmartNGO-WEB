<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserWelcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @return App\Models\User::class
     */
    protected $user;

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
        $lastname = $this->user['lastname'] ?? 'Apelido';
        $user_id = $this->user['id'];
        // http://gespro.co.mz/account/'.$firstname.'/'.'activation/'.$user_id
        return $this->from(env('MAIL_FROM_ADDRESS', 'sistema@cescmoz.org'), env('MAIL_FROM_NAME'))
            ->subject('MASC - Confirmação de conta')
            ->markdown('mails.user.welcome')
            ->with([
                'login' => $this->user['login'] ?? 'user.login',
                'name' => $firstname . ' ' . $lastname,
                'password' => $this->user['unhashed_password'] ?? '',
                'link' => 'http://3.130.36.108/login',
                'pathToImage' => 'https://laravel.com/img/logotype.min.svg',
                'url' => null,
            ]);
    }
}
