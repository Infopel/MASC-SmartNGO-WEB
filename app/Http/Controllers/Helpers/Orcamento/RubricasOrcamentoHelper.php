<?php

namespace App\Http\Controllers\Helpers\Orcamento;

use App\Models\CustomFields;
use App\Models\BudgetTrackers;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;
use App\Models\RubricasOrcamentoDespesas;
use App\Models\RubricasOrcamento as ModelRubricasOrcamento;

trait RubricasOrcamentoHelper
{
    public $_rubrica = null;
    public $is_associar_despesas = false;
    public $showModalAssociarOrcamento = false;
    public $input_despesa = null;

    public $selected_despesas_ids = [];
    public $selected_provincias_ids = [];
    public $despesasAssociadas = [];

    /**
     * Seleciona a rubrica do orcamento para associar as despeas
     */
    public function select_rubrica($id)
    {
        $this->is_associar_despesas = true;
        $this->tab = "associar_despesas";
        $this->_rubrica = ModelRubricasOrcamento::where('id', $id)->where('project_id', $this->project->id)->first();
        $this->despesas = [];
        $this->loadDespesasAssociadas();
    }


    public function showModalAssociarOrcamento()
    {
        $this->showModalAssociarOrcamento = true;
        $this->loadDespesas(); // LoadDespesas
        $this->loadProvincias();
    }
    public $provincias = [];
    public function loadProvincias()
    {
        $provincias = CustomFields::where('type', 'ProjectCustomField')->where('id', 30)->first();
        $this->provincias = Yaml::parse($provincias['possible_values'] ?? '') ?? [];
    }

    public $available_despesas_ids = [];
    public function loadDespesas()
    {
        if (sizeof($this->available_despesas_ids) > 0) {
            $this->despesas = BudgetTrackers::whereNotIn('id', $this->available_despesas_ids)->get();
        } else {
            $this->despesas = BudgetTrackers::get();
        }
    }

    public function loadDespesasAssociadas()
    {
        $this->despesasAssociadas = RubricasOrcamentoDespesas::with('budget_tracker')->where('rubrica_id', $this->_rubrica->id)
            ->where('project_id', $this->project->id)
            ->get();
        $this->available_despesas_ids =  array_column($this->despesasAssociadas->toArray(), 'budget_tracker_id');
    }

    public function associarDepesasRubrica()
    {
        try {
            // RubricasOrcamentoDespesas::where('rubrica_id', $this->_rubrica['id'])->where('project_id', $this->project->id)->delete();
            // foreach ($this->selected_provincias_ids as $provincia){
            foreach ($this->selected_despesas_ids as $id) {
                $rubricas_orcamento_despesas = new RubricasOrcamentoDespesas();
                $rubricas_orcamento_despesas->rubrica_id = $this->_rubrica['id'];
                $rubricas_orcamento_despesas->budget_tracker_id = $id;
                $rubricas_orcamento_despesas->project_id = $this->project->id;
                $rubricas_orcamento_despesas->provincia = null; //$provincia ??
                $rubricas_orcamento_despesas->created_on = now();
                $rubricas_orcamento_despesas->save(); // Save data into database
            }
            // }
            $this->closeModal();
            session()->flash('success', __('lang.notice_successful_create'));
            $this->loadDespesasAssociadas();
            $this->selected_despesas_ids = [];
            $this->selected_provincias_ids = [];
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Encontramos um error no processo de associar as depesas a rubrica");
        }
    }


    public function updatedInputDespesa()
    {
        $this->despesas = BudgetTrackers::where(function ($query) {
            $query->where('id', 'like', '%' . $this->input_despesa . "%")->orWhere('name', 'like', '%' . $this->input_despesa . "%");
        })->get();
    }

    public function remove_despesa_rubrica($id)
    {
        try {
            $depesa = RubricasOrcamentoDespesas::where('id', $id)->firstOrFail();
            $depesa->delete();
            $this->loadDespesasAssociadas();
            session()->flash("success", __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            // throw $th;
            session()->flash("error", "Encontramos um erro ao tentar remove a depesa associada a rubrica.");
        }
    }

    /**
     * Verificar se a despesa a ser removida tem orcamento associado
     */
    public function check_if_despesa_has_been_used()
    {
        try {
            //code...
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Retorna o orcamento total gasto em todas rubricas do projecto
     *
     * @param int $project_id Id do projecto dos Orcamentos
     * @param array $filterParams
     * @return double o valor total gasto
     */
    public function total_orcamento_gasto(int $project_id, array $filterParams)
    {
        try {
            $query = DB::table('rubricas_orcamento')
                ->select(DB::raw('sum(budgets_values.issued_value) as total'))
                ->join('budgets_values', 'budgets_values.budget_tracker_id', 'rubricas_orcamento.id')
                ->where('rubricas_orcamento.project_id', '=', $project_id)
                ->where(function ($query) use ($filterParams) {
                    if (!empty($filterParams && $filterParams['mes'])) {
                        $query->whereMonth('budgets_values.issued_at', $filterParams['mes']);
                    }
                    if (!empty($filterParams && $filterParams['ano'])) {
                        $query->whereYear('budgets_values.issued_at', $filterParams['ano']);
                    }
                })
                ->first();

            return $query->total ?? 0;
        } catch (\Throwable $th) {
            throw $th->getMessage();
        }
    }
}
