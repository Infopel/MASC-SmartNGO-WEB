<?php

namespace App\Pipes\ApprovementFlows;

use Closure;
use App\Models\Roles;
use App\Models\Projects;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Features\SolicitacaoFundos\FlowApprovementManager;

class AssignedUserToNotifePipeSection
{
    public function handle($request, Closure $next)
    {
        if ($request['usersToApprove'] ?? [] == null) {
            $usersToSendRequestTo = $this->getUsersToSendEmailNotificationTo(Projects::where('type', 'Project')->first(), $request['approvementFlow']->role);
            $_usersToApprove = $usersToSendRequestTo[0]->id;
        } else {
            $_usersToApprove = $request['usersToApprove'];
        }

        return $next([
            "data" => $request['data'],
            'approvementFlow' => $request['approvementFlow'],
            'assignedTo' => $_usersToApprove,
            'project_id' => 17
        ]);
    }


    /**
     * This method will return the users to send email notification to
     *
     * @param \App\Models\Projects $project
     * @param \App\Models\Roles $role
     * @return array
     */
    protected function getUsersToSendEmailNotificationTo(Projects $project, Roles $role): array
    {
        $users = [];
        // check if user is a member of the project with valid role
        foreach ($project->members as $key => $member) {
            if ($member->member_roles()->where('role_id', $role->id)->first()) {
                $users[] = $member->user;

                Log::alert([
                    "time" => time(),
                    "message" => "Fluxo de aprovação",
                    "user_to" => $member->user,
                    "class" => FlowApprovementManager::class,
                    "project" => $project,
                    "role" => $role,
                    "members" => $project->members,
                ]);
            }
        }
        if (sizeOf($users) == 0) {
            throw new \Exception("Fatal Error! User with valid role({$role['name']}) to approve the requested flow has not been found!", 10701);
        };
        return $users;
    }
}
