<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovementFlowModels extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    /**
     * Databse Table
     */
    protected $table = 'approvement_flow_models';

    /**
     * Database Columns
     */
    protected $fillable = ['id', 'tag_code', 'flow_id', 'customized_id', 'customized_type', 'role_id', 'comments' ,'request_by', 'assigned_to', 'is_approved', 'approved_on', 'approved_by', 'is_rejected', 'rejected_on', 'rejected_by', 'created_on', 'updated_on', 'deleted_at'];

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
     * Fluxo de aprovação
     */
    public function project()
    {
        return $this->hasOne('App\Models\Projects', 'id', 'customized_id')
            ->with('issues_workflow');
    }

    /**
     * Return Role for the approvement request
     */
    public function role()
    {
        return $this->belongsTo('App\Models\Roles', 'role_id', 'id');
    }

    /**
     * Requisioes de aprovação do usuario
     */
    public function user_approvals()
    {
        return $this->hasMany('App\Models\UsersApprovementFlow', 'approvement_flow_models_id', 'id');
    }

    /**
     * User
     */
    public function requestBy()
    {
        return $this->belongsTo('App\Models\User', 'request_by', 'id');
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

    public function progress($issue)
    {
        $approvement_flows = ApprovementFlow::get()->count();
        $approved_flows = ApprovementFlowModels::where('is_approved')
            ->where('customized_id', $issue)->get()->count();
        return round(($approved_flows / $approvement_flows) * 100);
    }
}
