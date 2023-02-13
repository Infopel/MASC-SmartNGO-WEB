<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Issues;
use App\Models\Projects;
use App\Models\TimeEntries;
use Illuminate\Http\Request;
use App\Models\BudgetsValues;
use App\Models\FlowReportTask;
use App\Models\ApprovementFlow;
use App\Models\AprovacaoTarefas;
use App\Models\TimeEntriesValues;
use Illuminate\Support\Facades\DB;
use App\Models\IndicatorFieldsIssues;
use App\Events\IssuesNotificationEvent;
use Illuminate\Validation\ValidationException;
use App\Events\ApprovementFlowNotificationEvent;
use App\Http\Controllers\Helpers\AttachmentsHelper;
use App\Http\Controllers\Helpers\ApprovementFlowHelper;
use App\Http\Controllers\Helpers\Reports\ReportManager;
use App\Http\Controllers\Helpers\SolicitacaoDeTarefasHelper;
use App\Http\Controllers\Features\SolicitacaoFundos\FlowApprovementManager;

class TimeEntriesController extends Controller
{
    use SolicitacaoDeTarefasHelper, AttachmentsHelper, ApprovementFlowHelper, ReportManager;

    public $flowApprovementManager;
    public $approvementFlow;

    public function __construct(
        FlowApprovementManager $flowApprovementManager,
        ApprovementFlow $approvementFlow
    ) {
        $this->flowApprovementManager = $flowApprovementManager;
        $this->approvementFlow = $approvementFlow;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Projects $project_identifier = null)
    {
        if ($project_identifier == null) {
            $timelogs = TimeEntries::with('user', 'issue', 'project')->whereHas('project')->whereHas('issue')->get();
        } else {
            $timelogs = TimeEntries::where('project_id', $project_identifier->id)->whereHas('project')->whereHas('issue')->with('user', 'issue')->get();
        }

        return view('timelog.index', compact('timelogs'));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Issues  $issues
     * @return \Illuminate\Http\Response
     */
    public function show_project(Projects $project_identifier)
    {
        $project = $project_identifier;
        return view('timelog.show');
    }


    public function show_issue(Issues $issue)
    {
        $issue['route'] = route('issues.show', ['issue' => $issue->id]);
        $timelog_activities = [];
        $despesasRealizadas = $issue->orcamento_tarefas()->where('is_reported', true)->where('is_reported', true)->get();

        $type = null;
        $customized_id = $issue->id;
        return view('timelog.show', compact('issue', 'timelog_activities', 'despesasRealizadas', 'type', 'customized_id'));
    }


    public function create(Issues $issue = null)
    {
        return view('timelog.new', compact('issue'));
    }

    public function store(Issues $issue, Request $request)
    {

        if ($request->has('indicator_store_action')) {

            $request->validate([
                'timelog.due_date' => 'required',
                'timelog.hours' => 'required',
                'timelog.comments' => 'required',
            ], [
                'required' => __('lang.errors.messages.required')
            ], [
                'timelog.start_date' => __('lang.field_start_date'),
                'timelog.due_date' => __('lang.field_due_date'),
                'timelog.hours' => __('lang.field_hours'),
                'timelog.comments' => __('lang.field_comments'),
            ]);

            try {
                DB::beginTransaction();

                $this->store_report_entrie($issue, $request);

                if ($request->has('attachments')) {
                    foreach ($request->attachments as $file) {
                        if ($file != null) {
                            $this->store_attachment($issue->id, $file['file'], "IssueReportIndicadores");
                        }
                    }
                }

                DB::commit();
                return redirect(route('time_entries.issues', ['issue' => $issue->id]))->with('success', __('lang.notice_successful_create'));
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
                return back()->with('error', __('Não foi possível gravar os dados! Encontramos um erro - Contacte o Administrador.'));
            }
        } else if ($request->has('action_finace_report')) {
            // Validadr request de despesas
            
            if (!$request->has('report_financeiro')) {
                throw ValidationException::withMessages(['report_financeiro' => __('Não foi possível gravar os dados! Nenhuma Despesa indicada.')]);
            }
            try {
                // Store report_financeiro
                /*$request->validate([
                    'timelog.due_date' => 'required',
                    'timelog.hours' => 'required',
                    'timelog.comments' => 'required',
                ], [
                    'required' => __('lang.errors.messages.required')
                ], [
                    'timelog.start_date' => __('lang.field_start_date'),
                    'timelog.due_date' => __('lang.field_due_date'),
                    'timelog.hours' => __('lang.field_hours'),
                    'timelog.comments' => __('lang.field_comments'),
                ]);*/

                DB::beginTransaction();

                $this->store_report_entrie($issue, $request, "tempStore", "TaskBudgetReport");

                // check if the is an attachments
                if ($request->has('attachments')) {
                    foreach ($request->attachments as $file) {
                        if ($file != null) {
                            $this->store_attachment($issue->id, $file['file'], "IssueReportBudget");
                        }
                    }
                }

                DB::commit();
                return redirect(route('time_entries.issues', ['issue' => $issue->id]))->with('success', __('lang.notice_successful_create'));
            } catch (\Throwable $th) {
                DB::rollback();
                return back()->with('error', __('Não foi possível gravar os dados! Encontramos um erro - Contacte o Administrador.'));
                throw $th;
            }
        } else {
            throw ValidationException::withMessages(['report_financeiro' => __('Undefined report action! Fatal Error. Contacte o Administrador')]);
        }
    }

    /**
     * Edit
     */
    public function edit(Issues $issue, TimeEntries $time_entrie)
    {
        $recourceType = request()->custom_type;
        $isEdit = true;
        return view('timelog.new', compact('issue', 'time_entrie', 'recourceType', 'isEdit'));
    }

    /**
     * update resource
     *
     * @param \App\Models\Issues $issue
     * @param \App\Models\TimeEntries $time_entrie
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function update(Issues $issue, TimeEntries $time_entrie, Request $request)
    {
        try {

            DB::beginTransaction();
            $time_entrie->hours = $request->timelog['hours'];
            $time_entrie->comments = $request->timelog['comments'];
            $time_entrie->activity_id = $request->timelog['activity_id'];
            $time_entrie->spent_on = date('Y-m-d', \strtotime($issue->start_date ?? date('Y-m-d')));
            $time_entrie->tyear = date('Y', \strtotime($issue->start_date ?? date('Y-m-d')));
            $time_entrie->tmonth = date('n', \strtotime($issue->start_date ?? date('Y-m-d')));
            $time_entrie->tweek = (int) date('W', \strtotime($issue->start_date ?? date('Y-m-d')));
            $time_entrie->start_date = $issue->start_date;
            $time_entrie->due_date = $request->timelog['due_date'];
            $time_entrie->updated_on = now();
            $time_entrie->update();

            $this->update_indicator_time_entries_values($request->indicator_achives, $issue->id, $time_entrie->id);

            DB::commit();
            return redirect(route('time_entries.issues', ['issue' => $issue->id]))->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();

            return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }

    /**
     * Display the specified resource
     */
    public function show(Issues $issue, $customized_id)
    {
        $issue['route'] = route('issues.show', ['issue' => $issue->id]);
        if (!request()->has('type')) {
            return back()->with('error', __('Fatal Error - Request Parameter Not meet the requirements. - Contacte o Administrador.'));
        }
        switch (request()->get('type')) {
            case 'II':
                $type = 'IssueIndicator';
                $timelog_activities = TimeEntriesValues::where('customized_id', $customized_id)
                    ->with('indicador', 'time_entry')
                    ->where('customized_type', $type)
                    ->orderby('created_on', 'desc')
                    ->get();
                break;
            case 'IB':
                $type = 'IssueBudget';
                $timelog_activities = TimeEntries::where('id', $customized_id)->first();
                break;
            default:
                return back()->with('error', __('Fatal Error - Request Parameter Value Not Defnined. - Contacte o Administrador.'));
                break;
        }
        $despesasRealizadas = $issue->orcamento_tarefas()->where('is_reported', true)->where('is_reported', true)->get();
        return view('timelog.show', compact('issue', 'timelog_activities', 'despesasRealizadas', 'type', 'customized_id'));
    }

    /**
     * Ask user grants to remove resource
     */
    public function remove_permission(TimeEntries $time_entry)
    {
        // $this->authorize('delete', $time_entry);
        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'actividade' => $time_entry->atividade->name,
            'time_entry_id' => $time_entry->id,
            'issue' => $time_entry['issue']['subject']
        ]);
    }

    /**
     *
     */
    public function destroy(TimeEntries $time_entry)
    {
        try {
            $time_entry->time_entries_values()->delete();
            $time_entry->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('error', "Ocorreu um erro ao remover o tempo gasto. RF007x0031");
        }
    }

    public function remove_time_entrie_values_permission(Issues $issue, TimeEntriesValues $time_entries_values)
    {
        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'time_entries_value_id' => $time_entries_values->id,
            'realizado' => $time_entries_values->value,
            'created_on' => $time_entries_values->created_on,
            'issue' => $issue['subject']
        ]);
    }

    public function remove_time_entrie_values(TimeEntriesValues $time_entries_values)
    {
        try {
            $time_entries_values->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('error', "Ocorreu um erro ao remover o tempo gasto. RF007x0031");
        }
    }


    public function request_approve(Issues $issue)
    {
        $is_report_stored = false;
        $reportProgramatico = false;
        $reportFinanceiro = false;
        $approvementFlow = collect([]);

        dd('request');

        try {
            $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($this->approvementFlow, "IssueReport", null);
            $approvementFlow = $hasApprovementFlowToTrigger->approvementFlow;
        } catch (\Throwable $th) {
            return back()->with('error', "Error Exception: </br>" . $th->getMessage());
        }

        try {
            DB::beginTransaction();
            // Indicadores
            foreach ($issue->indicators()->where('is_reported', true)->get() as $indicator) {
                if (!AprovacaoTarefas::where('issue_id', $issue->id)->where('customized_id', $indicator->indicator_fields_id)->where('customized_type', 'IssueIndicator')->where('is_approved', false)->first()) {
                    $time_entrie_value = TimeEntriesValues::where('customized_id', $indicator->indicator_fields_id)->where('customized_type', 'IssueIndicator')->first();
                    if ($time_entrie_value) {
                        $time_entrie_value->is_approved = true;
                        $time_entrie_value->approved_on = now();
                        $time_entrie_value->update();
                    }

                    $aprovacao_tarefas = new AprovacaoTarefas();
                    $aprovacao_tarefas->description = $approvementFlow->description;
                    $aprovacao_tarefas->nivel = $approvementFlow->role_id;
                    $aprovacao_tarefas->author_id = auth()->user()->id;
                    $aprovacao_tarefas->assignedTo = auth()->user()->id;
                    $aprovacao_tarefas->issue_id = $issue->id;
                    $aprovacao_tarefas->customized_id = $time_entrie_value->id;
                    $aprovacao_tarefas->customized_type = "IssueIndicator";
                    $aprovacao_tarefas->is_approved = false;
                    $aprovacao_tarefas->created_on = now();
                    $aprovacao_tarefas->updated_on = now();

                    $aprovacao_tarefas->save(); // Save data into database

                    $email_content = $this->email_content($issue);

                    $is_report_stored = true;
                    $reportProgramatico = true;
                }
            }

            // Orçamento Solicitado
            foreach ($issue->orcamento()->where('is_reported', true)->get() as $orcamento) {

                if (!AprovacaoTarefas::where('issue_id', $issue->id)->where('customized_id', $orcamento->id)->where('customized_type', 'IssueBudget')->first()) {
                    $time_entrie_value = TimeEntriesValues::where('customized_id', $orcamento->id)->where('customized_type', 'IssueBudget')->first();
                    if ($time_entrie_value) {
                        $time_entrie_value->is_approved = true;
                        $time_entrie_value->approved_on = now();
                        $time_entrie_value->update();
                    }
                    $aprovacao_tarefas = new AprovacaoTarefas();
                    $aprovacao_tarefas->description = $approvementFlow->description;
                    $aprovacao_tarefas->nivel = $approvementFlow->role_id;
                    $aprovacao_tarefas->author_id = auth()->user()->id;
                    $aprovacao_tarefas->issue_id = $issue->id;
                    $aprovacao_tarefas->customized_id = $orcamento->id;
                    $aprovacao_tarefas->customized_type = "IssueBudget";
                    $aprovacao_tarefas->is_approved = false;
                    $aprovacao_tarefas->created_on = now();
                    $aprovacao_tarefas->updated_on = now();

                    $aprovacao_tarefas->save(); // Save data into database

                    $is_report_stored = true;
                    $reportFinanceiro = true;
                }
            }

            if ($reportFinanceiro) {

                $this->flowApprovementManager->storeFiredApprovementFlow(
                    $hasApprovementFlowToTrigger->approvementFlow,
                    $issue->project,
                    $issue->id,
                    'IssueBudgetReport'
                );
            }

            if ($reportProgramatico) {

                $this->flowApprovementManager->storeFiredApprovementFlow(
                    $hasApprovementFlowToTrigger->approvementFlow,
                    $issue->project,
                    $issue->id,
                    'IssueReport'
                );
            }

            if ($is_report_stored) {
                return back()->with('success', 'Solicitação de aprovação do realizado da tarefa - ' . __('lang.notice_successful_create'));
            } else {
                return back()->with('warning', 'Solicitação de aprovação do realizado da tarefa - ' . 'Sem dados para reportar');
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return back()->with('error', "Ocorreu um erro. Contacte o Administrador");
        }
    }

    /**
     * Request report approvement
     *
     * @param \App\Models\Issue $issue
     * @param \App\Models\ApprovementFlow $approvementFlow
     * @param mixed $time_entries
     */
    public function request_report_approvement(Issues $issue, TimeEntries $time_entrie)
    {
        //dd($time_entrie);
        if (request()->has('reportType') && request()->get('reportType') == 'budgetReport') {
            try {
                $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($this->approvementFlow, "ValidacaodeReportedeActividades", "initial_flow");
                $approvementFlow = $hasApprovementFlowToTrigger->approvementFlow;
            } catch (\Throwable $th) {
                return back()->with('error', "There is no Approvement flow to be triggered");
            }

            $_usersToApprove = $this->getUserToAssingAproRequestTo($issue->project, $approvementFlow->role);
            $this->store_task_report_flow($_usersToApprove['user_id'], $approvementFlow, $time_entrie, "TaskBudgetReport");
        } else {
            try {
                $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($this->approvementFlow, "ValidacaodeReportedeActividades", 17);
                $approvementFlow = $hasApprovementFlowToTrigger->approvementFlow;
            } catch (\Throwable $th) {
                return back()->with('error', "Error Exception: </br>" . $th->getMessage());
            }

            $_usersToApprove = $this->getUserToAssingAproRequestTo($issue->project, $approvementFlow->role);
            $this->store_task_report_flow($_usersToApprove['user_id'], $approvementFlow, $time_entrie, "TaskReport");
        }

        $time_entrie->is_reported = true;
        $time_entrie->updated_on = now();
        $time_entrie->update(); // Update data

        return back()->with('success', "Solicitacao cadastrada com sucesso");
    }

    public function validar_aprovacao_realizado(Issues $issue, TimeEntries $time_entrie, FlowReportTask $flowReportTask)
    {

        try {
            DB::beginTransaction();

            $flowReportTask->approved_by = auth()->user()->id;
            $flowReportTask->is_approved = true;
            $flowReportTask->approved_on = now();
            $flowReportTask->updated_on = now();
            $flowReportTask->update(); // Update data
           
            

            if (!$flowReportTask->flow->is_flow_end) {
                $budget_report = TimeEntries::where('issue_id', $issue->id)->where('custom_type', 'TaskBudgetReport')->first();
                
                if ($flowReportTask->flow->id == 15 && $budget_report == null) {
                    $time_entrie->is_reported = true;
                    $time_entrie->is_approved = true;
                    $time_entrie->updated_on = now();
                    $time_entrie->update();

                } else {
                    if($budget_report != null && $flowReportTask->flow->id == 16){
                        $budget_report->is_reported = true;
                        $budget_report->is_approved = true;
                        $budget_report->updated_on = now();
                        $budget_report->update();
                    }
                    $hasApprovementFlowToTrigger = $this->flowApprovementManager->existApprovementToTrigger($flowReportTask->flow, "ValidacaodeReportedeActividades", \str_replace('flow_', '', $flowReportTask->flow->approved_goto));
                    $approvementFlow = $hasApprovementFlowToTrigger->approvementFlow;
                    $_usersToApprove = $this->getUserToAssingAproRequestTo($issue->project, $approvementFlow->role);
                    $this->store_task_report_flow($_usersToApprove['user_id'], $approvementFlow, $time_entrie, "TaskReport");
                }
            } else {
                $time_entrie->is_reported = true;
                $time_entrie->is_approved = true;
                $time_entrie->updated_on = now();
                $time_entrie->update(); // Update data
            }

            DB::commit();
            return back()->with('success', 'Validação gravada com sucesso.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro por favor contacte o administrador');
        }
    }

    /**
     * This Function will return the member project user id
     * that has a valid role to aprove this task
     *
     *
     *  Note that only the first result (User) will be returned.
     * @param \App\Models\Projects $project
     * @param \App\Models\Roles $role
     * @return collection
     * */
    public function getUserToAssingAproRequestTo(Projects $project, Roles $role)
    {
        try {
            $usersToSendRequestTo = $this->flowApprovementManager->getUsersToSendEmailNotificationTo($project, $role);
            return collect([
                'user_id' => $usersToSendRequestTo[0]->id
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->message());
        }
    }

    /**
     * Return email content
     */
    protected function email_content($issue)
    {
        $start_date = $issue->start_date ?? 'dd-mm-yyyy';

        return "Um reporte dos dados realizados (Indicadores e Orçamento) na tarefa: <a href='" . route('issues.show', ['issue' => $issue->id]) . "'>" . $issue->subject . "</a> no projecto <a href='" . route('projects.overview', ['project_identifier' => $issue->project->identifier]) . "' target='_blank'>" . $issue->project->name . "</a> a decorrer (" . $start_date . "), foi criado por <i>" . auth()->user()->full_name . "</i>. Para <b>Aprovação do realizado da tarefa</b> <a href='" . route('orcamento.projecto.solicitacao-fundos.show', ['project_identifier' => $issue->project->identifier, 'issue' => $issue->id]) . "' target='_blank'>clique aqui</a>.";
    }
}
