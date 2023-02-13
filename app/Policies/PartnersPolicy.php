<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Partners;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartnersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any partners.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the partners.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partners  $partners
     * @return mixed
     */
    public function view(User $user, Partners $partners)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can create partners.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */

    public function cadastrar_parceiros(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_parceiros', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Excluir Parceiros
     */
    public function remover_parceiros(User $user, Partners $partner)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('remover_parceiros', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    public function definir_modelos_avaliacao(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('definir_modelos_avaliacao', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    public function avaliar_parceiros(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('avaliar_parceiros', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }


    /**
     * Determine whether the user can update the partners.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partners  $partners
     * @return mixed
     */
    public function update(User $user, Partners $partners)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the partners.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partners  $partners
     * @return mixed
     */
    public function delete(User $user, Partners $partners)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the partners.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partners  $partners
     * @return mixed
     */
    public function restore(User $user, Partners $partners)
    {
        if ($user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can permanently delete the partners.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Partners  $partners
     * @return mixed
     */
    public function forceDelete(User $user, Partners $partners)
    {
        if ($user->admin) {
            return true;
        }
    }
}
