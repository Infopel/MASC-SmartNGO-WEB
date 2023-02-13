<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function ver_permisoes(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('ver_permisoes', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function criar_permissoes(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('criar_permissoes', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can update the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Roles  $role
     * @return mixed
     */
    public function atualizar_permissoes(User $user, Roles $role)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('atualizar_permissoes', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Roles  $role
     * @return mixed
     */
    public function excluir_permissoes(User $user, Roles $role)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_permissoes', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Roles  $role
     * @return mixed
     */
    public function restore(User $user, Roles $role)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the roles.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Roles  $role
     * @return mixed
     */
    public function forceDelete(User $user, Roles $role)
    {
        return $user->admin;
    }
}
