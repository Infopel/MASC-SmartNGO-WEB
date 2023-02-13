<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetsProjects extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'budgets_projects';

    protected $fillable = ['id', 'budget_tracker_id', 'project_id', 'value', 'year', 'provincia', 'updated_by', 'updated_notes', 'created_on', 'updated_on'];

    public function budget_tracker()
    {
        return $this->hasOne('App\Models\BudgetTrackers', 'id', 'budget_tracker_id')->orderby('name', 'asc');
    }

    public function atualizado_por()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
