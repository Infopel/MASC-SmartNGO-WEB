<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Roles;
use App\Models\Projects;
use App\Models\FlowSolicitacaoFundos;
use Illuminate\Auth\Access\HandlesAuthorization;

class FlowSolicitacaoFundosPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if user has permission to approve requests
     */
    public function can_approve_flow(User $user, FlowSolicitacaoFundos $flowSolicitacaoFundos, Projects $project, Roles $role)
    {
        // return true;
        try {
            $member = $project->members()->where('user_id', $user->id)->firstOrFail();
            $member->member_roles()->where('role_id', $role->id)->firstOrFail();
            if ($flowSolicitacaoFundos->user_id_to === $user->id) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Determine whether the user can view any flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Projects\User  $project
     * @return mixed
     */
    public function projectMember(User $user, Projects $project)
    {
        try {
            $member = $project->members()->where('user_id', $user->id)->firstOrFail();
            return true;
        } catch (\Throwable $th) {
            return $user->high_privilege ?? false;
        }
    }

    /**
     * Determine whether the user can view the flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\FlowSolicitacaoFundos  $flowSolicitacaoFundos
     * @return mixed
     */
    public function view(User $user, FlowSolicitacaoFundos $flowSolicitacaoFundos)
    {
    }

    /**
     * Determine whether the user can create flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\FlowSolicitacaoFundos  $flowSolicitacaoFundos
     * @return mixed
     */
    public function update(User $user, FlowSolicitacaoFundos $flowSolicitacaoFundos)
    {
        //
    }

    /**
     * Determine whether the user can delete the flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\FlowSolicitacaoFundos  $flowSolicitacaoFundos
     * @return mixed
     */
    public function delete(User $user, FlowSolicitacaoFundos $flowSolicitacaoFundos)
    {
        //
    }

    /**
     * Determine whether the user can restore the flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\FlowSolicitacaoFundos  $flowSolicitacaoFundos
     * @return mixed
     */
    public function restore(User $user, FlowSolicitacaoFundos $flowSolicitacaoFundos)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the flow solicitacao fundos.
     *
     * @param  \App\Models\User  $user
     * @param  \App\FlowSolicitacaoFundos  $flowSolicitacaoFundos
     * @return mixed
     */
    public function forceDelete(User $user, FlowSolicitacaoFundos $flowSolicitacaoFundos)
    {
        //
    }
}
