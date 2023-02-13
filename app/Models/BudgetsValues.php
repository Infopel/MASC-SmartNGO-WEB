<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetsValues extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'budgets_values';

    protected $fillable = ['id', 'issues_budget_id', 'author_id', 'budget_tracker_id', 'project_id', 'customized_type', 'customized_id', 'quantidade', 'valor_base', 'issued_value', 'variavel', 'aproved_by', 'issued_at', 'aproved_on', 'partner_id', 'created_on', 'updated_on', 'is_aproved', 'quant_realizada', 'valor_realizado', 'is_reported', 'reported_at', 'reported_by', 'report_is_approved', 'report_approved_by', 'report_approved_on'];


    public function issue_budget()
    {
        return $this->belongsTo('App\Models\IssuesBudgets', 'issues_budget_id', 'id');
    }

    /**
     * Tipo de despesa
     */
    public function budget_tracker()
    {
        return $this->belongsTo('App\Models\BudgetTrackers', 'budget_tracker_id', 'id');
    }

    /**
     * Tipo de despesa
     */
    public function rubrica()
    {
        return $this->belongsTo('App\Models\RubricasOrcamento', 'budget_tracker_id', 'id');
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
     * Aprovado por
     */
    public function reportado_por()
    {
        return $this->belongsTo('App\Models\User', 'reported_by', 'id');
    }

    public function issue()
    {
        return $this->belongsTo('App\Models\Issues', 'customized_id', 'id');
    }
}
