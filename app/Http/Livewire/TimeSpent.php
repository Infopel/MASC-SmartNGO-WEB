<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TimeSpent extends Component
{

    public $search_issues_input;
    public $search_indicators_input;
    public $search_issues_result;
    public $selected_issue;
    public $selected_issue_id;
    public $selected_indicator_id;
    public $used_issues_ids = [];
    public $is_search = false;

    public $issue;
    public $activities;
    public $file_forms = [];

    public $isEdit = false;
    public $resourceType = '';
    public $time_entrie;

    public $reportType = 'actividades';

    public function mount($params)
    {

        $this->isEdit = $params['isEdit'];
        $this->resourceType = $params['recourceType'];
        $this->time_entrie = $params['time_entrie'];

        // dd($this->time_entrie->comments);

        $this->issue = $params['issue'];
        $this->search_issues_input = $params['issue']['subject'] ?? null;
        $this->selected_issue_id = $params['issue']['id'] ?? null;

        $this->loadIssueIndicator($params['issue']->id ?? null);
        $this->loadIssueDespesas($params['issue']->id ?? null);

        $this->activities = \App\Models\Enumerations::where('type', 'TimeEntryActivity')->orderby('position', 'asc')->get();


        if (request()->has('reportType')) {
            $this->reportType = request()->get('reportType');
        }
    }

    public function render()
    {
        return view('livewire.time-spent');
    }

    /**
     * Search for issues
     */
    public function updatedSearchIssuesInput()
    {
        $this->is_search = true;
        return $this->search_issues_result = \App\Models\Issues::where(function ($q) {
            $q->where('id', 'like', '%' . $this->search_issues_input . '%')->orWhere('subject', 'like', '%' . $this->search_issues_input . '%');
        })->where('is_aproved', true)->get();
    }


    /**
     * Selected Issue
     */
    public function selected_issue($id, $subject)
    {
        $this->selected_issue_id = $id;
        $this->search_issues_input = $subject;
        $this->is_search = false;
        $this->loadIssueIndicator($id);
        $this->loadIssueDespesas($id);
    }

    /**
     * Search for Indicators
     */
    public $search_indicators_result = [];
    public function updatedSearchIndicatorsInput()
    {
        $this->is_search = true;
    }

    /**
     * Selected Indicator
     */
    public $selected_indicator_ids = [];
    public $selected_indicator;
    public $tipo_meta;
    public $meta;
    public $cumulative;
    public $indicator_id;
    public function selected_indicator($id, $indicator_id, $name, $tipo_meta = null, $meta = null, $cumulative = null)
    {
        array_push($this->selected_indicator_ids, $id);
        $this->selected_indicator_id = $id;
        $this->selected_indicator = $name;
        $this->indicator_id = $id;
        $this->meta = $meta;

        if ($cumulative) {
            $this->cumulative = "Sim";
        } else {
            $this->cumulative = "Não";
        }
        if ($tipo_meta == 'decimal') {
            return $this->tipo_meta = "Numérica";
        }
        if ($tipo_meta == 'percent') {
            return $this->tipo_meta = "Percentual (%)";
        }
        $this->tipo_meta = "Descritiva";
    }

    public $old_value;
    public $old_quantity;
    public $selectedDespesa;
    public $selected_despesas_ids = [];
    public $id_despesa;
    public $issued_value;

    public function selected_despesa($id_despesa, $despesa, $old_value, $old_quantity)
    {
        array_push($this->selected_despesas_ids, $id_despesa);
        $this->selectedDespesa = $despesa;
        $this->issued_value = $old_value;
        $this->old_quantity = $old_quantity;
        $this->id_despesa = $id_despesa;
    }

    /**
     * Adcionar resport do indicador selecionado
     */
    public $indicator_achives;
    public $added_indicators = [];
    public function add_report_indicator()
    {
        $this->loadIssueIndicator($this->selected_issue_id, $this->selected_indicator_ids);
        $values = array(
            'id' => $this->indicator_id,
            'name' => $this->selected_indicator,
            'achived' => $this->indicator_achives
        );
        array_push($this->added_indicators, $values);
        $this->reset_fields();
    }

    public function remove_indicador_field($key = null, $id)
    {
        $this->selected_indicator_ids = array_diff($this->selected_indicator_ids, [$id]);
        $this->added_indicators = array_diff_key($this->added_indicators, array($key =>  true));
        $this->loadIssueIndicator($this->selected_issue_id, $this->selected_indicator_ids);
    }

    /**
     * Method add report financeiro - add despesa
     */
    public $added_despesas = [];
    public $quantity = null;
    public $price = null;

    public function add_report_financeiro()
    {
        $this->loadIssueDespesas($this->selected_issue_id, $this->selected_despesas_ids);
        $values = array(
            'despesa' => $this->selectedDespesa,
            'id_despesa' => $this->id_despesa,
            // 'quantity' => $this->quantity,
            // 'old_quantity' => $this->old_quantity,
            'price' => $this->price,
            'issued_value' => $this->issued_value,
        );

        array_push($this->added_despesas, $values);
        $this->reset_fields();
    }

    public function remove_despesa_field($key = null, $id)
    {
        $this->selected_despesas_ids = array_diff($this->selected_despesas_ids, [$id]);
        $this->added_despesas = array_diff_key($this->added_despesas, array($key =>  true));
        $this->loadIssueDespesas($this->selected_issue_id, $this->selected_despesas_ids);
    }

    /**
     * Load Issue Indicators
     */
    public $indicators = [];
    public function loadIssueIndicator($issue_id = null, $selected_indicator_ids = null)
    {
        if ($issue_id !== null) {
            $this->indicators = [];
            if ($selected_indicator_ids !== null) {
                return $this->indicators = \App\Models\IndicatorFieldsIssues::where('issue_id', $issue_id)->with('indicator_field')->whereNotIn('indicator_fields_id', $selected_indicator_ids)->get()->toArray();
            }
            return $this->indicators = \App\Models\IndicatorFieldsIssues::where('issue_id', $issue_id)->with('indicator_field')->get()->toArray();
            // dd($this->indicators);
        }
    }

    public $despesas = [];
    public function loadIssueDespesas($issue_id = null, $selected_budgets_ids = null)
    {
        if ($issue_id) {
            $this->despesas = [];
            if ($selected_budgets_ids !== null) {
                return $this->despesas = \App\Models\BudgetsValues::where('customized_id', $issue_id)
                    ->where('is_reported', false)
                    ->with('rubrica')
                    ->whereNotIn('id', $selected_budgets_ids)->get()->toArray();
            }
            return $this->despesas = \App\Models\BudgetsValues::where('customized_id', $issue_id)
                ->where('is_reported', false)
                ->with('rubrica')
                ->get()->toArray();
        }
    }

    public function reset_fields()
    {
        $this->indicator_achives = null;
        $this->selected_indicator = null;
        $this->selected_indicator_id = null;
        $this->quantity = null;
        $this->price = null;
        $this->selectedDespesa = null;
    }

    /**
     * Reset Search box
     */
    public function reset_search()
    {
        $this->is_search = false;
    }

    /**
     * add file forms
     */
    public function add_file_forms($index)
    {
        array_push($this->file_forms, ['index' => sizeof($this->file_forms) + 1]);
    }

    public function remove_file_forms($key, $index)
    {
        $this->file_forms = array_diff_key($this->file_forms, array($key => $index));
    }
}
