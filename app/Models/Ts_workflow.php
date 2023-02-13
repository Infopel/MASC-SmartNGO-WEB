<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ts_workflow extends Model
{
    public $timestamps = false;

    /**
     * Databse Table
     */
    protected $table = 'ts_submissions';

    /**
     * Database Columns
     */
    protected $fillable = ['id', 'tag_code', 'flow_id', 'ts_activity_id','project_id' ,'role_id', 'comments' ,'request_by', 'assigned_to', 'is_approved', 'approved_on', 'approved_by', 'is_rejected', 'rejected_on', 'rejected_by', 'created_on', 'updated_on', 'deleted_at','is_end','next_flow'];

    /**
     * Casts
     */
    protected $casts = ['created_on', 'updated_on'];

    /**
     * Fluxo de aprovação
     */
    public function approvement_flow()
    {
        return $this->belongsTo('App\Models\ApprovementFlow', 'flow_id', 'id');
    }

    /**
     * Descricao do Fluxo de Aprovacao
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id', 'id');
    }


    /**
     * Return Role for the approvement request
     */
    public function requestBy()
    {
        return $this->belongsTo('App\Models\User', 'request_by', 'id');
    }

    /**
     * Requisioes de aprovação do usuario
     */
    public function user_approvals()
    {
        return $this->hasMany('App\Models\UsersApprovementFlow', 'approvement_flow_models_id', 'id');
    }




    /**
     * Assigned to {user}
     */
    public function assignedTo()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function sentBackBy()
    {
        return $this->belongsTo('App\Models\User', 'sent_back_by', 'id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo('App\Models\User', 'rejected_by', 'id');
    }

    public function issue()
    {
        return $this->belongsTo('App\Models\Issues', 'customized_id', 'id')->with('project');
    }

    public function issue_disapprovals_flow()
    {
        return $this->hasMany('App\Models\ReprovacaoSolicitacaoFundos', 'aprovacao_id', 'id');
    }

     /**
     * Documentos de suporte da tarefa
     */
    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'FlowApprovalDoc');
    }


    public function progress($issue)
    {
        $approvement_flows = ApprovementFlow::get()->count();
        $approved_flows = ApprovementFlowModels::where('is_approved')
            ->where('customized_id', $issue)->get()->count();
        return round(($approved_flows / $approvement_flows) * 100);
    }
}
