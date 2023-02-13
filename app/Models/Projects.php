<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projects extends Model
{
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'identifier';
    }


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'description', 'homepage', 'is_public', 'parent_id', 'author_id', 'identifier', 'status', 'has_shared_budget', 'created_on', 'updated_on', 'lft', 'rgt', 'inherit_members', 'default_version_id', 'default_assigned_to_id'
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
        'created_on' => 'created_on',
    ];


    protected $appends = [
        'route',
        // 'budget_program',
        // 'budget_project_childs',
        // 'orcamento_inicial',
        // 'orcamento_gasto',
        // 'orcamento_inicial_sub_project',
        // 'orcamento_gasto_sub_project',
        // 'manager',
        'objectivo_geral',
        'objectivo_especi',
        'objectivo_plano',
        // 'inicio_ano',
        // 'duracao',
        'pronvincia'
    ];


    public function getManagerAttribute()
    {
        $manager = $this->members()->whereHas('member_roles', function ($query) {
            $query->where('role_id', 3);
        })->first()->user->full_name ?? "Gestor de Projectos!!!";

        return $manager;
    }

    public function getDuracaoAttribute()
    {
        $duracao = $this->customFieldValues()->where('custom_field_id', 28)->get(['value'])->first();

        return $duracao;
    }

    public function getPronvinciaAttribute()
    {
        $pronvincia = $this->customFieldValues()->where('custom_field_id', 30)->get(['value'])->first();

        return $pronvincia;
    }

    public function getObjectivoGeralAttribute()
    {
        $objectivo_geral = $this->customFieldValues()->where('custom_field_id', 38)->get(['value'])->first();

        return $objectivo_geral;
    }

    public function getObjectivoEspeciAttribute()
    {
        $objectivo_especi = $this->customFieldValues()->where('custom_field_id', 39)->get(['value'])->first();

        return $objectivo_especi;
    }

    public function getObjectivoPlanoAttribute()
    {
        $objectivo_plano = $this->customFieldValues()->where('custom_field_id', 41)->get(['value'])->first();

        return $objectivo_plano;
    }

    public function getInicioAnoAttribute()
    {
        $inicio_ano = $this->customFieldValues()->where('custom_field_id', 44)->get(['value'])->first();

        return $inicio_ano;
    }
    /**
     * Geting the parent for the selected project
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Projects', 'parent_id', 'id');
    }

    /**
     * Prioridade do projecto
     */
    public function priority()
    {
        return $this->hasOne('App\Models\Enumerations', 'priority_id', 'id');
    }


    /**
     * Get Project childs
     */
    public function childs()
    {
        return $this->hasMany('App\Models\Projects', 'parent_id', 'id')->where('status', 1)->orderBy('rgt', 'asc');
    }

    /**
     * All issues that belongs to this project
     */
    public function issues()
    {
        return $this->hasMany('App\Models\Issues', 'project_id', 'id')->with('tracker', 'status');
    }

    /**
     * All issues Workflow
     */
    public function issues_workflow()
    {
        return $this->hasMany('App\Models\Issues', 'project_id', 'id')->with('tracker', 'status')->whereHas('workflowPFE');
    }


    /**
     * All issues that belongs to this project with id = 7
     */
    public function issuesFolege()
    {
        return $this->hasMany('App\Models\Issues', 'project_id', 'id')->where('tracker_id', 7)->with('tracker', 'status');
    }

    /**
     * All issue_changes that belongs to this project
     */
    public function issue_changes()
    {
        return $this->hasMany('App\Models\Journals', 'journalized_id', 'id');
    }

    // CustomFieldsProjects
    # Custom field for the project issues
    // has_and_belongs_to_many
    public function issue_custom_fields()
    {
        return $this->hasMany('App\Models\CustomFieldsProjects', 'project_id', 'id')->with('issue_custom_fields');
    }

    /**
     * Project CustomValues
     */
    public function custom_field_values()
    {
        return $this->hasMany('App\Models\CustomValues', 'customized_id', 'id')->where('customized_type', 'Project')->with('custom_field');
    }

    public function custom_fields()
    {
        return $this->belongsToMany('App\Models\CustomFields', 'custom_values', 'customized_id', 'custom_field_id')->with('custom_values');
    }

    /**
     * Project CustomValues
     */
    public function customFieldValues()
    {
        return $this->hasMany('App\Models\CustomValues', 'customized_id', 'id')->with('custom_field');
    }

    /**
     * Project members
     */
    public function members()
    {
        return $this->hasMany('App\Models\Members', 'project_id', 'id')->with(['user', 'member_roles', 'project_roles'])->whereHas('user');
    }

    /**
     * All issue_changes that belongs to this project
     */
    public function default_assigned_to()
    {
        return $this->belongsTo('App\Models\User', 'foreign_key', 'id');
    }

    /**
     * All issue_changes that belongs to this project
     */
    public function time_entries()
    {
    }

    /**
     * All issue_changes that belongs to this project
     */
    public function queries()
    {
    }

    /**
     * All issue_changes that belongs to this project
     */
    public function documents()
    {
        return $this->hasMany('App\Models\Documents', 'project_id', 'id')->with('category', 'attachments');
    }

    /**
     * All news that belongs to this project
     */
    public function news()
    {
        return $this->hasMany('App\Models\News', 'foreign_key', 'id');
    }

    /**
     * All issue_categories that belongs to this project
     */
    public function issue_categories()
    {
    }

    /**
     * All boards that belongs to this project
     */
    public function boards()
    {
    }

    /**
     * All repositories that belongs to this project
     */
    public function repositories()
    {
    }

    /**
     * All changesets that belongs to this project
     */
    public function changesets()
    {
    }

    /**
     * All wiki that belongs to this project
     */
    public function wiki()
    {
        return $this->hasOne('App\Models\User', 'foreign_key', 'id');
    }

    /**
     * All repository that belongs to this project
     */
    public function repository()
    {
        return $this->hasOne('App\Models\User', 'foreign_key', 'id');
    }

    /**
     * All repository that belongs to this project
     */
    public function project_trackers()
    {
        return $this->hasMany('App\Models\ProjectTrackers', 'project_id', 'id')->whereHas('tracker')->with("tracker");
    }

    /**
     * Enabled modules
     */
    public function modules()
    {
        return $this->hasMany('App\Models\EnabledModules', 'project_id', 'id');
    }


    public function project_trackers_overview()
    {
        // return $this->hasMany('App\Models\Issues', 'project_id', 'id')->where('');
    }

    public function url_new_budget()
    {
        // return $this->identifier;
        return route('projects.budget.new', ['project_identifier' => $this->identifier ?? 'project-none-exist']);
    }

    public function partners()
    {
        return $this->hasMany('App\Models\ProjectsPartners', 'project_id', 'id')->with('partner');
    }

    /**
     * Orcamento de subprojectos
     */
    public function getOrcamentoInicialSubProjectAttribute()
    {
        return $this->childs()->get()->sum('orcamento_inicial');
    }

    public function getOrcamentoGastoSubProjectAttribute()
    {
        return $this->childs()->get()->sum('orcamento_gasto');
    }

    public function getOrcamentoInicialAttribute()
    {
        return $this->orcamento()->get()->sum('orcamento_inicial');
    }

    public function getOrcamentoGastoAttribute()
    {
        return $this->orcamento()->get()->sum('orcamento_gasto');
    }

    public function getRouteAttribute()
    {
        return route('projects.overview', ['project_identifier' => $this->identifier ?? 'project-none-exist']);
    }

    public function getBudgetProgramAttribute()
    {
        return 0;
        // return $this->hasOne('App\Models\CustomValues', 'customized_id', 'id')->where('custom_field_id', 70)->where('value', '!=', null);
    }

    public function getBudgetProjectChildsAttribute()
    {
        return 0;
        // return $this->hasOne('App\Models\CustomValues', 'customized_id', 'id')->where('custom_field_id', 70)->where('value', '!=', null);
    }

    /**
     * Orcamento do Projecto
     */
    public function orcamento()
    {
        return $this->hasMany('App\Models\RubricasOrcamento', 'project_id', 'id');
    }

    /**
     * Orcamento Gasto do projecto
     */
    function orcamento_prev_tarefa($year = null)
    {
        $year = $year ?? date('Y');
        $response = 0;
        foreach ($this->issues()->get() as $issue) {
            $response += $issue->orcamento()->whereYear('issued_at', $year)->get()->sum('issued_value');
        }
        return $response;
    }
}
