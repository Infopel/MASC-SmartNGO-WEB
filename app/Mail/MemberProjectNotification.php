<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberProjectNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $proejct;
    public $user;
    public $role;
    public $email_subject;
    public $email_content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_subject, $email_content, $user)
    {
        $this->email_subject = $email_subject;
        $this->email_content = $email_content;
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
        // $user_id = $this->user['id'];
        return $this->from(env('MAIL_FROM_ADDRESS', 'sistema@cescmoz.org'), env('MAIL_FROM_NAME'))
            ->subject('MASC - ' . $this->email_subject)
            ->markdown('mails.projects.member_project')
            ->with([
                'email_to' => $firstname . ' ' . $lastname,
                'content' => $this->email_content
            ]);
    }
}
