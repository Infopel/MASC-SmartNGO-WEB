<?php

namespace App\Policies;

use App\Models\User;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }



    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        if ($user->id === $model->id || $user->admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if ($user->id === $model->id || $user->admin) {
            return true;
        }
    }

    public function update_auth_pass(User $user, User $model)
    {
        if ($user->id === $model->id) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->admin;
    }

    /**
     * Determinar se o user pode alter nivel de conta
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update_auth(User $user, User $model)
    {
        return $user->admin;
    }

    // usuarios
    public function gerir_painel_admin(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_painel_admin', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    // usuarios
    public function ver_usuarios(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('ver_usuarios', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    // usuarios
    public function cadastrar_usuarios(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_usuarios', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    // usuarios
    public function alterar_senha_de_usuarios(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('alterar_senha_de_usuarios', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    // usuarios
    public function bloquear_desbloquar_usuarios(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('bloquear_desbloquar_usuarios', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    // usuarios
    public function remover_usuarios(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('remover_usuarios', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }



    public function gerir_linhas_estrategicas(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_linhas_estrategicas', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }


    public function gerir_projectos(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_projectos', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }


    public function arquivar_projeto(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('arquivar_projeto', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }


    public function arquivar_pe(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('arquivar_pe', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function excluir_pe(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_pe', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function excluir_projecto(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_projecto', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }


    public function definir_niveis_acesso(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('definir_niveis_acesso', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }


    public function gerir_grupos(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_grupos', $roles_permissions)) {
                    return true;
                }
            }
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
        }
        return $user->admin;
    }

    public function gerir_estados_tarefas(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_estados_tarefas', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function gerir_campos_personalizados(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_campos_personalizados', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function cadastrar_campos_personalizados(User $user)
    {
        // return true;
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_campos_personalizados', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function editar_campos_personalizados(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('editar_campos_personalizados', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function excluir_campos_personalizados(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_campos_personalizados', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }

    public function ver_tipos_categorias(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('ver_tipos_categorias', $roles_permissions)) {
                    return true;
                }
            }
        }
        return $user->admin;
    }


    public function definir_modelos_avaliacao(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('ver_tipos_categorias', $roles_permissions)) {
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
        return true;
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
