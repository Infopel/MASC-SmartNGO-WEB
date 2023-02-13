<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagamentosFlowSolicitacaoFundos extends Model
{
    use SoftDeletes;


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
    protected $table = 'pagamentos_flow_solicitacao_fundo';



    protected $fillable = ['id', 'doardor_id', 'doador_name', 'flow_solicitacao_id', 'solicitacao_id', 'valor', 'paymentType', 'nome_banco', 'num_banco', 'nib_banco', 'check_trans_number', 'data', 'author_id', 'created_on', 'deleted_at'];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'deleted_at'];
}
