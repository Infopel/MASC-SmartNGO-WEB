<?php

namespace App\Http\Livewire;

use App\Models\BudgetsValues;
use App\Models\Issues;
use App\Models\TimeEntries as ModelTimeEntries;
use Livewire\Component;
use App\Models\TimeEntriesValues;

class TimeEntries extends Component
{

    public $issue;
    public $timelog_activities;
    public $despesasRealizadas;
    public $type;
    public $customized_id;
    public $indicators;

    public $indicator_value;
    public $enable_delete_on = [];

    public $isEdit = false;

    public function mount(Issues $issue, $timelog_activities, $despesasRealizadas, $type, $customized_id)
    {
        $this->issue = $issue;
        $this->timelog_activities = $timelog_activities;
        $this->despesasRealizadas = $despesasRealizadas;
        $this->type = $type;
        $this->customized_id = $customized_id;
        // $this->indicators = $issue->indicators;
    }

    public function render()
    {
        return view('livewire.time-entries');
    }

    public $enable_edit_on = [];

    public function editIndicador($timelog_id, $customized_id, $is_submit = false)
    {
        $this->enable_delete_on = [];
        try {
            $time_entrie_values = TimeEntriesValues::where('id', $timelog_id)->firstOrFail();
            $timeEntrie = ModelTimeEntries::where('id', $time_entrie_values->time_entry_id)->firstOrFail();
        } catch (\Throwable $th) {
            return session()->flash('error', "Ocorreu um erro! A Rubrica do Orçamento não foi encontrada. Contacte o Admin");
        }

        if (!$is_submit) {
            $this->enable_edit_on = array('id' => $timelog_id);
            $this->indicator_value = $time_entrie_values->value;
            return;
        } else {
            try {
                $timeEntrie->updated_on = now();
                $timeEntrie->update();
                // update time entries model

                // update time_entries values
                $time_entrie_values->value = $this->indicator_value;
                $time_entrie_values->update();

                session()->flash('success', __('lang.notice_successful_update'));
                $this->enable_edit_on = [];

                $this->load();
                return;
            } catch (\Throwable $th) {
                session()->flash('error', "Ocorreu um erro na atuaização de dados! RF007x0001. Contacte o Admin");
                return;
            }
        }
    }

    public $valor_realizado;
    public $enable_edit_budget_on = [];
    public $enable_delete_budget_on = [];
    public function editBudgetValue($id, $is_submit = false)
    {
        $this->enable_delete_budget_on = [];
        try {
            $budget_values = TimeEntriesValues::where('id', $id)->firstOrFail();
        } catch (\Throwable $th) {
            return session()->flash('error', "Ocorreu um erro! A Rubrica do Orçamento não foi encontrada. Contacte o Admin");
        }

        if (!$is_submit) {
            $this->enable_edit_budget_on = array('id' => $id);
            $this->valor_realizado = $budget_values->value;
            return;
        } else {
            try {
                $budget_values->value = $this->valor_realizado;
                $budget_values->updated_on = now();
                $budget_values->update();

                $budget_values->rubrica->valor_realizado = $this->valor_realizado;
                $budget_values->rubrica->updated_on = now();
                $budget_values->rubrica->update();

                session()->flash('success', __('lang.notice_successful_update'));
                $this->enable_edit_budget_on = [];
                return;
            } catch (\Throwable $th) {
                throw $th;
                session()->flash('error', "Ocorreu um erro na atuaização de dados! RF007x0001. Contacte o Admin");
                return;
            }
        }
    }

    public function deleteBudgetValue($id, $is_submit = false)
    {
        $this->enable_edit_budget_on = [];
        try {
            $budget_values = TimeEntriesValues::where('id', $id)->firstOrFail();
        } catch (\Throwable $th) {
            return session()->flash('error', "Ocorreu um erro! A Rubrica do Orçamento não foi encontrada. Contacte o Admin");
        }

        if (!$is_submit) {
            $this->enable_delete_budget_on = array('id' => $id);
            $this->valor_realizado = $budget_values->valor_realizado;
            return;
        } else {
            try {

                $budget_values->rubrica->is_reported = 0;
                $budget_values->rubrica->reported_by = null;
                $budget_values->rubrica->reported_at = null;
                $budget_values->rubrica->valor_realizado = 0;
                $budget_values->rubrica->updated_on = now();
                $budget_values->rubrica->update();

                $budget_values->delete();

                session()->flash('success', __('lang.notice_successful_update'));
                $this->enable_delete_budget_on = [];
                return;
            } catch (\Throwable $th) {
                session()->flash('error', "Ocorreu um erro na atuaização de dados! RF007x0001. Contacte o Admin");
                return;
            }
        }
    }

    public function load()
    {
        if (!request()->has('type')) {
            return back()->with('error', __('Fatal Error - Request Parameter Not meet the requirements. - Contacte o Administrador.'));
        }

        switch (request()->get('type')) {
            case 'II':
                $type = 'IssueIndicator';
                $this->timelog_activities = TimeEntriesValues::where('customized_id', $this->customized_id)
                    ->with('indicator_issue_values', 'time_entry')
                    ->where('customized_type', $type)
                    ->orderby('created_on', 'desc')
                    ->get();
                // return $timelog_activities;
                break;
            case 'IB':
                $type = 'IssueBudget';
                $this->timelog_activities = TimeEntriesValues::where('customized_id', $this->customized_id)
                    ->with('indicator_issue_values', 'time_entry')
                    ->where('customized_type', $type)
                    ->orderby('created_on', 'desc')
                    ->get();
                break;
            default:
                return back()->with('error', __('Fatal Error - Request Parameter Value Not Defnined. - Contacte o Administrador.'));
                break;
        }

        // return $timelog_activities;
        $this->despesasRealizadas = $this->issue->orcamento_tarefas()->where('is_reported', true)->where('is_reported', true)->get();
        // $this->indicators = $this->issue->indicators;
    }

    public function cancel_action()
    {
        $this->enable_edit_on = [];
        $this->enable_delete_on = [];
        $this->enable_delete_budget_on = [];
        $this->enable_edit_budget_on = [];
    }

    public function remove_indicador_value($id, $is_submit = false)
    {
    }
}
