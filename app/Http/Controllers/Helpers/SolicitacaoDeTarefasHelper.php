<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Issues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\IssuesNotificationEvent;
use App\Models\ApprovementFlowModels;

trait SolicitacaoDeTarefasHelper
{

    public function validar_aprovacao_realizado(Issues $issue, Request $request)
    {
        if ($request->report == 'programatico') {
            return $this->processar_report_programatico($issue, $request);
        }

        if ($request->report == 'financeiro') {
            return $this->process_report_financeiro($issue, $request);
        }
    }


    /**
     * Processar aprovação report financeiro
     */
    protected function process_report_financeiro($issue, $request)
    {
        $is_report_stored = false;
        try {
            DB::beginTransaction();

            foreach ($issue->report_orcamento_realizado as $key => $report_orcamento_realizado) {
                $report_orcamento_realizado->is_approved = true;
                $report_orcamento_realizado->approved_by = auth()->user()->id;
                $report_orcamento_realizado->approved_on = now();
                $report_orcamento_realizado->updated_on = now();

                $report_orcamento_realizado->update();

                $orcamento = $issue->orcamento()->where('id', $report_orcamento_realizado->customized_id)
                    ->where('is_reported', true)
                    ->where('report_is_approved', false)
                    ->first();

                if ($orcamento) {

                    $orcamento->report_is_approved = true;
                    $orcamento->report_approved_by = auth()->user()->id;
                    $orcamento->report_approved_on = now();
                    $orcamento->updated_on = now();
                    $orcamento->update();

                    $is_report_stored = true;
                }
            }

            DB::commit();

            if ($is_report_stored) {

                $approvement = ApprovementFlowModels::where('customized_type', "Issue")
                    ->where('customized_id', $issue->id)
                    ->where('approvement_flow_id', 16)
                    ->where('is_approved', false)
                    ->first();

                $approvement->is_approved = true;
                $approvement->approved_on = now();
                $approvement->approved_by = auth()->user()->id;
                $approvement->update(); // Update data

                // Pegar o usuario que recebeu a solicitação de aprovação
                // aprovar
                $requested_user_approval = $approvement->user_approvals()
                    ->where('user_id', auth()->user()->id)
                    ->where('approvement_flow_models_id', $approvement->id)
                    ->first();

                if ($requested_user_approval) {
                    $requested_user_approval->is_approved = true;
                    $requested_user_approval->updated_on = now();
                    $requested_user_approval->update(); // Update data
                }

                $email_content = $this->email_content($issue);
                $title = time() . " - Vilidação Financeira do Reporte - Aprovado";
                event(new IssuesNotificationEvent($issue, auth()->user(), $email_content, $title, ['to_author']));

                return back()->with('success', 'Aprovação - ' . __('lang.notice_successful_create'));
            } else {
                return back()->with('warning', 'Essa acção ja foi excutada - ' . 'Sem dados para reportar');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Aprovação - Ocorreu um erro! Contacte o Administrador');
            // throw $th;
        }
    }

    /**
     * Processar aprovação report Programatica
     */
    protected function processar_report_programatico($issue, $request)
    {
        $is_report_stored = false;
        try {

            DB::beginTransaction();

            foreach ($issue->report_indicadores_realizado as $key => $report_indicador_realizado) {
                $report_indicador_realizado->is_approved = true;
                $report_indicador_realizado->approved_by = auth()->user()->id;
                $report_indicador_realizado->approved_on = now();
                $report_indicador_realizado->updated_on = now();

                $report_indicador_realizado->update();

                $indicador = $issue->indicators()->where('indicator_fields_id', $report_indicador_realizado->customized_id)
                    ->where('issue_id', $issue->id)
                    ->where('is_approved', false)
                    ->first();

                if ($indicador) {
                    $indicador->is_approved = true;
                    $indicador->approved_by = auth()->user()->id;
                    $indicador->approved_on = now();
                    $indicador->update();
                    $is_report_stored = true;
                }
            }

            DB::commit();

            if ($is_report_stored) {

                $approvement = ApprovementFlowModels::where('customized_type', "Issue")
                    ->where('customized_id', $issue->id)
                    ->where('approvement_flow_id', 15)
                    ->where('is_approved', false)
                    ->first();

                $approvement->is_approved = true;
                $approvement->approved_on = now();
                $approvement->approved_by = auth()->user()->id;
                $approvement->update(); // Update data

                // Pegar o usuario que recebeu a solicitação de aprovação
                // aprovar
                $requested_user_approval = $approvement->user_approvals()
                    ->where('user_id', auth()->user()->id)
                    ->where('approvement_flow_models_id', $approvement->id)
                    ->first();

                if ($requested_user_approval) {
                    $requested_user_approval->is_approved = true;
                    $requested_user_approval->updated_on = now();
                    $requested_user_approval->update(); // Update data
                }


                $email_content = $this->email_content($issue);
                $title = time() . " - Vilidação Programatica do Reporte - Aprovado";
                event(new IssuesNotificationEvent($issue, auth()->user(), $email_content, $title, ['to_author']));

                return back()->with('success', 'Aprovação - ' . __('lang.notice_successful_create'));
            } else {
                return back()->with('warning', 'Essa acção ja foi excutada - ' . 'Sem dados para reportar');
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Aprovação - Ocorreu um erro! Contacte o Administrador');
            throw $th;
        }
    }

    /**
     * Return email content
     */
    protected function email_content($issue)
    {
        $start_date = $issue->start_date ?? 'dd-mm-yyyy';

        $content = "Report dos dados realizados (Indicadores e Orçamento) foi aprovado na tarefa: <a href='" . route('issues.show', ['issue' => $issue->id]) . "'>" . $issue->subject . "</a> no projecto <a href='" . route('projects.overview', ['project_identifier' => $issue->project->identifier]) . "' target='_blank'>" . $issue->project->name . "</a> a decorrer (" . $start_date . "), foi criado por <i>" . auth()->user()->full_name . "</i>.</b> <a href='" . route('orcamento.projecto.solicitacao-fundos.show', ['project_identifier' => $issue->project->identifier, 'issue' => $issue->id]) . "' target='_blank'>clique aqui</a> para ver detalhes.";

        return $content;
    }
}
