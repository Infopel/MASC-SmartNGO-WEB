<?php

namespace App\Policies;

use App\Models\TimeEntries;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimeEntriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any time entries.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the time entries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TimeEntries  $timeEntries
     * @return mixed
     */
    public function view(User $user, TimeEntries $timeEntries)
    {
        //
    }

    /**
     * Determine whether the user can create time entries.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the time entries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TimeEntries  $timeEntries
     * @return mixed
     */
    public function update(User $user, TimeEntries $timeEntries)
    {
        //
    }

    /**
     * Determine whether the user can delete the time entries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TimeEntries  $timeEntries
     * @return mixed
     */
    public function delete(User $user, TimeEntries $timeEntries)
    {
        //
    }

    /**
     * Determine whether the user can restore the time entries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TimeEntries  $timeEntries
     * @return mixed
     */
    public function restore(User $user, TimeEntries $timeEntries)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the time entries.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TimeEntries  $timeEntries
     * @return mixed
     */
    public function forceDelete(User $user, TimeEntries $timeEntries)
    {
        //
    }
}
