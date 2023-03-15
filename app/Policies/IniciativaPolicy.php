<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
use App\Models\Iniciativa;
// use App\Models\Projects;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class IniciativaPolicy
{
    use HandlesAuthorization;

    /**
     * Determinar se o Usuario pode Editar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\iniciativa  $iniciativa
     * @return mixed
     */
    public function edit_iniciativa(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            // if (in_array('edit_iniciativa', $roles_permissions)) {
            //     return true;
            // }
            return $user->admin;
        }
        return $user->admin;
    }


    /**
     * Determinar se o Usuario pode Remover Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return mixed
     */
    public function delete_iniciativa(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            // if (in_array('delete_iniciativa', $roles_permissions)) {
            //     return true;
            // }
            return $user->admin;
        }
        return $user->admin;
    }
}