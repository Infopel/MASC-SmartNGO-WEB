<?php

namespace App\Http\Controllers\Helpers\Orcamento;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Events\SolicitacaoFundosNotificationEvent;

trait SolicitacaoDeFundosNotificationHelper
{

    private $emailTo;

    /**
     * Sends generic email notification
     *
     * @param \Illuminate\Database\Eloquent\Model $approvementFlow
     * @return void
     */
    public function SolicitacaoDeFundosEmailNotification(Model $approvementFlow): void
    {
        $this->emailTo = $approvementFlow->requestBy;

       
        $title = \time() . " - " . $approvementFlow->flow->description . ' - Solicitação de aprovação';

        $requestNum = "<a href='" . route('orcamento.projecto.details-solicitacao_fundos', [
            'project_identifier' => $approvementFlow->solicitacao->project->identifier,
            'requestNum' => $approvementFlow->num_requisicao
        ]) . "'>" .  $approvementFlow->num_requisicao . "</a>";

        $project = "<a href='" . route('projects.overview', ['project_identifier' => $approvementFlow->solicitacao->project->identifier]) . "' target='_blank'>" . $approvementFlow->solicitacao->project->name . "</a>";

        $start_on = ucwords(\Carbon\Carbon::parse($approvementFlow->solicitacao->data)->formatLocalized('%d %B %Y')) ?? '<i>Undefined Date</i>';


        $approvementFlow_goal = "<b> *" . $approvementFlow->solicitacao->objectivo . '* </b> Com o numero de requisição: ' . $requestNum;

        $email_content = "Solicitação de aprovação ( *" . $approvementFlow->flow->description . "* ) para o objectivo de: " . $approvementFlow_goal . " do projecto " . $project . "a decorrer (" . $start_on . "), criada por <i>" . $approvementFlow->requestBy->full_name . "</i>.";
        
        $email_to = $this->getUsersToSendEmailNotificationTo('userTo');
        
        // Mandar Email para o nivel anterior rever a aprovação
        try {
            event(new SolicitacaoFundosNotificationEvent(
                auth()->user(),
                $email_content,
                $title,
                $email_to
            ));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        
    }

    /**
     * Send generic email notification for unapproved flow
     *
     * @param Illuminate\Database\Eloquent\Model Model
     * @return void
     */
    public function RequestApprovalEmailNotification(Model $approvementFlow, User $user): void
    {
    }

    /**
     * Send generic email notification for unapproved flow
     *
     * @param Illuminate\Database\Eloquent\Model Model
     * @return void
     */
    public function ApprovalEmailNotification(Model $approvementFlow): void
    {
    }


    /**
     * Send generic email notification for unapproved flow
     *
     * @param \Illuminate\Database\Eloquent\Model $approvementFlow
     * @param string $reason_note
     * @return void
     */
    public function UnapprovalGenericEmailNotification(Model $approvementFlow, string $reason_note): void
    {
        try {
            $this->emailTo = $approvementFlow->solicitacao->requestBy;

            $trigger = "*" . $approvementFlow['flow']['description'] ?? "Undefined Step Description" . "*";

            $requestNum = "<a href='" . route('orcamento.projecto.details-solicitacao_fundos', [
                'project_identifier' => $approvementFlow->solicitacao->project->identifier,
                'requestNum' => $approvementFlow->num_requisicao
            ]) . "'>" .  $approvementFlow->num_requisicao . "</a>";


            $approvementFlow_goal = "<b> *" . $approvementFlow->solicitacao->objectivo . '* </b> Com o numero de requisição: ' . $requestNum;

            $project = "<a href='" . route('projects.overview', ['project_identifier' => $approvementFlow->solicitacao->project->identifier]) . "' target='_blank'>" . $approvementFlow->solicitacao->project->name . "</a>";

            $start_on = ucwords(\Carbon\Carbon::parse($approvementFlow->solicitacao->data)->formatLocalized('%d %B %Y')) ?? '<i>Undefined Date</i>';

            $replace = [':trigger', ':task', ':project', ':start_on', ':role_trigger'];

            if ($approvementFlow->flow->trigger === 'init') {
                $role_trigger = "<b> *" . $approvementFlow->flow->role->name . '* </b>';
            } else {
                $role_trigger = "<b> *" . $approvementFlow->flow->trigger_by->role->name . '* </b>';
            }


            $title = \time() . " - " . $approvementFlow->flow->trigger_by->description . ' - Foi Reprovada/o';
            $email_content = \str_replace($replace, [$trigger, $approvementFlow_goal, $project, $start_on, $role_trigger],   $approvementFlow->flow->unapproval_email_content) . '<h4 style="margin:0px !important;">Motivo Da Reprovação:</h4><p>' . $reason_note . '</p>';

            $email_to = $this->getUsersToSendEmailNotificationTo();

            // Mandar Email para o nivel anterior rever a aprovação
            event(new SolicitacaoFundosNotificationEvent(
                auth()->user(),
                $email_content,
                $title,
                $email_to
            ));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    /**
     * Get users to send email to
     *
     */
    private function getUsersToSendEmailNotificationTo($type = 'author')
    {
        switch ($type) {
            case 'userTos':
                return $users = [
                    $this->emailTo
                ];
                break;

            default:
                return $users = [
                    $this->emailTo
                ];
                break;
        }
    }
}
