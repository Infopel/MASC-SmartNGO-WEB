<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionsSolicitacaoFundos extends Model
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
    protected $table = 'options_solicitacao_fundos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'num_requisicao', 'enumeration_id', 'enumeration_type', 'created_on', 'deleted_on'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'deleted_on'];


    public function enumeration()
    {
        return $this->belongsTo('App\Models\Enumerations', 'enumeration_id', 'id');
    }
}
