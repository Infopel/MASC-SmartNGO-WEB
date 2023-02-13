<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AprovacaoTarefas extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'aprovacao_tarefas';

    protected $fillable = ['id', 'description', 'nivel', 'author_id', 'issue_id', 'customized_id', 'customized_type', 'assignedTo', 'is_approved', 'approved_by', 'approved_on', 'is_rejected', 'rejected_by', 'reject_notes', 'created_on', 'updated_on'];


    public function issue()
    {
        return $this->belongsTo('App\Models\Issues', 'issue_id', 'id')->whereHas('project');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function aprovado_por()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function rejeitado_por()
    {
        return $this->belongsTo('App\Models\User', 'rejected_by', 'id');
    }

    public function orcamento()
    {
        return $this->belongsTo('App\Models\BudgetsValues', 'customized_id', 'id');
    }

    public function indicador()
    {
        return $this->belongsTo('App\Models\IndicatorFieldsIssues', 'customized_id', 'indicator_fields_id')->with('indicator_field');
    }
}
