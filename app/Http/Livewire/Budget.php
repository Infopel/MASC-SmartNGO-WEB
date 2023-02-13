<?php

namespace App\Http\Livewire;

use App\Models\BudgetsValues;
use App\Models\IssuesBudgets;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Budgets;

class Budget extends Component
{

    public $budgets;
    public $budget_to;
    public $url_new_budget;
    public $issue;
    public $selected_budget = null;

    public function mount($budget_to, $url_new_budget)
    {
        $this->budget_to = $budget_to;
        $this->url_new_budget = $url_new_budget;

        $this->init($budget_to);
        $this->load_budget($this->budget_to);
    }

    public function render()
    {
        return view('livewire.budget');
    }

    public $issues_budgets = [];
    public function load_budget($budget_to)
    {
        $this->issues_budgets = \App\Models\IssuesBudgets::where('issue_id', $budget_to['id'])
            // ->where('customized_type', $budget_to['type'])
            ->with('budget_values', 'author', 'aprovado_por')
            ->get();

        // dd($this->issues_budgets);
    }

    public function init($budget_to)
    {
        if (isset($budget_to['project_id'])) {
            // $this->orcamentar_para = 'issue';
            $this->issue = \App\Models\Issues::where('id', $budget_to['id'])->first();
            $this->identifier = $budget_to['id'];
            return $this->budget_to = array(
                'id' => $budget_to['id'],
                'project_id' => $budget_to['project_id'],
                'name' => $budget_to['subject'],
                'is_aproved' => $budget_to['is_aproved'],
                'created_on' => $budget_to['created_on'],
                'type' => 'issue',
            );
        } else if (isset($budget_to['type'])) {
            // $this->orcamentar_para = 'project';
            $this->identifier = $budget_to['identifier'];
            return $this->budget_to = array(
                'id' => $budget_to['id'],
                'project_id' => $budget_to['id'],
                'name' => $budget_to['name'],
                'created_on' => $budget_to['created_on'],
                'type' => 'project',
                // 'url' => route('projects.overview', ['project_identifier' => $budget_to['indentifier']])
            );
        }
    }


    public function getBudget($id)
    {
        $this->selected_budget = \App\Models\IssuesBudgets::where('id', $id)
            ->where('issue_id', $this->budget_to['id'])
            // ->where('customized_type', $budget_to['type'])
            ->with('budget_values', 'author', 'aprovado_por')
            ->first();
    }

    public function close_details_budget()
    {
        $this->selected_budget = null;
    }

    public $note;
    public $despesas;
    public function aprovar_budget()
    {
        // dd($this->despesas['aprovar']);
        // return;
        try {
            DB::beginTransaction();
            $selected_budget_details = new \App\Models\BudgetsDetails();

            $this->selected_budget->aproved_by = auth()->user()->id;
            $this->selected_budget->aproved_on = now();
            $this->selected_budget->is_aproved = true;
            $this->selected_budget->update(); // Update
            $despesas = collect($this->despesas['aprovar'])->filter(function ($item) {
                return $item;
            });
            // dd($despesas);
            foreach ($despesas as $despesa => $state) {
                $aprovar_despesa = \App\Models\BudgetsValues::where('id', $despesa)->firstOrFail();
                $aprovar_despesa->is_aproved = $state;
                $aprovar_despesa->aproved_on = now();
                $aprovar_despesa->aproved_by = auth()->user()->id;
                $aprovar_despesa->updated_on = now();
                $aprovar_despesa->update(); // Update
            }

            $selected_budget_details->budget_id = $this->selected_budget->id;
            $selected_budget_details->note = $this->note;
            $selected_budget_details->created_on = now();
            $selected_budget_details->created_on = now();
            $selected_budget_details->save(); // Save

            DB::commit();
            $this->load_budget($this->budget_to);
            $this->close_details_budget();
            $this->nota = null;
            return $this->selected_budget = \App\Models\Budgets::where('id', $this->selected_budget->id)
                ->with('budget_tracker', 'author', 'aprovado_por', 'budget_details')
                ->first();
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
        }
        try {

            DB::beginTransaction();
            $selected_budget_details = new \App\Models\BudgetsDetails();

            $this->selected_budget->is_pending = 0;
            $this->selected_budget->validated_by = auth()->user()->id;
            $this->selected_budget->validated_on = now();
            $this->selected_budget->update(); // Update and Save data into database

            $selected_budget_details->budget_id = $this->selected_budget->id;
            $selected_budget_details->note = $this->note;
            $selected_budget_details->created_on = now();
            $selected_budget_details->created_on = now();
            $selected_budget_details->save(); // Save

            DB::commit();
            $this->load_budget($this->budget_to);
            $this->close_details_budget();
            $this->nota = null;
            return $this->selected_budget = \App\Models\Budgets::where('id', $this->selected_budget->id)
                ->with('budget_tracker', 'author', 'aprovado_por', 'budget_details')
                ->first();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
        }
    }

    public $enable_edit_on = [];
    public $issued_value;
    public function edit_budget_value($id, $is_submit = false)
    {
        $this->enable_delete_on = [];
        try {
            $budget_values = BudgetsValues::where('id', $id)->firstOrFail();
        } catch (\Throwable $th) {
            session()->flash('error', "Ocorreu um erro! A Rubruca do Orçamento não foi encontrada. Contacte o Admin");
        }

        if (!$is_submit) {
            $this->issued_value = $budget_values->issued_value;
            $this->enable_edit_on = array('id' => $id);
            return;
        } else {
            try {
                $budget_values->issued_value = $this->issued_value;
                $budget_values->updated_on = now();
                $budget_values->update();
                session()->flash('success', __('lang.notice_successful_update'));
                $this->enable_edit_on = [];
                return;
            } catch (\Throwable $th) {
                session()->flash('error', "Ocorreu um erro na atuaização de dados! RF007x0001. Contacte o Admin");
                return;
            }
        }
    }

    public $enable_delete_on = [];
    public function remove_budget_value($id, $is_submit = false)
    {
        $this->enable_edit_on = [];
        if (!$is_submit) {
            $this->enable_delete_on = array('id' => $id);
            return;
        } else {
            try {
                $budget_values = BudgetsValues::where('id', $id)->firstOrFail();
                $issues_budgets = \App\Models\IssuesBudgets::where('issue_id', $this->budget_to['id'])
                    ->where('id', $budget_values->issues_budget_id)
                    ->firstOrFail();
                if ($issues_budgets->budget_values->count() <= 1) {
                    $issues_budgets->delete();
                    $budget_values->delete();
                } else {
                    $budget_values->delete();
                }
                session()->flash('success', __('lang.notice_successful_delete'));
                $this->load_budget($this->budget_to);
            } catch (\Throwable $th) {
                // throw $th;
                session()->flash('error', "Ocorreu um erro! A Rubruca do Orçamento não foi encontrada. Contacte o Admin");
            }
        }
    }

    public function cancel_action()
    {
        $this->enable_edit_on = [];
        $this->enable_delete_on = [];
    }
}
