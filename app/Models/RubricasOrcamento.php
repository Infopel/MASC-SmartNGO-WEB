<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RubricasOrcamento extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * Table name
     */
    protected $table = 'rubricas_orcamento';

    protected $fillable = ['id', 'rubrica', 'name', 'project_id', 'orcamento', 'year', 'parent_rubrica_id', 'parent_rubrica', 'author_id', 'updated_by', 'created_on', 'updated_on', 'deleted_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['updated_on', 'created_on'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_on' => 'updated_on',
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    public function atualizado_por()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function parent()
    {
        return $this->hasOne($this, 'id', 'parent_rubrica_id');
    }

    /**
     * Retornar o valor gasto por projecto
     */
    public function valor_gasto_tarefas($mes = null, $year = null, $issue_id = null)
    {
        $year = $year ?? date('Y');
        if ($issue_id !== null) {
            return $this->hasMany('App\Models\BudgetsValues', 'budget_tracker_id', 'id')
                ->where('customized_id', $issue_id)
                ->where(function ($q) use ($mes) {
                    if ($mes != null) {
                        $q->whereMonth('issued_at', $mes);
                    }
                })
                ->whereHas('issue', function ($q) {
                    // $q->where('is_aproved', true);
                })
                ->whereYear('issued_at', $year)
                ->sum('issued_value');
        }

        // issue is null and mes is null
        if ($issue_id === null && $mes === null) {
            return $this->hasMany('App\Models\BudgetsValues', 'budget_tracker_id', 'id')
                ->whereHas('issue', function ($q) {
                    // $q->where('is_aproved', true);
                })
                ->whereYear('issued_at', $year)
                ->sum('issued_value');
        }

        return $this->hasMany('App\Models\BudgetsValues', 'budget_tracker_id', 'id')
            ->where(function ($q) use ($mes) {
                if ($mes != null) {
                    $q->whereMonth('issued_at', $mes);
                }
            })
            ->whereHas('issue', function ($q) {
                // $q->where('is_aproved', true);
            })
            ->whereYear('issued_at', $year)
            ->sum('issued_value');
    }


    public function budgetsValues()
    {
        return $this->hasMany('App\Models\BudgetsValues', 'budget_tracker_id', 'id');
    }

    /**
     * Retornar o orcamento_inicial da rubrica
     */
    public function orcamento_inicial()
    {
        $jornal_value = $this->hasMany('App\Models\Journals', 'journalized_id', 'id')->where('journalized_type', 'Issue_Budget')->whereHas('journal_details')->first();
        if ($jornal_value) {
            return $jornal_value->journal_details()->first()->old_value;
        }
        return $this->orcamento;
    }

    // Add orcamento_inicial ao model
    protected $appends = [
        'orcamento_inicial',
        'orcamento_gasto',
        'test'
    ];

    public function getOrcamentoInicialAttribute()
    {
        return $this->orcamento_inicial();
    }

    public function getOrcamentoGastoAttribute()
    {
        return $this->valor_gasto_tarefas();
    }

    public function getTestAttribute()
    {
        return 0;
    }
}
