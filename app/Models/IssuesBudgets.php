<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssuesBudgets extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'issues_budgets';

    protected $fillable = ['id', 'issue_id', 'project_id', 'author_id', 'is_aproved', 'notes', 'aproved_on', 'aproved_by', 'is_full_aproved', 'partner_id', 'created_on', 'updated_on', 'updated_by'];

    protected $casts = ['created_on', 'updated_on'];


    public function budget_values()
    {
        return $this->hasMany('App\Models\BudgetsValues', 'issues_budget_id', 'id');
    }

    /**
     * Author
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }
    /**
     * Aprovado por
     */
    public function aprovado_por()
    {
        return $this->belongsTo('App\Models\User', 'aproved_by', 'id');
    }

    /**
     * Details
     */
    public function budget_details()
    {
        return $this->hasMany('App\Models\BudgetsDetails', 'budget_id', 'id');
    }
    /**
     * Aprovado por
     */
    public function atualizado_por()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Partners', 'partner_id', 'id');
    }
}
