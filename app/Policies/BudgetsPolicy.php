<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Budgets;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class BudgetsPolicy
{
    /**
     * Config do modulo de orcamento
     */
    public function config_orcamento_projectos(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('config_orcamento_projectos', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function gerir_valor_base(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_valor_base', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function cadastrar_tipos_despesa(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_tipos_despesa', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function excluir_tipos_despesa(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_tipos_despesa', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function atualizar_tipos_despesa(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('atualizar_tipos_despesa', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function cadastrar_valores_base(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_valores_base', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function atualizar_valores_base(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('atualizar_valores_base', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode gerir valores base
     * Permissao Gerir Valor Base
     */
    public function cadastrar_rubricas_projecto(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_rubricas_projecto', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode Editar Orcameto de rubricas de projectos
     * Permissao Gerir Valor Base
     */
    public function atualizar_rubricas_projecto(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];

        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('atualizar_rubricas_projecto', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode Excluir Orcameto de rubricas de projectos
     * Permissao Gerir Valor Base
     */
    public function excluir_rubricas_projecto(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_rubricas_projecto', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    /**
     * Definir se o user pode Excluir Orcameto de rubricas de projectos
     * Permissao Gerir Valor Base
     */
    public function atualizar_permissoes(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('atualizar_permissoes', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }
}
