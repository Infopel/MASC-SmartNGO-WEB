<?php

namespace App\Listeners;

use App\Jobs\UserPasswordUpdateJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Events\UserPasswordUpdateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordUpdateNotification implements ShouldQueue
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
     * @param  UserPasswordUpdateEvent  $event
     * @return void
     */
    public function handle(UserPasswordUpdateEvent $event)
    {
        sleep(5);
        try {
            // dispatch(new UserPasswordUpdateJob($event->user));
            $event->user->unhashed_password = $event->password;
            Mail::to('' . $event->user->email_address->address . '')->send(new \App\Mail\UserPasswordChange($event->user));
        } catch (\Throwable $th) {
            //throw $th;
            Log::alert([
                "message" => "Email Notification send failed",
                "user" => $event->user,
                "calss" => UserPasswordUpdateEvent::class,
                "Error" => $th->getMessage()
            ]);
        }
    }
}
