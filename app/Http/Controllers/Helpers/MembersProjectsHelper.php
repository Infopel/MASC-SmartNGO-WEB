<?php

namespace App\Http\Controllers\Helpers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Members;
use App\Models\Projects;
use App\Models\MemberRoles;
use Illuminate\Support\Facades\DB;
use App\Events\MemberProjectNotificationEvent;

trait MembersProjectsHelper
{
    protected $getUser = null;
    /**
     * Return avalible roles
     */
    public function roles()
    {
        return Roles::select('id', 'name')->where('builtin', 0)->orderBy('name', 'ASC')->get();
    }

    /**
     * Retorna uma lista de usuarios
     */
    public function getUsers()
    {
        $users = User::where('status', true)->where('type', 'User')->get();
        return $users;
    }

    public function searchUsers($getUser)
    {
        $this->username = $getUser;
        return User::where('status', true)->where('type', 'User')
            ->where(function ($q) {
                $q->where('firstname', 'like', '%' . $this->username . '%')
                    ->orWhere('lastname', 'like', '%' . $this->username . '%');
            })->get();
    }

    /**
     * Retorna os members do project
     *
     */
    public function project_members($project_id)
    {
        try {
            $project = Projects::where('id', $project_id)->firstOrFail();
            $project_members = $project->members()->get() ?? array();
        } catch (\Throwable $th) {
            // throw $th;
            session()->flash("error", "Encontramos um erro ao tentar carregar os membros do PE ou Projecto!");
        }
        return $project_members ?? array();
    }

    /**
     * Adicionar Membros ao Projecto
     */
    public function add_project_members(array $selected_members, $project_id, $role)
    {
        $status = false;
        foreach ($selected_members as $key => $member_id) {
            try {
                $check_member = Members::where('project_id', $project_id)->where('user_id', $member_id)->first();

                if (!$check_member) {
                    DB::beginTransaction();
                    $new_project_memmber = new Members();
                    $new_project_memmber->user_id = $member_id;
                    $new_project_memmber->project_id = $project_id;
                    $new_project_memmber->created_on = now();
                    $new_project_memmber->save(); // Save data into database

                    $member_role = new MemberRoles();
                    $member_role->member_id = $new_project_memmber->id;
                    $member_role->role_id = $role;
                    $member_role->save(); // Save data into database

                    // Email para o author da tarefa
                    $project = Projects::where('id', $project_id)->first();
                    $member = User::where('id', $member_id)->first();
                    $user_role = Roles::where('id', $role)->first();

                    $email_subject = time() . ": Alocação de membro ao Projecto";
                    $email_content = "Foi alocado ao projecto <a href='" . route('projects.overview', ['project_identifier' => $project->identifier]) . "'>" . $project->name . "</a> com a função <b>" . $user_role->name . "</b>.";

                    event(new MemberProjectNotificationEvent($email_subject, $email_content, $member));

                    DB::commit();

                    return;
                }

                if (!(bool) $check_member->member_roles()->where('role_id', $role)->first()) {
                    //Add new role to user member $this project
                    DB::beginTransaction();

                    $member_role = new MemberRoles();
                    $member_role->member_id = $check_member->id;
                    $member_role->role_id = $role;
                    $member_role->save(); // Save data into database

                    // Email para o author da tarefa
                    $project = Projects::where('id', $project_id)->first();
                    $member = User::where('id', $member_id)->first();
                    $user_role = Roles::where('id', $role)->first();

                    $email_subject = time() . ": Alocação de membro ao Projecto";
                    $email_content = "Foi alocado ao projecto <a href='" . route('projects.overview', ['project_identifier' => $project->identifier]) . "'>" . $project->name . "</a> com a função <b>" . $user_role->name . "</b>.";

                    event(new MemberProjectNotificationEvent($email_subject, $email_content, $member));

                    DB::commit();

                    return;
                }
            } catch (\Throwable $th) {
                DB::rollback();
                return session()->flash('error', __('Ocorreu um erro! por favor contacte o Administrador'));
            }
            $status = true;
        }
        return array([
            "status" => $status,
            "members" => $this->project_members($project_id)
        ]);
    }
    /**
     * Remove member project
     */
    public function remove_project_members($id, $user_id, $project_id)
    {
        try {
            DB::beginTransaction();
            $getMember = Members::where('id', $id)->where('user_id', $user_id)->where('project_id', $project_id)->first();
            $member_id = $getMember->id;
            $getMember->delete();
            $memeber_role = MemberRoles::where('member_id', $member_id)->delete();

            // Email para o author da tarefa
            $project = Projects::where('id', $project_id)->first();
            $member = User::where('id', $user_id)->first();

            $email_subject = time() . ": Notificação de membro do Projecto";
            $email_content = "Você foi removido como membro do projeto <a href='" . route('projects.overview', ['project_identifier' => $project->identifier]) . "'>" . $project->name . ".";

            event(new MemberProjectNotificationEvent($email_subject, $email_content, $member));

            DB::commit();

            session()->flash('success', __('Membro excluído com sucesso.'));
            return $this->project_members($project_id);
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return session()->flash('error', __('lang.notice_failed_update'));
        }
    }
}
