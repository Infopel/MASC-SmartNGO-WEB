<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IssueEmailNotifications extends Mailable
{
    use Queueable, SerializesModels;

    protected $author;
    protected $email_to;
    protected $email_content;
    protected $issue;
    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user = null, $content, $issue = null, $title)
    {
        $this->email_to = $user;
        $this->author = auth()->user();
        $this->email_content = $content;
        $this->issue = $issue;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS', 'sistema@cescmoz.org'), env('MAIL_FROM_NAME'))
            ->subject('MASC - ' . $this->title)
            ->markdown('emails.issues.email-notifications')
            ->with([
                'issue' => $this->issue,
                'content' => $this->email_content,
                'author' => $this->author,
                'email_to' => $this->email_to,
                'title' => $this->title
            ]);
    }
}
