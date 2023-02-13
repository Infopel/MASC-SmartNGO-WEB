<?php

namespace App\Listeners;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Events\IssuesNotificationEvent;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\IssuesDBNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendIssuesNotification
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
     * @param  IssuesNotificationEvent  $event
     * @return void
     */
    public function handle(IssuesNotificationEvent $event)
    {

        if($event->useRole){
            $users = $this->GetUserByProjectRole($event->issue->project, $event->allowed_permission,$event->role);
        }else{
            $users = $this->get_user_to_send_email($event->issue->project, $event->allowed_permission);
        }

        foreach ($users as $key => $user) {

            $email_address = $user->email_address->address;

            Notification::send([$user], new IssuesDBNotification($event->issue, $event->title));

            try {
                Mail::to('' . $email_address . '')
                ->send(new \App\Mail\IssueEmailNotifications($user, $event->email_content, $event->issue, $event->title));
            } catch (\Throwable $th) {
                //throw $th;
                Log::alert([
                    "message" => "Email Notification send failed",
                    "user" => $user,
                    "class" => IssuesNotificationEvent::class,
                    "Error" => $th->getMessage()
                ]);
            }
        }
    }

    protected function GetUserByProjectRole($project, $allowed_permission, $role)
    {
        $email_to = [];
        if ($allowed_permission[0] == 'to_author') {
            $email_to = array(auth()->user());
        }
        // check if user is a member of the project with valid role
        foreach ($project->members as $key => $member) {
            if ($member->member_roles()->where('role_id', $role->id)->first()) {
                $email_to[] = $member->user;
            }
        }
        return $email_to;
    }

    protected function get_user_to_send_email($project, $allowed_permission)
    {
        $email_to = [];
        foreach ($allowed_permission as $key => $permission) {
            if($permission == 'to_author'){
                return $email_to[] = array(auth()->user());
            }
            // 1 Pegar os membros do projectos e seus roles no projecto
            foreach ($project->members as $key => $member) {
                $roles_permissions = Yaml::parse($member->member_roles->roles[0]->permissions ?? '');
                if ($roles_permissions !== null) {
                    if (in_array($permission, $roles_permissions)) {
                        $email_to[] = $member->user;
                    }
                }
            }
        }
        return $email_to;
    }
}
