<?php

namespace App\Http\Controllers\Helpers;

use Exception;
use App\Models\User;
use App\Models\Issues;
use Illuminate\Http\Request;
use App\Models\ApprovementFlow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UsersApprovementFlow;
use App\Models\ApprovementFlowModels;
use App\Models\WorkFlowDecisionTree;
use App\Models\RejectedWorkflows;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use App\Events\ApprovementFlowNotificationEvent;

trait ApprovementFlowHelper
{
    public $resourceType;
    public $canAprove;
    /**
     * Verificar se existem
     * Approvement Flow com um tigger no cadastro de tarefa
     *
     * @return Object $response
     * @return \App\Models\ApprovementFlow::class as $trigger
     * @param String $flow_tagCode
     */
    public function ExistApprovementTriggerOnNewResource(string $flow_tagCode)
    {
        $this->resourceType = $flow_tagCode;
        
        try {
            $approvementFlow = ApprovementFlow::where('type', $flow_tagCode)
                ->where('trigger', 'initial_flow')
                ->firstOrFail();

            return (object) array(
                'status' => true,
                'trigger' => $approvementFlow
            );
        } catch (\Throwable $th) {
            return (object) array(
                'status' => false,
                'trigger' => []
            );
        }
    }

    public function ExistApprovementTriggerResource(string $flow_tagCode)
    {
        $this->resourceType = $flow_tagCode;
        
        try {
            $approvementFlow = ApprovementFlow::where('type', $flow_tagCode)
                ->where('trigger', 'processs_flow')
                ->firstOrFail();
            //dd($approvementFlow);
            return (object) array(
                'status' => true,
                'trigger' => $approvementFlow
            );
        } catch (\Throwable $th) {
            return (object) array(
                'status' => false,
                'trigger' => []
            );
        }
    }

    /**
     * Inicializar o trigger store
     * Cadastrar o ApprovementFlowModel do resource
     *
     * @param \App\Models\ApprovementFlow::class as $trigger
     * @param \App\Models\Issues $issue
     */
    public function StoreTriggeredApprovementFlow(ApprovementFlow $approvementFlow, Issues $issue, $comments = null)
    {
        //dd($issue);
        try {
            $usersToSendRequestTo = $this->getUsersToSendEmailNotificationTo($issue->project, $approvementFlow->role);
            $_usersToApprove = $usersToSendRequestTo[0]->id; //$user->id;

            DB::beginTransaction();
            // Cadastrar os dados do fluxo de aprovação
            $approvement_flow_model = new ApprovementFlowModels();

            $approvement_flow_model->flow_id = $approvementFlow->id;
            $approvement_flow_model->customized_id = $issue->id;
            $approvement_flow_model->role_id = $approvementFlow->role_id;
            $approvement_flow_model->customized_type = $this->resourceType;
            $approvement_flow_model->assigned_to = $_usersToApprove;
            $approvement_flow_model->comments = $comments ?? null;
            $approvement_flow_model->request_by = auth()->user()->id;
            $approvement_flow_model->is_approved = false;
            $approvement_flow_model->created_on = now();
            $approvement_flow_model->updated_on = now();

            $approvement_flow_model->save(); // Save data into database
            
            DB::commit();
            //dd($approvement_flow_model);
            return $approvement_flow_model;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Store Users Requested tasks to be Approved
     * @param \App\Models\ApprovementFlowModels
     * @return
     */
    public function StoreUserApprovementRequest(ApprovementFlowModels $approvementFlow)
    {
        try {
            $user_approvement_flow = new UsersApprovementFlow();
            $user_approvement_flow->user_id = $approvementFlow->assignedTo->id;
            $user_approvement_flow->approvement_flow_models_id = $approvementFlow->id;
            $user_approvement_flow->created_on = now();
            $user_approvement_flow->updated_on = now();

            $user_approvement_flow->save(); // Save data into database
        } catch (\Throwable $th) {
            throw new \Exception("Error while storing user to approve the request");
        }
    }

    /**
     * Verificar se exist um proximo nivel de aprovação para a tarefa
     */
    public function ExistApprovementToTrigger(string $resourceType, string $next_flow)
    {
        $this->resourceType = $resourceType;

        try {
            $approvement_flow = ApprovementFlow::where('type', $resourceType)
                ->where('id', \str_replace('flow_', '', $next_flow))
                ->firstOrFail();
            return (object) array(
                'status' => true,
                'approvement_flow' => $approvement_flow
            );
        } catch (\Throwable $th) {
            return (object) array(
                'status' => false,
                'approvement_flow' => []
            );
        }
    }

    /**
     * getUsersToSendEmailNotificationTo
     */

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
                    "class" => ApprovementFlowHelper::class,
                    "project" => $project,
                    "role" => $role,
                    "members" => $project->members,
                ]);
            }
        }
        if (sizeOf($users) == 0) {
            throw new \Exception("Fatal Error! User with valid role({$role['name']}) to approve the requested flow has not been found!", 10701);
        };
        return $users;
    }


    /**
     * Verificar se o request ja foi grado
     * na base de dados
     *
     * @param \App\Models\ApprovementFlow $approvement_flow
     * @param \App\Models\Issues $issue
     * @return boolean
     */
    public function RequestedFlowHasBeenStored(\App\Models\ApprovementFlow $approvement_flow, Issues $issue)
    {
        if (ApprovementFlowModels::where('approvement_flow_id', $approvement_flow->id)
            ->where('customized_type', 'Issue')
            ->where('customized_id', $issue->id)
            ->first()
        ) {
            throw ValidationException::withMessages(['warning' => 'Detectamos que a Validação que voce tentou efetuar ja foi salva na base dados e um email ja foi notificado ao usuario que deve efetuar a proxima validação. Por favor recarege a pagina. Caso essa mensagem se repita por favor notifique ao Administrador!']);
        }
    }

    /**
     * Aprovar fluxo da actividade
     *
     *
     */
    public function IssueFlowApproveRequest(Issues $issue, ApprovementFlowModels $approvement)
    {
        // TODO
        // Check if user has permissions to approve the task
        try {
            DB::beginTransaction();

            $approvement->is_approved = true;
            $approvement->approved_on = now();
            $approvement->approved_by = auth()->user()->id;
            $approvement->updated_on = now();
            $approvement->update(); // Update data

            try {
                $user_approvement_flow = UsersApprovementFlow::where('user_id', $approvement->assigned_to)
                    ->where('approvement_flow_models_id', $approvement->id)
                    ->firstOrFail();
                $user_approvement_flow->is_approved = true;
                $user_approvement_flow->updated_on = now();
                $user_approvement_flow->update(); // Update data
            } catch (\Throwable $th) {
                return back()->with('error', ("Ups, Error maching user to approve the current step on the workflow || RF037xWFlow \n Details: [..\Models\UsersApprovementFlow]"));
            }
            
            if ($approvement->approvement_flow->has_decision_tree) {
                $decision = WorkFlowDecisionTree:: where('id', $approvement->approvement_flow->decision_tree_id)->firstOrFail();
                $this->DecisionTreeOption($decision, "aprove", $issue, $approvement);

            } else {
                if (!$approvement->approvement_flow->is_flow_end) {
                    $flow_toGo = $this->ExistApprovementToTrigger($approvement->approvement_flow->type, $approvement->approvement_flow->approved_goto);
                    // Trigger next step for the approvation on the workflow if exist
                    $this->TriggerNextStep($flow_toGo, $issue, null);
                }
            }
            
            DB::commit();
            return back()->with('success', ("Fluxo de aprovação no nivel: {$approvement->approvement_flow->description} aprovado com sucesso."));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', ("Error while approving issue: {$issue->subject}, for workflow at step: {$approvement->approvement_flow->description} <br>Details: {$th->getMessage()}"));
        }
    }

    /**
     * Call to request email nitification event to send notification to user to approve the workflow process
     *
     * @param \App\Models\Issue $issue
     * @param \App\Models\ApprovementFlowModels $approvementFlow
     */
    private function SendEmailNotificationOnWorkFlowActionRequest(Model $resource, Model $approvementFlow)
    {
        // preventing notification error to stop issue storage
        try {
            //Send notification email to the user to approve the flow process step
            event(new ApprovementFlowNotificationEvent(
                auth()->user(),
                $resource,
                $approvementFlow,
                $this->email_content($resource)
            ));
        } catch (\Throwable $_th) {
            Log::alert([
                "message" => "Email Notification send failed",
                "envet" => "StoreApprovementRequest",
                "class" => ApprovementFlowNotificationEvent::class,
                "classFrom" => $this,
                "Error" => $_th->getMessage()
            ]);
        }
    }

    public function IssueFlowUnApproveRequest(Issues $issue, ApprovementFlowModels $approvement, Request $request)
    {
        try {
            DB::beginTransaction();
            // Reprovar nivel
            $approvement->is_rejected= true;
            $approvement->rejected_on = now();
            $approvement->rejected_by = auth()->user()->id;
            $approvement->updated_on = now();
            $approvement->update(); // Update data
            
            // Mandar para o nivel anterior
            try {
                $user_approvement_flow = UsersApprovementFlow::where('user_id', $approvement->assigned_to)
                    ->where('approvement_flow_models_id', $approvement->id)
                    ->firstOrFail();
                $user_approvement_flow->is_rejected = true;
                $user_approvement_flow->updated_on = now();
                $user_approvement_flow->update(); // Update data
            } catch (\Throwable $th) {
                return back()->with('error', ("Ups, Error maching user to approve the current step on the workflow || RF037xWFlow \n Details: [..\Models\UsersApprovementFlow]"));
            }
            
            if ($approvement->approvement_flow->has_decision_tree) {
                
                $decision = WorkFlowDecisionTree:: where('id', $approvement->approvement_flow->decision_tree_id)->firstOrFail();
                $this->DecisionTreeOption($decision, "reprove", $issue, $approvement);

            } else {
                //if (!$approvement->approvement_flow->is_flow_end) {
                $flow_toGo = $this->ExistApprovementToTrigger($approvement->approvement_flow->type, $approvement->approvement_flow->not_approved_goto);
                    // Trigger next step for the approvation on the workflow if 
                $this->TriggerBacktStep($flow_toGo, $approvement, $issue, $request->reprovacao);
               /* }else{

                    $flow_toGo = $this->ExistApprovementToTrigger($approvement->approvement_flow->type, $approvement->approvement_flow->not_approved_goto);
                    // Trigger next step for the approvation on the workflow if exist
                    $this->TriggerBacktStep($flow_toGo, $approvement, $issue);

                }*/
            }

            DB::commit();
            return back()->with('success', ("Fluxo de aprovação no nivel: {$approvement->approvement_flow->description} reprovado."));

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', ("Error while reproving issue: {$issue->subject}, for workflow at step: {$approvement->approvement_flow->description} <br>Details: {$th->getMessage()}"));
        }
    }

    public function DecisionTreeOption(WorkFlowDecisionTree $decisonTree, $decision, $issue, $approvement){
        if ($decision === "aprove") {
            if($decisonTree->on_positive_goto != "terminate_workflow"){
                $flow_toGo = $this->ExistApprovementToTrigger($approvement->approvement_flow->type, \str_replace('flow_', '', $decisonTree->on_positive_goto));
                $this->TriggerNextStep($flow_toGo, $issue, $comments = null);
            }
        } else {
            if($decision != "terminate_workflow"){
                $flow_toGo = $this->ExistApprovementToTrigger($approvement->approvement_flow->type, \str_replace('flow_', '', $decisonTree->on_negative_goto));
                $this->TriggerBacktStep($flow_toGo, $approvement, $issue, null);
            }
        }
    }

    public function TriggerNextStep($flow_toGo, $issue, $comments = null){
        if ($flow_toGo->status) {
            $StoreTriggeredApprovementFlow = $this->StoreTriggeredApprovementFlow($flow_toGo->approvement_flow, $issue, $comments);
            // Store request for the user approve the next step
            $this->StoreUserApprovementRequest($StoreTriggeredApprovementFlow);
            //Send notification email to the user to approve the flow process step
            $this->SendEmailNotificationOnWorkFlowActionRequest($issue, $StoreTriggeredApprovementFlow); // SendEmailNotificationOnApproveRequest data
        }
    }

    public function TriggerBacktStep($flow_toGo, $approvement, $issue, $comments = null){

        if ($flow_toGo->status) {
        
            $rejected_work_flows = new RejectedWorkflows();
            $rejected_work_flows->flow_id = $approvement->approvement_flow->id; 
            $rejected_work_flows->flow_type = $approvement->approvement_flow->type; 
            $rejected_work_flows->customized_type = 'issue'; 
            $rejected_work_flows->customized_id = $issue->id; 
            $rejected_work_flows->requested_by = $issue->id; 
            $rejected_work_flows->action_by = auth()->user()->id;
            $rejected_work_flows->reject_notes =$issue->id; 
            $rejected_work_flows->created_on =  now();

            $rejected_work_flows->save(); // Save data into database
            //$this->SendEmailNotificationOnWorkFlowActionRequest($issue, $StoreTriggeredApprovementFlow); // SendEmailNotificationOnApproveRequest data
        }
        // Apagar todos steps de aprovacao
        $stop_point = ApprovementFlowModels::where('customized_id', $approvement->customized_id)
                ->where('flow_id', $flow_toGo->approvement_flow->id)
                ->firstOrFail();

        $workflow_models = ApprovementFlowModels::where('customized_id', $approvement->customized_id)
                ->where('id', '>=',$stop_point->id)
                ->get();
      
        foreach ($workflow_models as $workflow_model) {
            $workflow = ApprovementFlowModels::where('id', $workflow_model->id)->firstOrFail();
            $workflow->delete();
        }
        // Trigger next step for the approvation on the workflow if exist
        $this->TriggerNextStep($flow_toGo, $issue, $comments);
    }


    
    
}
