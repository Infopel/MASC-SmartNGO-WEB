<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
use App\Models\Issues;
use App\Models\Projects;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssuesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user has permission to approve requests
     */
    public function can_approve_flow(User $user, Issues $issue, Roles $role)
    {
        try {
            $member = $issue->project->members()->where('user_id', $user->id)->firstOrFail();
            $member->member_roles()->where('role_id', $role->id)->firstOrFail();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine if user can request approval on task
     */
    public function can_request_approval(User $user, Issues $issue)
    {
        if ($user->id === $issue->author_id) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create issues.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determinar se o Usuario pode ver Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_issues(User $user, Projects $project)
    {
        return true;
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');

        // dd($roles_permissions);
        if ($roles_permissions !== null) {
            if (in_array('view_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function add_issues(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('add_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function log_time(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('log_time', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function approve_issues(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('approve_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function approve_my_issues(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('approve_my_issues', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function approve_issues_prog(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('approve_issues_prog', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode aprovar orcamento de tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function approve_issues_budget(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('approve_issues_budget', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Editar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function edit_issues(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Copiar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function copy_issues(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('copy_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Copiar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function manage_issue_relations(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_issue_relations', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Gerir Sub-Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function manage_subtasks(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_subtasks', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Alterar privacidade de Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function set_issues_private(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('set_issues_private', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode ??? de Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function set_own_issues_private(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('set_own_issues_private', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Adicionar Notas a Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function add_issue_notes(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('add_issue_notes', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Editar Nodas das Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function edit_issue_notes(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_issue_notes', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Ver notas privadas das Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_private_notes(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_private_notes', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Editar privacidade de Notas nas Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function set_notes_private(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('set_notes_private', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Remover Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function delete_issues(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('delete_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Visualizar Watchers da Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function view_issue_watchers(User $user, Projects $project)
    {
        if ($user->id == $project->author_id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('view_issue_watchers', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode adicionar watchers nas Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function add_issue_watchers(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('add_issue_watchers', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode remover watchers na Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function delete_issue_watchers(User $user, Projects $project)
    {
        if ($project->author_id == $user->id) return true;

        $is_member = $user->member_roles()->where('project_id', $project->id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('delete_issue_watchers', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Importar Tarefas
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function import_issues(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('import_issues', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * Determinar se o Usuario pode Gerir Categorias da Tarefa
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @return mixed
     */
    public function manage_categories(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('manage_categories', $roles_permissions)) {
                return true;
            }
            return $user->admin;
        }
        return $user->admin;
    }

    /**
     * aprovar_despesas
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function edit_orcamento(User $user, $project_id, Issues $issue = null)
    {
        return $issue['author_id'] == $user->id;
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('edit_orcamento', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }
    /**
     * aprovar_despesas
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function aprovar_despesas(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('aprovar_despesas', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }
    /**
     * aprovar_despesas
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function aprovar_realizado_tarefas(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('aprovar_realizado_tarefas', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Aprovar o reporte do realizado financeiro
     *
     * @return mixed
     */
    public function aprovar_realizado_financeiro(User $user, Issues $issue, $role_id)
    {
        try {
            $member = $issue->project->members()->where('user_id', $user->id)->firstOrFail();
            $member->member_roles()->where('role_id', $role_id)->firstOrFail();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Aprovar o reporte do realizado Programatico
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Issues  $issues
     * @param mixed role_id
     * @return mixed
     */
    public function aprovar_realizado_programatico(User $user, Issues $issue, $role_id)
    {
        try {
            $member = $issue->project->members()->where('user_id', $user->id)->firstOrFail();
            $member->member_roles()->where('role_id', $role_id)->firstOrFail();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * aprovar_despesas
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function aprovar_plano(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('aprovar_plano', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function conferir_plano(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('conferir_plano', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function auth_pagamento(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('auth_pagamento', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function processar_pagamento(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('processar_pagamento', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function validar_pagamento(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('validar_pagamento', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function aprovar_pagamento(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('aprovar_pagamento', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function desembolsar_fundos(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('desembolsar_fundos', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Solicitacao de Orçamento
     * Pode aprovar_plano
     */
    public function receber_fundos(User $user, $project_id)
    {
        $is_member = $user->member_roles()->where('project_id', $project_id)->first();
        $roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
        if ($roles_permissions !== null) {
            if (in_array('receber_fundos', $roles_permissions)) {
                return true;
            }
            return false;
        }
        return false;
    }
}
