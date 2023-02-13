<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enumerations;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnumerationsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any enumerations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the enumerations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enumerations  $enumerations
     * @return mixed
     */
    public function view(User $user, Enumerations $enumerations)
    {
        //
    }

    /**
     * Determine whether the user can create enumerations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function criar_tipos_categorias(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('criar_tipos_categorias', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can update the enumerations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enumerations  $enumerations
     * @return mixed
     */
    public function editar_tipos_categorias(User $user, Enumerations $enumerations)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('editar_tipos_categorias', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the enumerations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enumerations  $enumerations
     * @return mixed
     */
    public function excluir_tipos_categorias(User $user, Enumerations $enumerations)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_tipos_categorias', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }
}
