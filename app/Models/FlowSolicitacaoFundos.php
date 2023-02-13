<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlowSolicitacaoFundos extends Model
{

    use SoftDeletes;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'flow_solicitacao_fundos';

    protected $fillable = ['id', 'type' ,'num_requisicao', 'solicitacao_id', 'flow_id', 'flow_description', 'validator_category', 'user_id_to', 'is_approved', 'request_by', 'approved_by', 'approved_on', 'created_on', 'deleted_at', 'is_rejected', 'rejected_by', 'rejected_on'];


    protected $appends = [
        'route_validation',
        'route'
    ];

    public function getRouteAttribute()
    {
        try {
            return route('orcamento.projecto.details-solicitacao_fundos', [
                'project_identifier' => $this->solicitacao->project->identifier ?? 'project-none-exist',
                'requestNum' => $this->num_requisicao,
            ]);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function getRouteValidationAttribute()
    {
        try {
            return route('orcamento.projecto.solicitacao_fundos.validation', [
                'project_identifier' => $this->solicitacao->project->identifier ?? 'project-none-exist',
                'requestNum' => $this->num_requisicao,
                'approvementFlow' => $this->id
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return null;
        }
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $date = ["created_on"];

    public function solicitacao()
    {
        return $this->belongsTo('App\Models\SolicitacaoFundos', 'solicitacao_id', 'id')->with('project');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id_to', 'id');
    }

    public function flow()
    {
        return $this->belongsTo('App\Models\ApprovementFlow', 'flow_id', 'id');
    }

    public function requestBy()
    {
        return $this->belongsTo('App\Models\User', 'request_by', 'id');
    }

    public function rejectedBy()
    {
        return $this->belongsTo('App\Models\User', 'rejected_by', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function unapprovals_flow()
    {
        return $this->hasMany(ReprovacaoSolicitacaoFundos::class, 'aprovacao_id', 'id')->where('solicitacao_requestNum', $this->num_requisicao);
    }
}
