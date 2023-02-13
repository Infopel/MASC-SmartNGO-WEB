<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubricasSolicitacao extends Model
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
    protected $table = 'rubricas_solicitacao';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'solicitacao_id', 'rubrica_id', 'created_on', 'deleted_at', 'deleted_by'
    ];
}
