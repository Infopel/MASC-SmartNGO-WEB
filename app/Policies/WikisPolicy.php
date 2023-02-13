<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wikis;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class WikisPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any wikis.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the wikis.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wikis  $wikis
     * @return mixed
     */
    public function view(User $user, Wikis $wikis)
    {
        //
    }

    /**
     * Determine whether the user can create wikis.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the wikis.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wikis  $wikis
     * @return mixed
     */
    public function update(User $user, Wikis $wikis)
    {
        //
    }

    /**
     * Determine whether the user can delete the wikis.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wikis  $wikis
     * @return mixed
     */
    public function delete(User $user, Wikis $wikis)
    {
        //
    }

    /**
     * Determine whether the user can restore the wikis.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wikis  $wikis
     * @return mixed
     */
    public function restore(User $user, Wikis $wikis)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the wikis.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wikis  $wikis
     * @return mixed
     */
    public function forceDelete(User $user, Wikis $wikis)
    {
        //
    }

    /**
     * Determinar se o Usuario pode ver paginas wikis
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_wiki_pages(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_wiki_pages', $roles_permissions)) {
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
    public function view_wiki_edits(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_wiki_edits', $roles_permissions)) {
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
    public function export_wiki_pages_shown(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('export_wiki_pages_shown', $roles_permissions)) {
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
    public function edit_wiki_pages(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_wiki_pages', $roles_permissions)) {
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
    public function rename_wiki_pages_shown(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('rename_wiki_pages_shown', $roles_permissions)) {
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
    public function delete_wiki_pages_shown(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('delete_wiki_pages_shown', $roles_permissions)) {
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
    public function delete_wiki_pages_attachments_shown(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('delete_wiki_pages_attachments_shown', $roles_permissions)) {
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
    public function protect_wiki_pages_shown(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('protect_wiki_pages_shown', $roles_permissions)) {
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
    public function manage_wiki_shown(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_wiki_shown', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

}
