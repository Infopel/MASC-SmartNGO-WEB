<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Gantt;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class GanttPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any gantts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the gantt.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gantt  $gantt
     * @return mixed
     */
    public function view(User $user, Gantt $gantt)
    {
        //
    }

    /**
     * Determine whether the user can create gantts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the gantt.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gantt  $gantt
     * @return mixed
     */
    public function update(User $user, Gantt $gantt)
    {
        //
    }

    /**
     * Determine whether the user can delete the gantt.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gantt  $gantt
     * @return mixed
     */
    public function delete(User $user, Gantt $gantt)
    {
        //
    }

    /**
     * Determine whether the user can restore the gantt.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gantt  $gantt
     * @return mixed
     */
    public function restore(User $user, Gantt $gantt)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the gantt.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Gantt  $gantt
     * @return mixed
     */
    public function forceDelete(User $user, Gantt $gantt)
    {
        //
    }

    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_gantt(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_gantt', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }
}
