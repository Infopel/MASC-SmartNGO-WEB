<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueEmailNotifications;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SolicitacaoFundosNotificationEvent;

class SendSolicitacaoFundosNotification
{

    private $useRole = false;
    private $role;
    private $project;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // query each user
        foreach ($event->email_to as $key => $user) {
            $email_address = $user->email_address->address;
            try {
                Mail::to('' . $email_address . '')
                    ->send(new \App\Mail\IssueEmailNotifications($user, $event->email_content, null, $event->title));
            } catch (\Throwable $th) {
                Log::alert([
                    "message" => "Email Notification send failed",
                    "user" => $user,
                    "class" => SolicitacaoFundosNotificationEvent::class,
                    "Error" => $th->getMessage()
                ]);
            }
        }
    }
}
