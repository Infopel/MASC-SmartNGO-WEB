<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubricasOrcamentoDespesas extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'rubricas_orcamento_despesas';

    protected $fillable = ['id', 'rubrica_id', 'budget_tracker_id', 'project_id', 'provincia', 'created_on'];

    public function budget_tracker()
    {
        return $this->belongsTo('App\Models\BudgetTrackers', 'budget_tracker_id', 'id');
    }
}
