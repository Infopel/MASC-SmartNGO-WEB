<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RubricasFlowSolicitacaoFundos;

class SolicitacaoFundos extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solicitacao_fundos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type' ,'num_requisicao', 'has_rubricas', 'objectivo', 'valor_estimado', 'area_id', 'activiade_id', 'necessidade_id', 'pilar_id', 'project_id', 'data', 'local', 'num_dias', 'num_participantes', '_osc', 'issue_id', 'request_by', 'created_on', 'updated_on', 'deleted_at', 'is_rejected', 'rejected_by', 'rejected_on'
    ];

    /**
     * Solicitacao has rubricas
     */
    public function rubricas()
    {
        return $this->hasMany(RubricasFlowSolicitacaoFundos::class, 'num_requisicao', 'num_requisicao');
    }

    public function areas()
    {
        return $this->hasMany(OptionsSolicitacaoFundos::class, 'num_requisicao', 'num_requisicao')
            ->where('enumeration_type', 'IssueArea')
            ->with('enumeration');
    }

    public function actividades()
    {
        return $this->hasMany(OptionsSolicitacaoFundos::class, 'num_requisicao', 'num_requisicao')
            ->where('enumeration_type', 'IssueActividade')
            ->with('enumeration');
    }

    public function necessidades()
    {
        return $this->hasMany(OptionsSolicitacaoFundos::class, 'num_requisicao', 'num_requisicao')
            ->where('enumeration_type', 'IssueNecessidade')
            ->with('enumeration');
    }

    public function documents()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'SolicitaçãoFundosAttachs');
    }

    public function requestBy()
    {
        return $this->belongsTo('App\Models\User', 'request_by', 'id');
    }

    public function pilar()
    {
        return $this->belongsTo('App\Models\Projects', 'pilar_id', 'id')->select('id', 'identifier', 'name');
    }

    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id')->select('id', 'identifier', 'name');
    }

    public function approvements()
    {
        return $this->hasMany(FlowSolicitacaoFundos::class, 'solicitacao_id', 'id')->with('approvedBy');
    }

    public function latestAprovement()
    {
        return $this->hasOne(FlowSolicitacaoFundos::class, 'solicitacao_id', 'id')->with('approvedBy', 'user')->latest('created_on');
    }

    public function processoPagamento()
    {
        return $this->hasOne(PagamentosFlowSolicitacaoFundos::class, 'solicitacao_id', 'id');
    }

    public function issue()
    {
        return $this->hasOne(Issues::class, 'id', 'issue_id');
    }
}
