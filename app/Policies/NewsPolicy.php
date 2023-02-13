<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any news.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the news.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $news
     * @return mixed
     */
    public function view(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can create news.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the news.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $news
     * @return mixed
     */
    public function update(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can delete the news.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $news
     * @return mixed
     */
    public function delete(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can restore the news.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $news
     * @return mixed
     */
    public function restore(User $user, News $news)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the news.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\News  $news
     * @return mixed
     */
    public function forceDelete(User $user, News $news)
    {
        //
    }


    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_news(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_news', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function manage_news(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_news', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function comment_news(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('comment_news', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }
}

