<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\BudgetsValues;
use App\Models\IssuesBudgets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\AttachmentsHelper;
use App\Http\Controllers\Helpers\BudgetExceptionHelper;

class BudgetsValuesController extends Controller
{
    use BudgetExceptionHelper, AttachmentsHelper;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        /**
         * Validar referencia
         */
        $this->validar_referencia_financeira();

        // Validar Identificador - para garantir que o request nao vai ser temperado
        $this->validar_indetificador_financeiro($request);

        // Pegar o parent (para onde aplicar a proposta) atraves do identificador
        $this->get_parent_and_route_from_identificador($request);

        $this->validar_request_orcamento($request);

        $request->validate([
            // 'orcamento.partner' => 'required',
            'orcamento.issued_at' => 'required',
        ], [
            'required' => __('lang.errors.messages.required')
        ], [
            // 'orcamento.partner' => __('lang.label_partner'),
            'orcamento.issued_at' => __('Emitido em')
        ]);

        $variavel = array_keys($request->budget_issue_custom_field_values ?? []) ?? null;
        $variavel = $variavel ? $variavel[0] ?? 'null' : null;

        try {

            DB::beginTransaction();
            $issue_budget = new IssuesBudgets();

            $issue_budget->issue_id = $request->identifier;
            $issue_budget->author_id = auth()->user()->id;
            $issue_budget->notes = $request->budget_notes;
            $issue_budget->partner_id = $request->orcamento['partner'] ?? null;
            $issue_budget->project_id = $this->parent->project->id;
            $issue_budget->created_on = now();
            $issue_budget->updated_on = now();
            $issue_budget->save(); // Save data into database

            foreach ($request->budget as $key => $budget) {

                try {
                    $project = Projects::select('id', 'name')->where('identifier', $budget['project_id'])->firstOrFail();
                } catch (\Throwable $th) {
                    throw $th;
                    return redirect($this->route)->with('error', 'Ocorreu um erro. O projecto selecionado nao foi reconhecido.');;
                }

                $novo_orcamento = new BudgetsValues();
                $novo_orcamento->issues_budget_id = $issue_budget->id;
                $novo_orcamento->author_id = Auth::user()->id;
                $novo_orcamento->budget_tracker_id = $budget['id']; // here we are using rubricas now
                $novo_orcamento->customized_type = $request->orcamento['budget_to'];
                $novo_orcamento->customized_id = $this->parent->id;;
                $novo_orcamento->quantidade = 0; // $budget['quantity']
                $novo_orcamento->valor_base = 0;
                $novo_orcamento->issued_value = $budget['value'];
                $novo_orcamento->variavel = $variavel;
                $novo_orcamento->valor_variavel = $request->budget_issue_custom_field_values[$variavel] ?? '';
                $novo_orcamento->issued_at = $request->orcamento['issued_at'];
                $novo_orcamento->partner_id = $request->orcamento['partner'] ?? null;
                $novo_orcamento->project_id = $project->id;
                $novo_orcamento->created_on = now();
                $novo_orcamento->updated_on = now();

                $novo_orcamento->save(); // Save data into database
            }

            // Gravar documentos de suporte de solicitação de fundos
            if ($request->has('attachments')) {
                foreach ($request->attachments as $file) {
                    if ($file != null) {
                        $this->store_attachment($request->identifier, $file['file'], "IssueBudgetsRequest");
                    }
                }
            }

            DB::commit();
            return redirect($this->route)->with('success', __('lang.notice_successful_create'));;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return redirect($this->route)->with('error', 'Ocorreu um erro desconhecido! RF0292b - Orçamento');;
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetsValues  $budgetsValues
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issues $issue, IssuesBudgets $budget)
    {
        if ($issue->is_aproved) {
            return back()->with('warning', 'This action is unauthorized! Issue is already approved');
        }

        $budget_issue = $budget;
        /**
         * Validar referencia
         */
        $this->validar_referencia_financeira();

        // Validar Identificador - para garantir que o request nao vai ser temperado
        $this->validar_indetificador_financeiro($request);

        // Pegar o parent (para onde aplicar a proposta) atraves do identificador
        $this->get_parent_and_route_from_identificador($request);

        $this->validar_request_orcamento($request);

        $request->validate([
            // 'orcamento.partner' => 'required',
            'orcamento.issued_at' => 'required',
        ], [
            'required' => __('lang.errors.messages.required')
        ], [
            // 'orcamento.partner' => __('lang.label_partner'),
            'orcamento.issued_at' => __('Emitido em')
        ]);

        $variavel = array_keys($request->budget_issue_custom_field_values ?? []) ?? null;
        $variavel = $variavel ? $variavel[0] ?? 'null' : null;

        try {

            DB::beginTransaction();

            $budget_issue->notes = $request->budget_notes;
            $budget_issue->updated_on = now();
            $budget_issue->update(); // Save data into database

            foreach ($request->budget as $key => $budget) {

                // check is exist
                $get_issued_value = BudgetsValues::where('issues_budget_id', $budget_issue->id)
                    ->where('budget_tracker_id', $budget['id'])
                    ->where('customized_id', $issue->id)
                    ->where('customized_type', 'issue')
                    ->where('issued_at', $request->orcamento['issued_at'])
                    ->first();

                if ($get_issued_value) {
                    $get_issued_value->issued_value = $budget['value'];
                    $get_issued_value->variavel = $variavel;
                    $get_issued_value->valor_variavel = $request->budget_issue_custom_field_values[$variavel];
                    $get_issued_value->issued_at = $request->orcamento['issued_at'];
                    $get_issued_value->updated_on = now();

                    $get_issued_value->update(); // Update data into database
                } else {
                    // create new
                    $novo_orcamento = new BudgetsValues();
                    $novo_orcamento->issues_budget_id = $budget_issue->id;
                    $novo_orcamento->author_id = Auth::user()->id;
                    $novo_orcamento->budget_tracker_id = $budget['id']; // here we are using rubricas now
                    $novo_orcamento->customized_type = $request->orcamento['budget_to'];
                    $novo_orcamento->customized_id = $this->parent->id;
                    $novo_orcamento->quantidade = 0; // $budget['quantity']
                    $novo_orcamento->valor_base = 0;
                    $novo_orcamento->issued_value = $budget['value'];
                    $novo_orcamento->variavel = $variavel;
                    $novo_orcamento->valor_variavel = $request->budget_issue_custom_field_values[$variavel];
                    $novo_orcamento->issued_at = $request->orcamento['issued_at'];
                    $novo_orcamento->partner_id = $request->orcamento['partner'] ?? null;
                    $novo_orcamento->created_on = now();
                    $novo_orcamento->updated_on = now();

                    $novo_orcamento->save(); // Save data into database

                }
            }

            // Gravar documentos de suporte de solicitação de fundos
            if ($request->has('attachments')) {
                foreach ($request->attachments as $file) {
                    if ($file != null) {
                        $this->store_attachment($issue->id, $file['file'], "IssueBudgetsRequest");
                    }
                }
            }

            DB::commit();
            return redirect($this->route)->with('success', __('lang.notice_successful_create'));;
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect($this->route)->with('error', 'Ocorreu um erro desconhecido! RF0292b - Orçamento');;
            throw $th;
        }
    }



    /**
     * Store Attachments that belongsTo specified resource on storage.
     *
     * @param  \App\Models\BudgetsValues  $budgetsValues
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetsValues $budgetsValues)
    {
        //
    }
}
