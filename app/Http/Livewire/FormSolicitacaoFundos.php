<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\Projects;
use App\Models\Enumerations;
use App\Models\ApprovementFlow;
use App\Models\RubricasOrcamento;
use App\Models\AppApprovementFlows;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Helpers\SolicitacaoFundos\HelperFormSolicitacaoFundos;
use App\Http\Controllers\Features\SolicitacaoFundos\SolicitacaoFundosRepository;

class FormSolicitacaoFundos extends Component
{

    use HelperFormSolicitacaoFundos;

    public $steps = [
        'informacao_base' => true,
        'areas_necessidades' => false,
        'pilar_projecto' => false,
        'detalhes_requisicao' => false
    ];

    public $btnActionName = "Submeter";
    public $isEdit = false;

    public $isSearchIssue = false;
    public $searchIssue;
    public $search_IssueRequest_result;
    public $selected_issue_id;
    public $search_TypeSolicitacoRequest_result;

    public $optionsActions = true;
    public $requestNum = 'auto';
    public $requisitante;
    public $valor_estimado;
    public $rubricas = [];
    public $tipoSolicitacao = [];

    public $areas = [];
    public $actividades = [];
    public $necessidades = [];

    public $local;
    public $data;
    public $num_dias;
    public $num_participantes;

    public $ocs = '';
    public $selected_area;
    public $selected_necessidade;
    public $selected_actividade;
    public $project;
    public $objectivo;
    public $pilar_id; // Programa

    public $isSearch = false;
    public $projects = [];
    public $search_project = null;

    public $selected_project = null;
    public $selected_project_id = null;

    public $requisicaoFundos;

    public $usersToApprove = [];
    public $userTo = null;
    public $years = [2020];
    public $filterYear =  'all-years';

    public function mount($project, $requisicaoFundos = null)
    {
        $this->isEdit = Route::is('orcamento.projecto.form_edit_solicitacao_fundos');
        $this->filters_year();
        foreach ($this->years as $key => $value) {
            $this->filterYear = $value['year'];
        }
        $this->selected_project = $project;
        
        $this->areas = \App\Models\Enumerations::where('type', 'IssueArea')->where('parent_id', null)->get();
        $this->actividades = \App\Models\Enumerations::where('type', 'IssueActividade')->where('parent_id', null)->get();
        $this->necessidades = \App\Models\Enumerations::where('type', 'IssueNecessidade')->where('parent_id', null)->get();

        $this->loadRubricasOrcamento();
        $this->updatedSearchType();

        $this->requisitante = auth()->user()->full_name;
        $this->valor_estimado = null;
        $this->num_dias = 0;
        $this->num_participantes = 0;
        $this->project = $project;
        $this->requisicaoFundos = $requisicaoFundos;
        

        if ($this->isEdit) {
            $this->btnActionName = "Atualizar";
            $this->loadDataRequest();
        } else {
            $this->usersToApprove = $this->getUseToApprove();
        }

        if ($project->parent == null) {
            abort(403, "Fatal Error... You can not request budget \n on a project with no parent or type PDE. I has to be type of Project");
        }
    }

    public function render()
    {

        return view('livewire.form-solicitacao-fundos');
    }

    public function filters_year()
    {
        $this->years = RubricasOrcamento::select('year')->where('year','!=',null)->groupBy('year')->get()->toArray();
    }

    public function loadDataRequest()
    {
        $this->requestNum = $this->requisicaoFundos->num_requisicao;
        $this->requisitante = auth()->user()->full_name;
        $this->valor_estimado = $this->requisicaoFundos->valor_estimado;
        $this->num_dias = $this->requisicaoFundos->num_dias;
        $this->num_participantes = $this->requisicaoFundos->num_participantes;
        $this->data = $this->requisicaoFundos->data;
        $this->local = $this->requisicaoFundos->local;
        $this->objectivo = $this->requisicaoFundos->objectivo;


        // Load rubricas selecionadas
        $this->load_rubricas_gravadas($this->requisicaoFundos);

        // load optoins
        $this->load_rubricas_options($this->requisicaoFundos);
    }

    public function gotStep($step_name)
    {
        foreach ($this->steps as $key => $value) {
            $this->steps[$key] = false;
        }
        return $this->steps[$step_name] = true;
    }


    public function loadRubricasOrcamento()
    {
        $this->rubricas = RubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->selected_project->id)
            ->where('year',$this->filterYear)
            ->orderBy('rubrica')->get();
    }


    /**
     * Cancel form creation and redirect to next pre-view
     */
    public function cancel()
    {
        // Redirect user to prev page
    }


    public function reset_search()
    {
        $this->isSearch = false;
        $this->isSearchIssue = false;
    }

    /**
     * Search Project
     */
    public function updatedSearchProject()
    {
        $this->isSearch = true;

        if ($this->search_project  == '') {
            $this->selected_project = $this->project;
            $this->loadRubricasOrcamento();
            return $this->reset_search();
        }

        return $this->projects = Projects::where('is_public', true)
            ->where(function ($query) {
                $query->where('id', 'like', '%' . $this->search_project . '%')
                    ->orWhere('name', 'like', '%' . $this->search_project . '%');
            })
            ->where('has_shared_budget', false)
            ->where('type', 'Project')
            ->limit(10)
            ->orderBy('name')
            ->get();
    }

    /**
     * Select Project
     *
     * @param string $project_id
     * @param string $project_identifier
     */
    public function select_project($project_id, $identifier)
    {
        try {
            $this->selected_project = Projects::select('id', 'name', 'identifier')
                ->where('id', $project_id)
                ->where('is_public', true)
                ->where('has_shared_budget', false)
                ->where("identifier", $identifier)
                ->where('type', 'Project')
                ->firstOrFail();

            $this->search_project = $this->selected_project->name;
            $this->selected_project_id = $this->selected_project->identifier;

            $this->loadRubricasOrcamento();

            $this->reset_search();
        } catch (\Throwable $e) {
            return session()->flash('warning', 'O projecto selecionado nao e valido ou ocorreu um problema. Tente novamente.');
        }
    }

    /**
     * Check if area has
     * childs and return childs has response
     *
     * @return collection $areas
     */
    public function updatedSelectedArea()
    {
        try {
            $area = \App\Models\Enumerations::where('parent_id', $this->selected_area)->findOrFail();
            return $this->areas = \App\Models\Enumerations::where('parent_id', $this->selected_area)->where('type', $area->type)->get();
        } catch (\Throwable $th) {
            return  $this->selected_area;
        }
    }

    /**
     * Check if area has
     * childs and return childs has response
     *
     * @return collection $necessidades
     */
    public function updatedSelectedNecessidade()
    {
        try {
            $necessidades = \App\Models\Enumerations::where('parent_id', $this->selected_necessidade)->firstOrFail();
            return $this->necessidades = \App\Models\Enumerations::where('parent_id', $this->selected_necessidade)
                ->where('type', $necessidades->type)
                ->get();
        } catch (\Throwable $th) {
            return $this->selected_necessidade;
        }
    }

    /**
     * Check if area has
     * childs and return childs has response
     *
     * @return collection $actividades
     */
    public function updatedSelectedActividade()
    {
        try {
            $selected_actividade = \App\Models\Enumerations::where('parent_id', $this->selected_actividade)->firstOrFail();
            return $this->actividades = \App\Models\Enumerations::where('parent_id', $this->selected_actividade)
                ->where('type', $selected_actividade->type)
                ->get();
        } catch (\Throwable $th) {
            return $this->selected_actividade;
        }
    }

    public function updatedSearchRubrica()
    {
        $this->rubricas = RubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->project->id)
            ->where(function ($query) {
                if ($this->filterYear !== "all-years") {
                    $query->where('year', $this->filterYear);
                }
            })
            ->orderBy('rubrica')->get();
    }

    public function updatedFilterYear()
    {
        $this->rubricas = RubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->project->id)
            ->where(function ($query) {
                if ($this->filterYear !== "all-years") {
                    $query->where('year', $this->filterYear);
                }
            })
            ->orderBy('rubrica')->get();
    }

    public function store()
    {
        $this->optionsActions = false;

        $this->steps['informacao_base'] = true;
        $this->steps['areas_necessidades'] = true;
        $this->steps['pilar_projecto'] = true;
        $this->steps['detalhes_requisicao'] = true;

        $requestData = [
            'author' => auth()->user()->id,
            'valor_estimado' => $this->valor_estimado,
            'rubricas' => $this->rubricas,
            'area' => $this->selected_area,
            'necessidades' => $this->selected_necessidade,
            'actividades' => $this->selected_actividade,
            'pilar' => $this->project->parent_id,
            'project' => $this->project->id,
            'local' => $this->local,
            'data' => $this->data,
            'num_participantes' => $this->num_participantes,
            'num_dias' => $this->num_dias,
            'ocs' => $this->ocs,
            'objectivo' => $this->objectivo,
        ];

        $solicitacaoFundosRepository = new SolicitacaoFundosRepository();

        // return $solicitacaoFundosRepository->saveSolicatacaoFundos($requestData);
    }


    public $select_rubricas = [];
    public $select_rubricas_id = [];
    public $selected_rubrica_id;

    /**
     * Adicionar Rubricas
     */
    public function addRubrica()
    {

        // if (\sizeof($this->select_rubricas) < 4 && $this->selected_rubrica_id !== null) {

        $this->select_rubricas_id[] = $this->selected_rubrica_id;

        $rubrica = RubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')->where('id', $this->selected_rubrica_id)->first();
       // dd($rubrica->sum("orcamento_inicial"));
        $this->select_rubricas[] = array(
            "id" => $this->selected_rubrica_id,
            "name" => $rubrica->name,
            "project_id" => $rubrica->project_id
        );
        // }

        $this->rubricas = RubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->selected_project->id)
            ->whereNotIn('id', $this->select_rubricas_id)
            ->orderBy('rubrica')->get();


        $this->selected_rubrica_id = null;
    }

    public function removeRubrica(int $index)
    {
        $this->select_rubricas_id = \array_diff($this->select_rubricas_id, [$this->select_rubricas[$index]['id']]);
        $this->select_rubricas = \array_diff_key($this->select_rubricas, [$index => true]);

        $this->rubricas = RubricasOrcamento::select('*', 'parent_rubrica_id as parent_id')
            ->where('project_id', $this->selected_project->id)
            ->whereNotIn('id', $this->select_rubricas_id)
            ->orderBy('rubrica')->get();

        $this->selected_rubrica_id = null;
    }



    public $selected_areas = [];
    public $selected_areas_id = [];
    public $selected_area_id = null;

    public $selected_actividades = [];
    public $selected_actividades_id = [];
    public $selected_actividade_id = null;

    public $selected_necessidades = [];
    public $selected_necessidades_id = [];
    public $selected_necessidade_id = null;
    /**
     * Add array Area, necessidade, actidade
     *
     * @param string $type
     * @return void
     */
    public function addOption(string $type)
    {

        switch ($type) {
            case 'area':

                if ($this->selected_area === null) {
                    return;
                }

                $this->selected_areas_id[] = $this->selected_area;
                $this->selected_areas[] = array(
                    "id" => $this->selected_area,
                    "name" => Enumerations::select('id', 'name', 'active')->where('id', $this->selected_area)->where('active', true)->first()->name
                );

                $this->areas = Enumerations::select('id', 'name', 'active')
                    ->where('active', true)
                    ->where('type', 'IssueArea')->where('parent_id', null)
                    ->whereNotIn('id', $this->selected_areas_id)
                    ->orderBy('name')->get();


                $this->selected_area = null;
                break;
            case 'actividade':

                if ($this->selected_actividade === null) {
                    return;
                }

                $this->selected_actividades_id[] = $this->selected_actividade;
                $this->selected_actividades[] = array(
                    "id" => $this->selected_actividade,
                    "name" => Enumerations::select('id', 'name', 'active')->where('id', $this->selected_actividade)->where('active', true)->first()->name
                );

                $this->actividades = Enumerations::select('id', 'name', 'active')
                    ->where('active', true)
                    ->where('type', 'IssueActividade')
                    ->whereNotIn('id', $this->selected_actividades_id)
                    ->orderBy('name')->get();


                $this->selected_actividade = null;
                break;
            case 'necessidade':

                if ($this->selected_necessidade === null) {
                    return;
                }

                $this->selected_necessidades_id[] = $this->selected_necessidade;
                $this->selected_necessidades[] = array(
                    "id" => $this->selected_necessidade,
                    "name" => Enumerations::select('id', 'name', 'active')->where('id', $this->selected_necessidade)->where('active', true)->first()->name
                );

                $this->necessidades = Enumerations::select('id', 'name', 'active')
                    ->where('active', true)
                    ->where('type', 'IssueNecessidade')->where('parent_id', null)
                    ->whereNotIn('id', $this->selected_necessidades_id)
                    ->orderBy('name')->get();

                $this->selected_necessidade = null;
                break;
            default:
                break;
        }
    }


    /**
     * Remove the specified resource from array.
     * Area, necessidades, actividade
     *
     * @param string $type
     */
    public function removeOption(string $type, int $index, $isSubmit = false)
    {
        switch ($type) {
            case 'area':
                if (!$isSubmit) {
                    return $this->delete_option($type, false, $this->selected_areas[$index]['id']);
                }

                $this->selected_areas_id = \array_diff($this->selected_areas_id, [$this->selected_areas[$index]['id']]);
                $this->selected_areas = \array_diff_key($this->selected_areas, [$index => true]);

                $this->areas = Enumerations::select('id', 'name', 'active')
                    ->where('active', true)
                    ->where('type', 'IssueArea')->where('parent_id', null)
                    ->whereNotIn('id', $this->selected_areas_id)
                    ->orderBy('name')->get();


                $this->selected_area = null;
                break;
            case 'actividade':
                if (!$isSubmit) {
                    return $this->delete_option($type, false, $this->selected_actividades[$index]['id']);
                }
                $this->selected_actividades_id = \array_diff($this->selected_actividades_id, [$this->selected_actividades[$index]['id']]);
                $this->selected_actividades = \array_diff_key($this->selected_actividades, [$index => true]);

                $this->areas = Enumerations::select('id', 'name', 'active')
                    ->where('active', true)
                    ->where('type', 'IssueArea')->where('parent_id', null)
                    ->whereNotIn('id', $this->selected_actividades_id)
                    ->orderBy('name')->get();


                $this->selected_actividade = null;
                break;
            case 'necessidade':

                if (!$isSubmit) {
                    return $this->delete_option('necessidade', false, $this->selected_necessidades[$index]['id']);
                }

                $this->selected_necessidades_id = \array_diff($this->selected_necessidades_id, [$this->selected_necessidades[$index]['id']]);
                $this->selected_necessidades = \array_diff_key($this->selected_necessidades, [$index => true]);

                $this->areas = Enumerations::select('id', 'name', 'active')
                    ->where('active', true)
                    ->where('type', 'IssueArea')->where('parent_id', null)
                    ->whereNotIn('id', $this->selected_areas_id)
                    ->orderBy('name')->get();


                $this->selected_necessidade = null;
                break;
            default:
                break;
        }
    }


    public $nivel_description = null;
    public $role_need = null;

    protected function getUseToApprove()
    {
        $users = [];
        
        try {
            $approvement_flow = ApprovementFlow::where('trigger', 'initial_flow')->where('type', 'SolicitacaodeFundos')->firstOrFail();
            // check if user is a member of the project with valid role

            $this->nivel_description = $approvement_flow->description;
            $this->role_need = $approvement_flow->role->name;

            foreach ($this->project->members as $key => $member) {

                if ($member->member_roles()->where('role_id', $approvement_flow->role->id)->first()) {
                    $users[] = $member->user;
                }
            }

            if (sizeOf($users) == 0) {
                $this->userNotSelectedErrorMenssage = "Fatal Error! User with valid role({$this->role_need}) to approve the requested flow has not been found!";
                // session()->flash('error', $this->userNotSelectedErrorMenssage);
            };
        } catch (\Throwable $th) {
            throw $th;
        }
        return $users;
    }


    /**
     *
     * Search Budgets - para associar a actividade
     *
     * @param string search_input
     * @return \App\Models\SolicitacaoFundos
     */
    public function updatedSearchIssue()
    {
        if ($this->searchIssue !== '') {
            $this->isSearchIssue = true;
            return $this->search_IssueRequest_result = Issues::where('project_id', $this->project->id)
                ->where('solicitacao_fundos_id', null)
                ->where(function ($query) {
                    $query->where('id', 'like', '%' . $this->searchIssue . '%')
                        ->orWhere('subject', 'like', '%' . $this->searchIssue . '%');
                })->limit(15)->get();
        } else {
            $this->reset_search();
            $this->selectedIssue = [
                'id' => null,
                'subject' => '',
                'description' => ''
            ];
            $this->selected_issue_id = null;
        }
    }

    public $selectedIssue = [
        'id' => null,
        'subject' => '',
        'description' => ''
    ];
    public function selectIssue(int $issueID, string $issueSubject)
    {
        $this->selected_issue_id = $issueID;
        $this->selectedIssue = [
            'id' => $issueID,
            'subject' => $issueSubject,
            'description' => Issues::select('description')->where('id', $issueID)->first()->description ?? '',
        ];
        $this->searchIssue = $issueSubject;
        $this->reset_search();
    }

    /**
     *
     * Search Type Request - para selecionar o Tipo de requisicao
     *
     * @param string search_input
     * @return \App\Models\SolicitacaoFundos
     */
    public $selected_typeSolicitacao_id;
    public function updatedSearchType()
    {

        $this->search_TypeSolicitacoRequest_result = AppApprovementFlows::where('tagCode', 'like', '%' . 'SolicitacaodeFundos' . '%')
            ->limit(15)->get();
    }
}
