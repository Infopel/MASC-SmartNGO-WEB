<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Budgets;
use App\Models\Projects;
use App\Models\BudgetsValues;
use App\Models\IssuesBudgets;
use App\Models\BudgetsDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Helpers\BudgetExceptionHelper;

class BudgetController extends Controller
{

    use BudgetExceptionHelper;

    /**
     * List of project budget
     */
    public function index(Projects $project_identifier)
    {
        $project = $project_identifier;
        return view('budget.index', compact('project'));
    }

    /**
     * From new buget expense
     */
    public function create(Projects $project_identifier)
    {
        $project = $project_identifier;
        return view('budget.new', compact('project'));
    }

    /**
     * Mostrar view de orcamento para issues
     */
    public function issue_budget(Issues $issue)
    {
        return view('budget.issue_budget', compact('issue'));
    }

    public function issue_new_budget(Issues $issue)
    {
        $project = $issue;
        $isEdit = false;
        $budget = null;
        return view('budget.new', compact('project', 'isEdit', 'budget'));
    }

    public function issue_edit_budget(Issues $issue, IssuesBudgets $budget)
    {
        $this->authorize('edit_orcamento', [Issues::class, $issue->project_id, $issue]);

        if ($issue->is_aproved) {
            return back()->with('warning', 'Não pode editar orçamento desta tarefa. Fluxo de solicitação ou tarefa aprovada!');
        }

        $isEdit = true;
        $project = $issue;
        return view('budget.new', compact('project', 'budget', 'isEdit'));
    }

    public function issue_update_budget(Issues $issue, IssuesBudgets $budget)
    {
        return 'test';
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(401);
        return $request;
        /**
         * Validar referencia
         */
        $this->validar_referencia_financeira();

        $request->validate([
            'orcamento.nota' => 'required',
            'orcamento.valor' => 'required',
            'orcamento.issued_at' => 'required',
            'orcamento.is_plan' => 'required|int|max:1',
            'orcamento.budget_to' => 'required',
            'orcamento.currency' => 'required',
        ], [
            'required' => __('lang.errors.messages.required')
        ], [
            'orcamento.nota' => "Descrição do orçamento",
            'orcamento.budget_to' => "Criar para",
            'orcamento.valor' => "Valor do orçamento",
            'orcamento.issued_at' => "Emissão do orçamento",
            'orcamento.currency' => "Moeda",
            'orcamento.is_plan' => "Tipo de orçamento (Planejado ou realizado)"
        ]);

        // Validar Identificador - para garantir que o request nao vai ser temperado
        $this->validar_indetificador_financeiro($request);

        // Pegar o parent (para onde aplicar a proposta) atraves do identificador
        $this->get_parent_and_route_from_identificador($request);

        // return $request;

        try {

            DB::beginTransaction();

            $novo_orcamento = new Budgets();
            $novo_orcamento->budget_tracker_id = $this->budget_tracker_id;
            $novo_orcamento->customized_type = $request->orcamento['budget_to'];
            $novo_orcamento->customized_id = $this->parent->id;
            $novo_orcamento->value = $request->orcamento['valor'];
            $novo_orcamento->is_plan = (int) $request->orcamento['is_plan'];
            $novo_orcamento->is_pending = 1;
            $novo_orcamento->is_iva = (int) $request->orcamento['use_iva'];
            $novo_orcamento->iva = $request->orcamento['iva'];
            $novo_orcamento->currency = $request->orcamento['currency'];
            $novo_orcamento->value_at_currency = $request->orcamento['valor_em_outra'];
            $novo_orcamento->author_id = auth()->user()->id;
            $novo_orcamento->created_on = now();
            $novo_orcamento->updated_on = now();
            $novo_orcamento->save(); // Save data into database

            $deltalhes_orcamento = new BudgetsDetails();
            $deltalhes_orcamento->budget_id = $novo_orcamento->id;
            $deltalhes_orcamento->note = $request->orcamento['nota'];
            $deltalhes_orcamento->attachments = null;
            $deltalhes_orcamento->created_on = now();
            $deltalhes_orcamento->save(); // Save data into database

            DB::commit();
            return redirect($this->route)->with('success', __('lang.notice_successful_create'));;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $request;
    }


    /**
     * Confirmacao de remove_permission
     */
    public function remove_confirmation(Budgets $budget, $customized_id)
    {
        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'orcamento' => $budget->tracker->name,
            // 'budget_to' => $
        ]);
    }

    /**
     * Deletar Proposta Financeira
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budgets  $budget
     * @return \Illuminate\Http\Response
     */
    public function deletar_proposta_financeira(Budgets $budget, $customized_id)
    {
        return $budget;
    }


    /**
     * Validar Proposta Financeira.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Budgets  $budget
     * @return \Illuminate\Http\Response
     */
    public function validar_proposta_financeira(Budgets $budget, $customized_id)
    {
        return $budget;
    }
}
