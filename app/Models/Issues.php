<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issues extends Model
{
    use SoftDeletes;
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'issues';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'tracker_id', 'project_id', 'subject', 'description', 'due_date', 'category_id', 'status_id', 'assigned_to_id', 'priority_id', 'fixed_version_id', 'author_id', 'lock_version', 'created_on', 'updated_on', 'start_date', 'done_ratio', 'estimated_hours', 'parent_id', 'root_id', 'lft', 'rgt', 'is_private', 'closed_on', 'deleted_at', 'is_aproved', 'aproved_by', 'aproved_on'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_on', 'updated_on'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "start_date" => 'd-m-Y',
        "due_date" => 'd-m-Y'
    ];

    protected $appends = [
        'route',
        'provincia',
        'add_budget',
        'edit_allowed',
        'orcamento_prev',
        'orcamento_gasto',
    ];

    public function getRouteAttribute()
    {
        return $this->url_route();
    }

    /**
     * Return issue state
     */
    public function getAddBudgetAttribute()
    {
        if ($this->status_id == 1 || $this->status_id == 2) {
            return true;
        }
        return false;
    }

    public function getEditAllowedAttribute()
    {
        if ($this->status_id == 4 || $this->status_id == 5) {
            return false;
        }
        return true;
    }

    /**
     * Get Project childs
     */
    public function childs()
    {
        return $this->hasMany($this, 'parent_id', 'id')->orderBy('rgt', 'asc');
    }

    /**
     * Issue Status (open/close/completed)
     */
    public function status()
    {
        return $this->belongsTo('App\Models\IssueStatuses', 'status_id', 'id');
    }

    /**
     * Issue priority (normal/urgent)
     */
    public function priority()
    {
        return $this->belongsTo('App\Models\Enumerations', 'priority_id', 'id');
    }

    /**
     * Issue is assignedTo ?? $user
     */
    public function assignedTo()
    {
        return $this->belongsTo('App\Models\User', 'assigned_to_id', 'id');
    }

    /**
     * User - Issue Author
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'author_id', 'id');
    }

    /**
     * project that this issue belongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\Projects', 'project_id', 'id');
    }

    /**
     * Tracker that belongsTo this Issue;
     */
    public function tracker()
    {
        return $this->belongsTo('App\Models\Trackers', 'tracker_id', 'id');
    }

    public function project_trackers()
    {
        return $this->hasMany(ProjectTrackers::class, 'project_id', 'project_id')->with('tracker');
    }

    /**
     * Belong to category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\User', 'category_id', 'id');
    }

    /**
     * Tracker that belongsTo this Issue;
     */
    public function custom_values($custom_field_id = null, $customized_type = 'Issue', $columns = 'value')
    {
        if ($custom_field_id == null) {
            return $this->hasMany('App\Models\CustomValues', 'customized_id', 'id')->where('customized_type', $customized_type);
        } else {
            // return $columns;
            return $this->belongsTo('App\Models\CustomValues', 'id', 'customized_id')
                ->select($columns)
                ->join('custom_fields', 'custom_fields.id', 'custom_field_id')
                ->where('custom_field_id', $custom_field_id)
                ->where('customized_type', $customized_type)
                ->get();
        }
    }

    /**
     * Custom fiels
     */
    public function custom_field_values()
    {
        return $this->hasMany('App\Models\CustomValues', 'customized_id', 'id')->where('customized_type', 'Issue')->with('custom_field');
    }

    /**
     * Provincia onde a tarefa decorre
     * Aqui vamos usar o ID do custom field - No code
     * Nao eh a melhor forma de fazer... estou ciente disso, por ser um campo customizado
     */
    public function provincia()
    {
        return $this->hasOne('App\Models\CustomValues', 'customized_id', 'id')->where('custom_field_id', 70)->where('value', '!=', null);
    }

    /**
     * Retorna a provincia onde o projecto esta decorrer
     */
    public function getProvinciaAttribute()
    {
        return $this->provincia()->first()->value ?? "Undefined";
    }

    /**
     * Issue Watchers
     */
    public function watchers()
    {
        return $this->hasMany('App\Models\Watchers', 'watchable_id', 'id')->where('watchable_type', 'Issue');
    }

    public function is_watcher()
    {
        return $this->hasOne('App\Models\Watchers', 'watchable_id', 'id')->where('watchable_type', 'Issue')->where('user_id', auth()->user()->id ?? null);
    }


    // ------------------------------------ Indicadores
    public function indicators()
    {
        return $this->hasMany('App\Models\IndicatorFieldsIssues', 'issue_id', 'id')->with('indicator_field');
    }

    public function orcamento_tarefas()
    {
        return $this->hasMany('App\Models\BudgetsValues', 'customized_id', 'id')->with('rubrica');
    }

    public function history()
    {
        return $this->hasMany('App\Models\Journals', 'journalized_id', 'id')->with('journal_details');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Issues', 'id', 'parent_id');
    }

    public function url_new_budget()
    {
        return route('issues.budget.new', ['issue' => $this->id]);
    }

    /**
     * Rota da Issue
     */
    public function url_route()
    {
        if ($this->id !== null) {
            return route('issues.show', ['issue' => $this->id]);
        }
        return null;
    }

    /**
     * Aprovado por
     */
    public function aprovado_por()
    {
        return $this->hasOne('App\Models\User', 'id', 'aproved_by');
    }


    public function issues_budgets()
    {
        return $this->hasOne(IssuesBudgets::class, 'issue_id', 'id')->with('budget_values');
    }


    public function aprovacao_fundos()
    {
        return $this->belongsTo(AprovacaoFundos::class, 'id', 'issue_id')->with('author')->whereHas('author');
    }

    public function fluxo_aprovacao_fundos()
    {
        return $this->hasMany(AprovacaoFundos::class, 'issue_id', 'id')->with('author')->whereHas('author');
    }

    /**
     * FLuxo de aprovação
     */
    public function issue_approvement_requests()
    {
        return $this->hasMany(ApprovementFlowModels::class, 'customized_id', 'id')
            ->where('customized_type', "Issue")
            ->with('requestBy')
            ->whereHas('requestBy');
    }
    /**
     * FLuxo de aprovação
     */
    public function approvement_workflow_requests()
    {
        return $this->hasMany(ApprovementFlowModels::class, 'customized_id', 'id')
            ->where('customized_type', 'like', "issue%")
            ->with('requestBy')
            ->whereHas('requestBy');
    }

    /**
     * User
     */
    public function workflowPFE()
    {
        return $this->belongsTo('App\Models\ApprovementFlowModels', 'id', 'customized_id')
            ->where("customized_type", '=', 'PFEIssueProjecct');
    }

    /**
     * User
     */
    public function workflowPFEIND()
    {
        return $this->hasOne('App\Models\ApprovementFlowModels', 'customized_id', 'id')->whereHas('requestBy')
            ->where("customized_type", 'like', '%PFEIssueProjecctIndicator%');
    }


    public function orcamento()
    {
        return $this->hasMany('App\Models\BudgetsValues', 'customized_id', 'id');
    }


    public function time_entries_budgets()
    {
        return $this->hasOne('App\Models\TimeEntries', 'issue_id', 'id')->whereHas('time_entries_values', function ($query) {
            $query->where('customized_type', 'IssueBudget');
        })->where('custom_type', 'TaskBudgetReport')->with('time_entries_values');
    }

    public function time_entries_report()
    {
        return $this->hasMany('App\Models\TimeEntries', 'issue_id', 'id')->where('custom_type', 'TaskReport');
    }


    public function report_indicadores_realizado()
    {
        return $this->hasMany('App\Models\AprovacaoTarefas', 'issue_id', 'id')->where('customized_type', 'IssueIndicator')->with('indicador');
    }

    public function report_orcamento_realizado()
    {
        return $this->hasMany('App\Models\AprovacaoTarefas', 'issue_id', 'id')->where('customized_type', 'IssueBudget')->with('orcamento');
    }

    public function realizado_aprovado()
    {
        return $this->hasMany('App\Models\AprovacaoTarefas', 'customized_id', 'id')->where('is_approved', true);
    }

    public function realizado_nao_aprovado()
    {
        return $this->hasMany('App\Models\AprovacaoTarefas', 'issue_id', 'id')->where('is_approved', false);
    }

    public function realizado_rejeitado()
    {
        return $this->hasMany('App\Models\AprovacaoTarefas', 'customized_id', 'id')->where('is_rejected', true);
    }

    public function get_unapproved_reports()
    {
        return TimeEntries::where('issue_id', $this->id)
            ->join('time_entries_values', 'time_entries_values.time_entry_id', 'time_entries.id')
            ->where('time_entries.deleted_at', null)
            ->where('time_entries_values.is_approved', false)
            ->where('time_entries_values.deleted_at', null)
            ->count();
    }

    /**
     * Documentos de suporte da tarefa
     */
    public function attachments()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'IssueAttachs');
    }

    /**
     * Documentos de suporte solicitacao de fundos
     */
    public function budget_suport_attachments()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'IssueBudgetsRequest');
    }

    /**
     * Report files
     */
    public function attachments_report_indicadores()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'IssueReportIndicadores');
    }

    public function attachments_report_orcamento()
    {
        return $this->hasMany(Attachments::class, 'container_id', 'id')->where('container_type', 'IssueReportBudget');
    }

    /**
     * check if init on approvement flow
     */
    public function isInitApproval()
    {
        if ($this->tracker_id == 14) {
            return ApprovementFlowModels::where('customized_id', $this->id)
                ->where('customized_type', 'Issue')
                ->get()
                ->count();
        }
    }

    public function beneficiarios()
    {
        return $this->hasMany(IssuesBeneficiarios::class, 'issue_id', 'id')->orderBy('type');
    }


    public function getOrcamentoPrevAttribute()
    {
        return $this->orcamento()->get()->sum('issued_value');
    }

    public function getOrcamentoGastoAttribute()
    {
        return $this->orcamento()->get()->sum('valor_realizado');
    }

    public function orcamento_prev($year = null)
    {
        $year = $year ?? date('Y');
        return $this->orcamento()->whereYear('issued_at', $year)->get()->sum('issued_value');
    }
}
