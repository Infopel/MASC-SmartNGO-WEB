<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\MemberProjectNotificationEvent;

class SendNewMemberProjectNotification implements ShouldQueue
{
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
     * @param  MemberProjectNotificationEvent  $event
     * @return void
     */
    public function handle(MemberProjectNotificationEvent $event)
    {
        try {
            Mail::to('' . $event->user->email_address->address . '')
            ->send(new \App\Mail\MemberProjectNotification($event->email_subject, $event->email_content, $event->user));
        } catch (\Throwable $th) {
            // throw $th;
            Log::info([
                "message" => "Email Notification send failed",
                "user" => $event->user,
                "calss" => MemberProjectNotificationEvent::class,
                "Error" => $th->getMessage()
            ]);
        }
    }
}
