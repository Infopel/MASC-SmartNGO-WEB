<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Trackers;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrackersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any trackers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the trackers.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trackers  $trackers
     * @return mixed
     */
    public function view(User $user, Trackers $trackers)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_tipos_tarefas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can create trackers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_tipos_tarefas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can update the trackers.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trackers  $trackers
     * @return mixed
     */
    public function update(User $user, Trackers $trackers)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_tipos_tarefas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the trackers.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trackers  $trackers
     * @return mixed
     */
    public function delete(User $user, Trackers $trackers)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_tipos_tarefas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    public function gerir_tipos_tarefas(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_tipos_tarefas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

}
