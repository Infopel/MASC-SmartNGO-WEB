<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RubricasFlowSolicitacaoFundos extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * Table name
     */
    protected $table = 'rubricas_flow_solicitacao_fundos';


    protected $fillable = ["id", "num_requisicao", "rubrica_id", "project_id", "created_on", "deleted_at"];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'deleted_at'];


    public function rubrica()
    {
        return $this->belongsTo('App\Models\RubricasOrcamento', 'rubrica_id', 'id');
    }
}
