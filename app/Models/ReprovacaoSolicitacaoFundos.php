<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReprovacaoSolicitacaoFundos extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'reprovacao_solicitacao_fundos';

    protected $fillable = ['id', 'nivel', 'issue_id', 'aprovacao_id', 'solicitacao_requestNum', 'request_from_id', 'notes', 'action_by', 'categoria', 'created_on'];


    public function aprovacao_fundo()
    {
        return $this->belongsTo('App\Models\AprovacaoFundos', 'aprovacao_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'action_by', 'id');
    }
}
