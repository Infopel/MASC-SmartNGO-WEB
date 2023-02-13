<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Projects;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectsPolicy
{
    use HandlesAuthorization;

    // User Permissions
    protected $roles_permissions;


    /**
     * Determine whether the user can view any projects.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the projects.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function view(User $user, Projects $projects)
    {
        //
    }

    // Planos Estrategicos
    public function cadastrar_plano_estrategico(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_plano_estrategico', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }
    // Planos Estrategicos
    public function editar_plano_estrategico(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('editar_plano_estrategico', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }
    // Planos Estrategicos
    public function excluir_plano_estrategico(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_plano_estrategico', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }
    // Planos Estrategicos
    public function arquivar_plano_estrategico(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('arquivar_plano_estrategico', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
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
            return $user->admin;
        }
        return $user->admin;
    }

    public function cadastrar_projectos(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('cadastrar_projectos', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    public function excluir_projectos(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_projectos', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    // Planos Estrategicos
    public function arquivar_projecto(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('arquivar_projeto', $roles_permissions)) {
                    return true;
                }
            }
        }

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('close_project', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }

        return $user->admin;
    }

    /**
     * Linhas Estrategicas
     */
    public function criar_linhas_estrategicas(User $user)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('criar_linhas_estrategicas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }
    /**
     * Linhas Estrategicas
     */
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
            return $user->admin;
        }
        return $user->admin;
    }
    /**
     * Linhas Estrategicas
     */
    public function editar_linhas_estrategicas(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('editar_linhas_estrategicas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }
    /**
     * Linhas Estrategicas
     */
    public function excluir_linhas_estrategicas(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_linhas_estrategicas', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can update the projects.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function editar_projectos(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = auth()->user()->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_project', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can delete the projects.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function delete(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('excluir_projectos', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the projects.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function restore(User $user, Projects $projects)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_pe', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determine whether the user can permanently delete the projects.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function forceDelete(User $user, Projects $projects)
    {
        $permissions = auth()->user()->roles->pluck('permissions')->flatten(1) ?? [];
        foreach ($permissions as $permission) {
            $roles_permissions = Yaml::parse($permission ?? '');
            if ($roles_permissions !== null) {
                if (in_array('gerir_pe', $roles_permissions)) {
                    return true;
                }
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode adicionar Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function add_project(User $user, Projects $project)
    {
        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('add_project', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Editar Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function edit_project(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_project', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Fechar Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function close_project(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('close_project', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode selecionar modulos do Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function select_project_modules(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('select_project_modules', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Gerir membros do Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function manage_members(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_members', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Gerir versoes do Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function manage_versions(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_versions', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Sub-Projetos no Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function add_subprojects(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = auth()->user()->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('add_subprojects', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Gerir pesquisas publicas do Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function manage_public_queries(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = auth()->user()->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_public_queries', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Gerir pesquisas publicas do Projecto
     * @param  \App\Models\User  $user
     * @param  \App\Models\Projects  $projects
     * @return mixed
     */
    public function save_queries(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = auth()->user()->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('save_queries', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }


    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_issues(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }


    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_calendar(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_calendar', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_time_entries(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_time_entries', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }
}
