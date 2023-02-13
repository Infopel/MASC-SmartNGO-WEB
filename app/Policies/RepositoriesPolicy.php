<?php

namespace App\Policies;

use App\Models\Repositories;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any repositories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the repositories.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Repositories  $repositories
     * @return mixed
     */
    public function view(User $user, Repositories $repositories)
    {
        //
    }

    /**
     * Determine whether the user can create repositories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the repositories.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Repositories  $repositories
     * @return mixed
     */
    public function update(User $user, Repositories $repositories)
    {
        //
    }

    /**
     * Determine whether the user can delete the repositories.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Repositories  $repositories
     * @return mixed
     */
    public function delete(User $user, Repositories $repositories)
    {
        //
    }

    /**
     * Determine whether the user can restore the repositories.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Repositories  $repositories
     * @return mixed
     */
    public function restore(User $user, Repositories $repositories)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the repositories.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Repositories  $repositories
     * @return mixed
     */
    public function forceDelete(User $user, Repositories $repositories)
    {
        //
    }
}
