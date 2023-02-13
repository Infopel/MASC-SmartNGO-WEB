<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AprovacaoFundos extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'aprovacao_fundos';

    protected $fillable = ['id', 'issue_id', 'nivel', 'author_id', 'categoria', 'data', 'last_validation_date', 'last_validation_by', 'is_aproved', 'created_on', 'updated_on', 'is_rejected', 'rejected_by'];

    public function issue()
    {
        return $this->belongsTo('App\Models\Issues', 'issue_id', 'id')->whereHas('project');
    }

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function validation_by()
    {
        return $this->belongsTo('App\Models\User', 'last_validation_by', 'id');
    }

    public function repproves()
    {
        return $this->hasMany('App\Models\ReprovacaoSolicitacaoFundos', 'aprovacao_id', 'id');
    }
}
