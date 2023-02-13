<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Partners;
use App\Models\Projects;
use App\Models\ProjectsPartners;
use Illuminate\Support\Facades\DB;
use App\Models\RubricasOrcamento as ModelRubricasOrcamento;

class BudgetForm extends Component
{
    public $budget_to;
    public $identifier;
    public $orcamentar_para;
    public $iva = 17;
    public $use_iva;
    public $budget_value;
    public $total_budget;
    // public
    public $currency;
    public $is_edit = false;
    public $request_url;
    public $errors = [];
    public $notes = null;

    public $rubrica;
    public $budgetTrackers = [];
    public $tracker_id;
    public $tracker_name;
    public $Qtd;
    public $price;

    public $selected_tracker;
    public $provincia;
    public $issue;

    public $partners = [];
    public $years = [];

    public $issued_at;

    public $search_project = null;
    public $projects = [];
    public $isSearch = false;

    public $selected_project = null;
    public $selected_project_id = null;
    public $selected_year = null;

    public function reset_search()
    {
        $this->isSearch = false;
    }

    // load on mount
    public function mount($budget_to, $is_edit, $errors, $budget)
    {

        $this->issue = $budget_to;
        // $this->errors = $errors;
        $this->currency = "MZ";
        $this->use_iva = false;
        $this->init($budget_to);

        if ($is_edit) {
            $this->loadvalues($budget);
            $this->is_edit = $is_edit;
            $this->request_url = route('issues.budget.update', [
                'issue' => $budget_to->id,
                'budget' => $budget->id,
                'reference' => $this->orcamentar_para,
                'identifier' => $this->identifier
            ]);
        } else {
            $this->is_edit = $is_edit;
            $this->request_url = route('budget.store', ['reference' => $this->orcamentar_para, 'identifier' => $this->identifier]);
        }

        $this->search_project = $this->issue->project->name;
        $this->selected_project = $this->issue->project;
        $this->selected_project_id = $this->issue->project->identifier;

        $this->years = ModelRubricasOrcamento::select(DB::raw('year'))
                                            ->where('year', "!=", "null")
                                            ->groupBy('year')
                                            ->orderby('year', 'desc')
                                            ->get()->toArray();

        $this->budgetTrackers = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->where("year", "=", $years[0]['year'] ?? "2022")->get();

        $this->initCustomFiels($this->budget_to['id']);

        $this->load_project_partners();
    }

    public function render()
    {
        return view('livewire.budget-form');
    }

    /**
     * Caregar os dados de parceiros por projeco (tarefa)
     */
    protected function load_project_partners()
    {
        $this->partners = ProjectsPartners::where('project_id', $this->selected_project->id)
            ->with(['partner' => function ($partner) {
                $partner->where('type', 25);
            }])->has('partner.tipo')->get()->filter(function ($item) {
                if ($item['partner'] !== null) {
                    return $item;
                }
            });

        // dd($this->partners);
    }

    public function init($budget_to)
    {
        // session()->forget('error');
        // session()->forget('success');
        // session()->forget('warning');

        if (isset($budget_to['project_id'])) {
            $this->orcamentar_para = 'issue';
            $this->identifier = $budget_to['id'];
            return $this->budget_to = array(
                'id' => $budget_to['id'],
                'name' => $budget_to['subject'],
                'type' => 'issue',
            );
        } else if (isset($budget_to['type'])) {
            $this->orcamentar_para = 'project';
            $this->identifier = $budget_to['identifier'];
            return $this->budget_to = array(
                'id' => $budget_to['id'],
                'name' => $budget_to['name'],
                'type' => 'project',
            );
        }
    }

    public $available_custom_fields_values = [];
    public function initCustomFiels($issue_id)
    {
        $available_custom_fields = \App\Models\BudgetCustomFields::get()->map(function ($item) {
            return $item['custom_field_id'];
        })->toArray();

        $data = \App\Models\CustomValues::whereIn('custom_field_id', $available_custom_fields)
            ->where('customized_id', $issue_id)
            // ->get()
            ->with('custom_field')
            ->get()->groupBy('custom_field.name')->toArray();

        foreach ($data as $key => $custom_fields_values) {
            if ($key == 'Província' || $key == 'Provincia') {
                $this->provincia = $custom_fields_values[0]['value'];
            }
        }

        $this->available_custom_fields_values = $data;
    }

    public function updatedBudgetValue()
    {
        if ($this->budget_value !== '') {
            if ($this->use_iva) {

                $this->total_budget = (1 + $this->iva / 100) * $this->budget_value;
                $this->total_budget = number_format(($this->total_budget), 2);
            } else {
                $this->total_budget = number_format(($this->budget_value), 2);
            }
        }
    }

    public function updatedUseIva()
    {
        if ($this->use_iva) {
            $this->total_budget = (1 + $this->iva / 100) * $this->budget_value;
            $this->total_budget = number_format(($this->total_budget), 2);
        } else {
            $this->total_budget = number_format(($this->budget_value), 2);
        }
    }

    public $selected_budget_trackers_ids = [];

    public function updatedSelectedTracker($id)
    {
        $buget_trackers = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->where('id', $id)->first();

        $this->tracker_id = $id;
        $this->tracker_name = $buget_trackers['name'];
        // dd($this->provincia);
        // $this->price = $buget_trackers->default_value_provincia($this->provincia)['value'] ?? 0;
    }

    public $selected_budget_details = [];
    public function array_orcamento_builder()
    {
        $builded = array(
            'tracker_id' => $this->tracker_id,
            'tracker_name' => $this->tracker_name,
            'Qtd' => $this->Qtd,
            'price' => $this->price,
            'sub_total' => $this->price * $this->Qtd
        );

        $this->selected_tracker = null;
        $this->tracker_id = null;
        $this->tracker_name = null;
        $this->Qtd = null;
        $this->price = null;

        return $builded;
    }

    public $addRubricaWarning = null;
    /**
     * Adicionar orcamento a tabla
     */
    public function add_budget()
    {
        $rubrica = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->where('id', $this->tracker_id)->first();

        if ($rubrica->orcamento == 0) {
            return $this->addRubricaWarning = 'Sem fundos para a despesas de: (' . $rubrica->name . ') - Disponivel: ' . number_format(($rubrica->orcamento), 2) . ' MTN';

            // return session()->flash('error', 'Sem fundos para a despesas de: (' . $rubrica->name . ')');
        }

        if ($rubrica->orcamento < $this->price) {
            return $this->addRubricaWarning = 'Não processado!!! Detectamos que você Solicitou um valor maior que o orçamento disponível para a despesa: (' . $rubrica->name . ')';

            // return session()->flash('error', 'Não processado!!! Detectamos que você Solicitou um valor maior que o orçamento disponível para a despesa: (' . $rubrica->name . ')');
        }

        array_push($this->selected_budget_trackers_ids, $this->tracker_id);
        array_push($this->selected_budget_details, $this->array_orcamento_builder());

        $this->updateAvailableTrackers();

        session()->forget('error');
        session()->forget('success');
        session()->forget('warning');
        $this->addRubricaWarning = null;
    }

    /**
     * Remove Selected Budget
     */
    public function remove_budget($key, $tracker_id)
    {
        $this->selected_budget_trackers_ids = array_diff($this->selected_budget_trackers_ids, [$tracker_id]);
        $this->selected_budget_details = \array_diff_key($this->selected_budget_details, [$key => true]);
        $this->updateAvailableTrackers();
    }

    /**
     * Atualizar e remover os tracker de orcamento
     * (tipo de despesa) que ja foram selecionados e orcamentados
     */
    public function updateAvailableTrackers()
    {
        if ($this->selected_budget_trackers_ids !== []) {
            return $this->budgetTrackers = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->whereNotIn('id', $this->selected_budget_trackers_ids)->get();
        }
        return $this->budgetTrackers = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->get();
    }


    public function loadvalues($budget)
    {
        $this->notes = $budget->budget_values[0]['issue_budget']['notes'] ?? null;

        foreach ($budget->budget_values as $key => $budgetValue) {
            $this->issued_at = $budgetValue->issued_at;

            $this->selected_tracker = $budgetValue->budget_tracker_id;
            $this->tracker_id = $budgetValue->budget_tracker_id;
            $this->tracker_name = $budgetValue->rubrica->name;
            $this->Qtd = null;
            $this->price = $budgetValue->issued_value;

            array_push($this->selected_budget_trackers_ids, $budgetValue->budget_tracker_id);
            array_push($this->selected_budget_details, $this->array_orcamento_builder());

            $this->updateAvailableTrackers();
        }
    }

    /**
     * Search Project
     */
    public function updatedSearchProject()
    {
        $this->isSearch = true;

        if ($this->search_project  == '') {
            return $this->reset_search();
        }

        return $this->projects = Projects::where('is_public', true)
            ->where(function ($query) {
                $query->where('id', 'like', '%' . $this->search_project . '%')
                    ->orWhere('name', 'like', '%' . $this->search_project . '%');
            })
            ->where('type', 'Project')
            ->where('has_shared_budget', false)
            ->limit(10)
            ->orderBy('name')
            ->get();
    }

    /**
     * This should query budget on the budget Entity
     * based on the seleccted year
     *
     * by defaults we use the first year on the list
     *
     */
    public function updatedSelectedYear()
    {
        $this->budgetTrackers = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->where("year", "=", $this->selected_year)->get();
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

            $this->budgetTrackers = ModelRubricasOrcamento::where('project_id', $this->selected_project->id)->get();

            $this->reset_search();
        } catch (Throwable $e) {
            return session()->flash('warning', 'O projecto selecionado nao e valido ou ocorreu um problema. Tente novamente.');
        }
    }
}
