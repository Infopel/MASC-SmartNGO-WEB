<?php

namespace App\Http\Controllers\Features\SolicitacaoFundos;

use Exception;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\ApprovementFlow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ApprovementFlowModels;
use App\Models\FlowSolicitacaoFundos;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Contracts\ISolicitacaoFundos;

class FlowApprovementManager implements ISolicitacaoFundos
{
    public $flowSolicitacaoFundos;
    public $approvementFlow;
    public function __construct(FlowSolicitacaoFundos $flowSolicitacaoFundos, ApprovementFlow $approvementFlow)
    {
        $this->flowSolicitacaoFundos = $flowSolicitacaoFundos;
        $this->approvementFlow = $approvementFlow;
    }

    /**
     * Validar request de dados
     *
     * @param Request $request
     */
    public function validateData(Request $request): void
    {
        $request->validate([
            'requestFundos.objectivo' => ['required', 'string', 'min:20'],
            'requestFundos.valor' => ['required', 'string'],
            'requestFundos.pilar' => ['required', 'int'],
            'requestFundos.project' => ['required', 'int'],
            'requestFundos.data' => ['required', 'string'],
            'requestFundos.local' => ['required', 'string'],
            'requestFundos.num_participantes' => ['required', 'int'],
            'requestFundos.num_dais' => ['required', 'int'],
            //'requestFundos.issueID'  => ['required', 'int'],
        ], [
            'required' => __('lang.errors.messages.required'),
            'max' => __('lang.text_caracters_maximum'),
            'min' => __('lang.text_caracters_minimum'),
        ], [
            'requestFundos.objectivo' => "Objectivo",
            'requestFundos.valor' => "Valor",
            'requestFundos.pilar' => "Pilar",
            'requestFundos.project' => "Projecto",
            'requestFundos.data' => "Data",
            'requestFundos.local' => "Local",
            'requestFundos.num_participantes' => "Numbero de Participantes",
            'requestFundos.num_dias' => "Numbero de Dias",
            //'requestFundos.issueID' => "Associar Actividade",
        ]);
    }

    /**
     * Iniciar o Fluxo de Approvacao
     *
     * @param
     * @return void
     */
    public function createBudgetRequestFlow()
    {
    }

    public function triggerNextApprove()
    {
    }

    public function existApprovementToTrigger(Model $approvementFlow, $resourceType, $trigger)
    {
        try {
            $hasTigger = $approvementFlow::where('type', $resourceType)
                ->where(function ($query) use ($trigger) {
                    $query->where('id', $trigger);
                })
            ->firstOrFail();
           
            return (object) array(
                'status' => true,
                'approvementFlow' => $hasTigger
            );
        } catch (\Throwable $th) {
            throw $th;
            throw new \Exception("There is no Approvement flow to be triggered");
        }
    }

    public function existApprovementToTriggerInit(Model $approvementFlow, $resourceType, $trigger, $Approve = null)
    {
        try {
            if ($Approve) {
                $hasTigger = $approvementFlow::where('id', 12)->firstOrFail();
            } else {
                $hasTigger = $approvementFlow::where('type', $resourceType)
                ->where(function ($query) use ($trigger) {
                    $query->where('trigger', $trigger);
                })
                ->firstOrFail();
            }
            return (object) array(
                'status' => true,
                'approvementFlow' => $hasTigger
            );
        } catch (\Throwable $th) {
            throw $th;
            throw new \Exception("There is no Approvement flow to be triggered");
        }
    }


    public function storeTriggeredApprovementFlow(Model $approvementFlow, $solicitacaoFundos, Projects $project, $usersToApprove = null)
    {
        if ($usersToApprove == null) {
            $usersToSendRequestTo = $this->getUsersToSendEmailNotificationTo($project, $approvementFlow->role);
            $_usersToApprove = $usersToSendRequestTo[0]->id; //$user->id;
        } else {
            $_usersToApprove = $usersToApprove;
        }

        $flowSolicitacaoFundos = new FlowSolicitacaoFundos();
        $flowSolicitacaoFundos->num_requisicao = $solicitacaoFundos->num_requisicao;
        $flowSolicitacaoFundos->solicitacao_id = $solicitacaoFundos->id;
        $flowSolicitacaoFundos->flow_id = $approvementFlow->id;
        $flowSolicitacaoFundos->flow_description = $approvementFlow->description;
        $flowSolicitacaoFundos->validator_category = $approvementFlow->role->name;
        $flowSolicitacaoFundos->user_id_to = $_usersToApprove;
        $flowSolicitacaoFundos->is_approved = false;
        $flowSolicitacaoFundos->type = $solicitacaoFundos->type;
        $flowSolicitacaoFundos->request_by = auth()->user()->id;
        $flowSolicitacaoFundos->created_on = now();

        $flowSolicitacaoFundos->save(); // Save data into database
    }

    /**
     * Store approvementFlow triggered - Report override method
     *
     * @param \Illuminate\Database\Eloquent\Model $approvementFlow
     * @param \App\Models\Projects $project
     * @param int $resourceId
     * @param string $resourceType
     * @param mixed|null $usersToApprove
     * @return void
     */
    public function storeFiredApprovementFlow(Model $approvementFlow, Projects $project, int $resourceId, string $resourceType, $usersToApprove = null)
    {
        if ($usersToApprove == null) {
            $usersToSendRequestTo = $this->getUsersToSendEmailNotificationTo($project, $approvementFlow->role);
            $_usersToApprove = $usersToSendRequestTo[0]->id; //$user->id;
        } else {
            $_usersToApprove = $usersToApprove;
        }
        // Cadastrar os dados do fluxo de aprovação
        $approvement_flow_model = new ApprovementFlowModels();

        $approvement_flow_model->flow_id = $approvementFlow->id;
        $approvement_flow_model->customized_id = $resourceId;
        $approvement_flow_model->role_id = $approvementFlow->role_id;
        $approvement_flow_model->assigned_to = $_usersToApprove;
        $approvement_flow_model->customized_type = $resourceType;
        $approvement_flow_model->request_by = auth()->user()->id;
        $approvement_flow_model->is_approved = false;
        $approvement_flow_model->created_on = now();
        $approvement_flow_model->updated_on = now();

        $approvement_flow_model->save(); // Save data into database
    }

    public function setHasApprovedFlow(Model $FlowModel)
    {

        try {

            DB::beginTransaction();

            $FlowModel->is_approved = true;
            $FlowModel->approved_by = auth()->user()->id;
            $FlowModel->approved_on = now();
            $FlowModel->save(); // Save data into database

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function requestedFlowHasBeenStored($approvementFlow, $resourceRequest): Throwable
    {
        if (ApprovementFlowModels::where('approvement_flow_id', $approvementFlow->id)
            ->where('customized_type', 'Issue')
            ->where('customized_id', $resourceRequest->id)
            ->first()
        ) {
            throw ValidationException::withMessages(['warning' => 'Detectamos que a Validação que voce tentou efetuar ja foi salva na base dados e um email ja foi notificado ao usuario que deve efetuar a proxima validação. Por favor recarege a pagina. Caso essa mensagem se repita por favor notifique ao Administrador!']);
        }
    }


    public function getUsersToSendEmailNotificationTo($project, $role): array
    {
        $users = [];
        // check if user is a member of the project with valid role
        foreach ($project->members as $key => $member) {
            if ($member->member_roles()->where('role_id', $role->id)->first()) {
                $users[] = $member->user;

                Log::alert([
                    "time" => time(),
                    "message" => "Fluxo de aprovação",
                    "user_to" => $member->user,
                    "class" => FlowApprovementManager::class,
                    "project" => $project,
                    "role" => $role,
                    "members" => $project->members,
                ]);
            }
        }
        
        if (sizeOf($users) === 0) {
            throw new \Exception("Fatal Error! User with valid role({$role['name']}) to approve the requested flow has not been found!", 10701);
        };
        return $users;
    }
}
