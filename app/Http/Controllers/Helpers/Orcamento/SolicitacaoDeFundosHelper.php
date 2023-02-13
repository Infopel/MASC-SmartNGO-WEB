<?php

namespace App\Http\Controllers\Helpers\Orcamento;

use App\Models\Issues;
use App\Models\Journals;
use App\Models\Projects;
use App\Models\JournalDetails;
use App\Models\ApprovementFLow;
use App\Models\AprovacaoFundos;
use Illuminate\Http\Request;
use App\Models\ApprovementFlowModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ReprovacaoSolicitacaoFundos;
use Illuminate\Support\Facades\Mail;
use App\Events\IssuesNotificationEvent;
use App\Events\ApprovementFlowNotificationEvent;
use App\Http\Controllers\Helpers\ApprovementFlowHelper;

trait SolicitacaoDeFundosHelper
{

    use ApprovementFlowHelper;

    public function solicitacao_index(Projects $project_identifier, Issues $issue)
    {
        $project = $project_identifier;
        return view('projects.orcamento.solicitacao.index', compact('project'));
    }


    /**
     * Iniciar a solicitação e aprovacao
     */
    public function solicitacao_issue_init_request(Projects $project_identifier, Issues $issue)
    {

        // check if task is init on approvement flow model
        // this will return ApprovementFlowModels instance
        $getIssueOnApprovalFlowModal = ApprovementFlowModels::where('customized_id', $issue->id)
            ->where('customized_type', "Issue")
            ->get()->count();

        if ($getIssueOnApprovalFlowModal === 0) {

            try {
                DB::beginTransaction();
                $StoreTriggeredApprovementFlow = (object) [];
                $getTigger = $this->ExistApprovementTriggerOnNewResource('Issue');
                if ($getTigger->status) {
                    $StoreTriggeredApprovementFlow = $this->StoreTriggeredApprovementFlow($getTigger->trigger, $issue);
                }

                $start_date = $issue->start_date ?? 'dd-mm-yyyy';

                $content = "Foi criada uma tarefa: <a href='" . route('issues.show', ['issue' => $issue->id]) . "'>" . $issue->subject . "</a> no projecto <a href='" . route('projects.overview', ['project_identifier' => $issue->project->identifier]) . "' target='_blank'>" . $issue->project->name . "</a> a decorrer (" . $start_date . "), criada por <i>" . $issue->author->full_name . "</i>. Para *Revisão da Solicitacao da aprovação* - <a href='" . route('orcamento.projecto.solicitacao-fundos.show', ['project_identifier' => $issue->project->identifier, 'issue' => $issue->id]) . "' target='_blank'>clique aqui</a>.";

                if ($StoreTriggeredApprovementFlow !== []) {
                    event(new ApprovementFlowNotificationEvent(
                        auth()->user(),
                        $issue,
                        $StoreTriggeredApprovementFlow,
                        $content
                    ));
                }

                DB::commit();
                return back()->with('success', __('Fluxo de aprovação inicializado com com sucesso!'));
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
        }
    }
    /**
     * Processar a solicitação de aprovação
     */
    public function solicitacao_validation(Projects $project_identifier, Issues $issue, ApprovementFlowModels $approvement, Request $request)
    {

        // Iniciar a aprovação
        // Primeiro aprovar o passo
        try {

            DB::beginTransaction();
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

            if ($issue->orcamento->sum('issued_value') < 50000 && $approvement->approvement_flow->id === 7) {
                $approvementFlow = ApprovementFlow::where('type', "Issue")
                    ->where('id', 8)
                    ->first();
                $existNextApprovement = $this->ExistApprovementToTrigger("Issue", $approvementFlow);
            } else {
                $existNextApprovement = $this->ExistApprovementToTrigger("Issue", $approvement->approvement_flow);
            }




            if ($existNextApprovement->status) {
                // Verificar se o request de aprovação ja foi gravado na base de dados
                $this->RequestedFlowHasBeenStored($existNextApprovement->approvement_flow, $issue);

                $StoreTriggeredApprovementFlow = $this->StoreTriggeredApprovementFlow(
                    $existNextApprovement->approvement_flow,
                    $issue
                );

                event(new ApprovementFlowNotificationEvent(
                    auth()->user(),
                    $issue,
                    $StoreTriggeredApprovementFlow
                ));
            } else {
                // Caso essa seja a Ultima fase disponivel mandamos um email sem criar um novo
                // requisito de aprovação
                $this->email_notification($issue, $approvement);
            }

            $this->approve_issue($issue, $approvement);

            DB::commit();
            return back()->with('success', __('Sua aprovação foi registada com sucesso!'));
        } catch (\Throwable $th) {
            DB::rollback();
            if ($th->getCode() == 10701) {
                return back()->with('error', $th->getMessage());
            };
            return back()->with('error', __('Ocorreu um erro na aprovação! Contacte o Administrador'));
            throw $th->getMessage();
        }
    }


    /**
     * Aprovar a tarefa caso seja o ultimo passo aprovado
     */
    protected function approve_issue(Issues $issue, ApprovementFlowModels $approvement)
    {
        if ($approvement->approvement_flow->is_flow_end) {
            $issue->is_aproved = true;
            $issue->aproved_by = auth()->user()->id;
            $issue->aproved_on = now();
            $issue->updated_on = now();

            $issue->update(); // Update data

            // Chamar a func de desembolso de fundos
            $this->processar_desembolso($issue);
        }
    }

    /**
     * Solicitar aprovação da fase
     */
    public function re_validation(Projects $project_identifier, Issues $issue, ApprovementFlowModels $approvement, Request $request)
    {
        try {
            DB::beginTransaction();
            $approvement->is_rejected = false;
            $approvement->updated_on = now();
            $approvement->update(); // Update data

            $this->ReapprovalEmailNotification($issue, $approvement); // EmailNotification data

            DB::commit();
            return back()->with('success', 'Requisição de validação registada com sucesso');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro na requisição de validação.');
            throw $th;
        }
    }


    /**
     * Processar o desembolso de fundos para a tarefa
     *
     */
    protected function processar_desembolso(Issues $issue)
    {
        foreach ($issue->orcamento as $orcamento) {

            if ($orcamento['rubrica'] !== NULL) {

                $rubrica = $orcamento->rubrica;
                $orcamento_atual = $rubrica['orcamento'] ?? 0;
                $novo_orcamento = $orcamento_atual - $orcamento['issued_value'];

                // Atualzar Orçamento
                $rubrica['orcamento'] = $novo_orcamento;
                $rubrica->updated_on = now();
                $rubrica->update(); // Update data

                // Orcamento Journals
                $journal = new Journals();
                $journal->journalized_id = $orcamento['rubrica']['id'];
                $journal->journalized_type = "Issue_Budget";
                $journal->user_id = auth()->user()->id;;
                $journal->notes = "Desembolso de fundos";
                $journal->created_on = now();
                $journal->private_notes = false;
                $journal->save(); // Save data into database

                // Orcameto - JournalDetails
                $journal_details = new JournalDetails();
                $journal_details->journal_id = $journal->id;
                $journal_details->property = "budget";
                $journal_details->prop_key = 'budget';
                $journal_details->old_value = $orcamento_atual;
                $journal_details->value = $novo_orcamento;
                $journal_details->save(); // Save data into database
            }
        }
    }


    /**
     * Reprovar fases no processo de solicitação de fundos
     */
    public function solicitacao_reprovar(Projects $project_identifier, Issues $issue, ApprovementFlowModels $approvement, Request $request)
    {

        try {
            DB::beginTransaction();
            // pegar a fase a reprovar
            $approvement->is_rejected = true;
            $approvement->rejected_by = auth()->user()->id;
            $approvement->rejected_on = now();
            $approvement->updated_on = now();
            $approvement->update(); // Update data

            // if($approvement->approvement_flow->trigger_by !== null){
            //     $back_step = ApprovementFlowModels::where('customized_id', $issue->id)
            //         ->where('approvement_flow_id', $approvement->approvement_flow->trigger_by->id)
            //         ->first();

            //     $back_step->is_rejected = true;
            //     $back_step->rejected_by = auth()->user()->id;
            //     $back_step->rejected_on = now();
            //     $back_step->updated_on = now();
            //     $back_step->update(); // Update data
            // }

            // Reprovacoes
            $reprovacao = new ReprovacaoSolicitacaoFundos();
            $reprovacao->nivel = $approvement->approvement_flow->id;
            $reprovacao->issue_id = $approvement->customized_id;
            $reprovacao->aprovacao_id = $approvement->id;
            $reprovacao->notes = $request->reprovacao['notes'];
            $reprovacao->categoria = $approvement->approvement_flow->role->name;
            $reprovacao->action_by = auth()->user()->id;
            $reprovacao->created_on = now();

            $reprovacao->save(); // Save data into database

            // send with unapproval message
            $this->UnapprovalEmailNotification($issue, $approvement, $request->reprovacao['notes']);

            DB::commit();
            return back()->with('warning', "Reprovação cadastrada com sucesso!\nEnviamos um email a notificar o usuario sobre a reprovação.");
        } catch (Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro na reprovação da fase: X na solicitacao de fundos');
        }
    }



    /**
     * Email de notificao para sucesso na aprovacao
     */
    protected function email_notification($resource, $approvement)
    {

        $trigger = "*" . $approvement->approvement_flow->description ?? "New Issue" . "*";
        $issue = "<a href='" . route('issues.show', ['issue' => $resource->id]) . "'>" . $resource->subject . "</a>";
        $project = "<a href='" . route('projects.overview', ['project_identifier' => $resource->project->identifier]) . "' target='_blank'>" . $resource->project->name . "</a>";

        $start_on = ucwords(\Carbon\Carbon::parse($resource->start_date)->formatLocalized('%d %B %Y')) ?? '*Undefined Date*';

        $replace = [':trigger', ':issue', ':project', ':start_on', ':role_trigger'];

        if ($approvement->approvement_flow->trigger === 'NewIssue' || $approvement->approvement_flow->trigger === 'Report') {

            $role_trigger = "*" . $approvement->approvement_flow->role->name . '*';

            $title = \time() . " - " . $approvement->approvement_flow->description;
            $email_content = \str_replace($replace, [$trigger, $issue, $project, $start_on, $role_trigger],   $approvement->approvement_flow->email_content);

            // Mandar Email para o author da tarefa
            event(new IssuesNotificationEvent(
                $resource,
                auth()->user(),
                $email_content,
                $title,
                ['to_author']
            ));
        } else {
            $role_trigger = "*" . $approvement->approvement_flow->trigger_by->role->name . '*';

            $title = \time() . " - " . $approvement->approvement_flow->trigger_by->description;
            $email_content = \str_replace($replace, [$trigger, $issue, $project, $start_on, $role_trigger],   $approvement->approvement_flow->email_content);

            // Mandar Email para o nivel anterior rever a aprovação
            event(new IssuesNotificationEvent(
                $resource,
                auth()->user(),
                $email_content,
                $title,
                ['to_author'],
                $approvement->approvement_flow->trigger_by->role,
                true
            ));
        }
    }


    /**
     * Sending Email when user reject approvation
     */
    protected function UnapprovalEmailNotification($resource, ApprovementFlowModels $approvement, $unapprovalMessage)
    {

        $trigger = "*" . $approvement->approvement_flow->description ?? "New Issue" . "*";
        $issue = "<a href='" . route('issues.show', ['issue' => $resource->id]) . "'>" . $resource->subject . "</a>";
        $project = "<a href='" . route('projects.overview', ['project_identifier' => $resource->project->identifier]) . "' target='_blank'>" . $resource->project->name . "</a>";

        $start_on = ucwords(\Carbon\Carbon::parse($resource->start_date)->formatLocalized('%d %B %Y')) ?? '<i>Undefined Date</i>';

        $replace = [':trigger', ':issue', ':project', ':start_on', ':role_trigger'];

        if ($approvement->approvement_flow->trigger === 'NewIssue') {

            $role_trigger = "*" . $approvement->approvement_flow->role->name . '*';

            $title = \time() . " - " . $approvement->approvement_flow->description . ' - Foi Reprovada/o';
            $email_content = \str_replace($replace, [$trigger, $issue, $project, $start_on, $role_trigger],   $approvement->approvement_flow->unapproval_email_content) . '<p></h5>Motivo Da Reprovação:<h5><span>' . $unapprovalMessage . '</span></p>';

            // Mandar Email para o author da tarefa
            event(new IssuesNotificationEvent(
                $resource,
                auth()->user(),
                $email_content,
                $title,
                ['to_author']
            ));
        } else {
            $role_trigger = "*" . $approvement->approvement_flow->trigger_by->role->name . '*';

            $title = \time() . " - " . $approvement->approvement_flow->trigger_by->description . ' - Foi Reprovada/o';
            $email_content = \str_replace($replace, [$trigger, $issue, $project, $start_on, $role_trigger],   $approvement->approvement_flow->unapproval_email_content) . '<p></h5>Motivo Da Reprovação:<h5><span>' . $unapprovalMessage . '</span></p>';

            // Mandar Email para o nivel anterior rever a aprovação
            event(new IssuesNotificationEvent(
                $resource,
                auth()->user(),
                $email_content,
                $title,
                ['to_author'],
                $approvement->approvement_flow->trigger_by->role,
                true
            ));
        }
    }

    /**
     * Sendign Reapproval email
     */
    protected function ReapprovalEmailNotification($resource, ApprovementFlowModels $approvement)
    {

        $trigger = "*" . $approvement->approvement_flow->description ?? "New Issue" . "*";
        $issue = "<a href='" . route('issues.show', ['issue' => $resource->id]) . "'>" . $resource->subject . "</a>";
        $project = "<a href='" . route('projects.overview', ['project_identifier' => $resource->project->identifier]) . "' target='_blank'>" . $resource->project->name . "</a>";

        $start_on = ucwords(\Carbon\Carbon::parse($resource->start_date)->formatLocalized('%d %B %Y')) ?? '<i>Undefined Date</i>';

        $title = \time() . " - " . $approvement->approvement_flow->description . ' - Solicitação de aprovação';

        $email_content = "Solicitação de aprovação (*" . $approvement->approvement_flow->description . "*) na tarefa: " . $issue . " do projecto " . $project . "a decorrer (" . $start_on . "), criada por <i>" . $resource->author->full_name . "</i>.";

        // Mandar Email para o author da tarefa
        event(new IssuesNotificationEvent(
            $resource,
            auth()->user(),
            $email_content,
            $title,
            ['default_role'],
            $approvement->approvement_flow->role,
            true
        ));
    }



    public function store_Necessidades()
    {
    }
}
