<?php

namespace App\Policies;

use App\Models\IssueStatuses;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssueStatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any issue statuses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the issue statuses.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return mixed
     */
    public function view(User $user, IssueStatuses $issueStatuses)
    {
        //
    }

    /**
     * Determine whether the user can create issue statuses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the issue statuses.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return mixed
     */
    public function update(User $user, IssueStatuses $issueStatuses)
    {
        //
    }

    /**
     * Determine whether the user can delete the issue statuses.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return mixed
     */
    public function delete(User $user, IssueStatuses $issueStatuses)
    {
        //
    }

    /**
     * Determine whether the user can restore the issue statuses.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return mixed
     */
    public function restore(User $user, IssueStatuses $issueStatuses)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the issue statuses.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return mixed
     */
    public function forceDelete(User $user, IssueStatuses $issueStatuses)
    {
        //
    }
}
