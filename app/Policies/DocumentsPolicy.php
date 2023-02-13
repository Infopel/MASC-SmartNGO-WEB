<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Projects;
use App\Models\Documents;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any documents.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the documents.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents  $documents
     * @return mixed
     */
    public function view(User $user, Documents $documents)
    {
        //
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the documents.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents  $documents
     * @return mixed
     */
    public function update(User $user, Documents $documents)
    {
        //
    }

    /**
     * Determine whether the user can delete the documents.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents  $documents
     * @return mixed
     */
    public function delete(User $user, Documents $documents)
    {
        //
    }

    /**
     * Determine whether the user can restore the documents.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents  $documents
     * @return mixed
     */
    public function restore(User $user, Documents $documents)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the documents.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents  $documents
     * @return mixed
     */
    public function forceDelete(User $user, Documents $documents)
    {
        //
    }

    /**
     * Determinar se o Usuario pode ver paginas wikis
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_documents(User $user, Projects $project)
    {
        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_documents', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ver paginas wikis
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function add_documents_shown(User $user, Projects $project)
    {
        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('add_documents_shown', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ver paginas wikis
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function edit_documents_shown(User $user, Projects $project)
    {
        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_documents_shown', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ver paginas wikis
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function delete_documents_shown(User $user, Projects $project)
    {
        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('delete_documents_shown', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }
}
