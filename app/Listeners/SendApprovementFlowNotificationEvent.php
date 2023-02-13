<?php

namespace App\Listeners;

use App\Models\Roles;
use App\Models\Projects;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueEmailNotifications;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\IssuesDBNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Events\ApprovementFlowNotificationEvent;
use App\Http\Controllers\Helpers\ApprovementFlowHelper;

class SendApprovementFlowNotificationEvent
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
     * @param  ApprovementFlowNotificationEvent  $event
     * @return void
     */
    public function handle(ApprovementFlowNotificationEvent $event)
    {
        $user = $event->approvement->assignedTo;

        try {
            $email_address = $user->email_address->address;
        } catch (\Throwable $th) {
            $email_address = 'edilsonhmberto@gmail.com';
            Log::alert([
                "message" => "User has no email address configured to receive notifications.",
                "user" => $user,
                "class" => ApprovementFlowNotificationEvent::class,
                "Error" => $th->getMessage()
            ]);
        }

        try {
            Notification::send([$user], new IssuesDBNotification($event->resource, "ApprovementFlowNotificationEvent"));
        } catch (\Throwable $th) {
            Log::alert([
                "message" => "IssuesDBNotification Notification failed",
                "user" => $user,
                "class" => ApprovementFlowNotificationEvent::class,
                "Error" => $th->getMessage()
            ]);
        }

        try {
            $trigger = "<b>" . $event->approvement->approvement_flow->description . "</b>";
            $issue = "<a href='" . route('issues.show', ['issue' => $event->resource->id]) . "'>" . $event->resource->subject . "</a>";
            $project = "<a href='" . route('projects.overview', ['project_identifier' => $event->resource->project->identifier]) . "' target='_blank'>" . $event->resource->project->name . "</a>";

            $start_on = $event->resource->start_date ?? '<i>Undefined Date</i>';
            $role_trigger = $event->approvement->approvement_flow->role->name ?? "Project Member Profile";

            $replace = [':trigger', ':issue', ':projpect', ':start_on', ':role_trigger'];

            $title = \time() . " - " . $event->approvement->approvement_flow->description ?? $event->approvement->approvement_flow->description;
            $email_content = \str_replace($replace, [$trigger, $issue, $project, $start_on, $role_trigger],   $event->approvement->approvement_flow->email_content);
        } catch (\Throwable $th) {
            throw new \Exception("Error while parsing email content data to processs notification. \nDetails: " . $th->getMessage());
        }

        try {
            Mail::to('' . $email_address . '')
                ->send(new \App\Mail\IssueEmailNotifications($user, $email_content, $event->resource, $title));
        } catch (\Throwable $th) {
            // throw new \Exception($th->getMessage());
            Log::alert([
                "message" => "Email Notification send failed",
                "user" => $user,
                "class" => ApprovementFlowNotificationEvent::class,
                "Error" => $th->getMessage()
            ]);
        }
    }
}
