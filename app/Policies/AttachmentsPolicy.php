<?php

namespace App\Policies;

use App\Models\Attachments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttachmentsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any attachments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the attachments.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attachments  $attachments
     * @return mixed
     */
    public function view(User $user, Attachments $attachments)
    {
        //
    }

    /**
     * Determine whether the user can create attachments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the attachments.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attachments  $attachments
     * @return mixed
     */
    public function update(User $user, Attachments $attachments)
    {
        //
    }

    /**
     * Determine whether the user can delete the attachments.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attachments  $attachments
     * @return mixed
     */
    public function delete(User $user, Attachments $attachments)
    {
        //
    }

    /**
     * Determine whether the user can restore the attachments.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attachments  $attachments
     * @return mixed
     */
    public function restore(User $user, Attachments $attachments)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the attachments.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Attachments  $attachments
     * @return mixed
     */
    public function forceDelete(User $user, Attachments $attachments)
    {
        //
    }
}
