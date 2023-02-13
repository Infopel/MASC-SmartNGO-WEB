<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\SolicitacaoFundos;
use App\Models\AppApprovementFlows;
use App\Models\FlowSolicitacaoFundos;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Models\ApprovementFlow as ApprovementFlowModel;

class BudgetApprovementRequest extends Component
{
    public $project;
    public $solicitacaoFundos;
    public $rubrica_orcamento = null;
    public $showModal = false;
    public $indicators = [];
    public $tipoSolicitacao;

    public $flowSolicitacaoFundos = [];

    public $areas = [];
    public $necessidades = [];
    public $activities = [];
    public $userNotSelectedErrorMenssage = null;
    private $route;

    public $isSearchIssue = false;
    public $searchIssue;
    public $search_IssueRequest_result;
    public $selected_issue_id;

    public function mount($project, SolicitacaoFundos $solicitacaoFundos)
    {
        $this->project = $project;
        $this->solicitacaoFundos = $solicitacaoFundos;
        $this->getTypeSolicitacaoFundos();
        $this->getFlowSolicitacaoFundos();

        session()->forget('error');
        session()->forget('warning');
        session()->forget('success');
    }



    public function getFlowSolicitacaoFundos()
    {
        $this->flowSolicitacaoFundos = FlowSolicitacaoFundos::where(
            'num_requisicao',
            $this->solicitacaoFundos->num_requisicao
        )->groupBy('flow_id')->get();
    }

    public function getTypeSolicitacaoFundos()
    {
        if ($this->solicitacaoFundos->type) {
            $this->tipoSolicitacao = AppApprovementFlows::where(
                'tagCode',
                $this->solicitacaoFundos->type
            )->first();
        }

    }


    public function render()
    {
        return view('livewire.budget-approvement-request');
    }


    public $hasManyUsersToApproveModal = false;
    public $usersToApprove = [];
    public $userTo = null;
    public $_redirect_to = null;

    public $isSubmit = false;


    public $nivel_description = null;
    public $approvementFlow;
    public $requestNum;

    public function request_reprovar($approvement_flow, $requestNum, $flowDescription)
    {
        $this->nivel_description = $flowDescription;
        $this->approvementFlow = $approvement_flow;
        $this->requestNum = $requestNum;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->hasManyUsersToApproveModal = false;
    }


    public function interceptApprovalRequestEvent(string $redirect_to, $approvement_flow, $requestNum, $flowDescription)
    {
        $this->_redirect_to = $redirect_to;
        $this->userNotSelectedErrorMenssage = null;
        try {
            $this->usersToApprove = $this->getUseToApprove($approvement_flow, $requestNum);
           
            if (\sizeof($this->usersToApprove) > 1) {
                $this->hasManyUsersToApproveModal = true;

                $this->approvementFlow = $approvement_flow;
                $this->requestNum = $requestNum;
                return;
            } else {
                
                $this->isSubmit = true;
            }
        } catch (Throwable $th) {
            return back()->with('error', $th->getMessage() ?? $th);
        }
    }

    public function dispatchRequest()
    {
        if ($this->userTo == null) {
            $this->userNotSelectedErrorMenssage = "Error, o request não pode ser processado!<br>Nenhum usuário selecionado. Por favor selecione um!";
            session()->flash('error', $this->userNotSelectedErrorMenssage);
            return;
        }
    }

    public function cancel_action()
    {
        $this->isSubmit = false;
    }

    public function updatedUserTo()
    {
        $this->_redirect_to = $this->_redirect_to . '?usersToApprove=' . $this->userTo;
    }


    public $role_need = null;
    protected function getUseToApprove($approvement_flow, $requestNum)
    {
        $users = [];
        
        try {
            $flowSolicitacaoFundos = FlowSolicitacaoFundos::where('id', $approvement_flow)
                                                            ->where('num_requisicao', $requestNum)
                                                            ->with('flow')
                                                            ->firstOrFail();
            // check if user is a member of the project with valid role
            if (!$flowSolicitacaoFundos->flow->is_flow_end) {
                if ($this->solicitacaoFundos->type) {
                    $hasApprovementFlowToTrigger = $this->existApprovementToTrigger(
                        $flowSolicitacaoFundos,
                        $this->solicitacaoFundos->type,
                        \str_replace('flow_', '', $flowSolicitacaoFundos->flow->approved_goto)
                    )->approvementFlow;
                }else {
                    $hasApprovementFlowToTrigger = $this->existApprovementToTrigger(
                        $flowSolicitacaoFundos,
                        "SolicitacaodeFundos",
                        \str_replace('flow_', '', $flowSolicitacaoFundos->flow->approved_goto)
                    )->approvementFlow;
                }
            } else {
                $hasApprovementFlowToTrigger = $flowSolicitacaoFundos;
            }

            $this->nivel_description = $hasApprovementFlowToTrigger->description;
            $this->role_need = $hasApprovementFlowToTrigger->role->name;

            foreach ($flowSolicitacaoFundos->solicitacao->project->members as $key => $member) {

                if ($member->member_roles()->where('role_id', $hasApprovementFlowToTrigger->role->id)->first()) {
                    $users[] = $member->user;
                }
            }

            if (sizeOf($users) == 0) {
                $this->userNotSelectedErrorMenssage = "Fatal Error! User with valid role({$this->role_need}) to approve the requested flow has not been found!";
                session()->flash('error', $this->userNotSelectedErrorMenssage);
            };
        } catch (\Throwable $th) {
            $this->userNotSelectedErrorMenssage = $th->getMessage();
            session()->flash('error', $this->userNotSelectedErrorMenssage);
        }
        
        return $users;
    }


    protected function existApprovementToTrigger($approvementFlow, $resourceType, $trigger)
    {
        try {

            if ($approvementFlow->id == 28) {
                $hasApprovementFlowToTrigger = ApprovementFlowModel::where('type', $resourceType)
                    ->where('id', 12)
                    ->where('is_active', true)
                    ->firstOrFail();
            } else {
                $hasApprovementFlowToTrigger = ApprovementFlowModel::where('type', $resourceType)
                    ->where('id', $trigger)
                    ->where('is_active', true)
                    ->firstOrFail();
            }
            
            return (object) array(
                'status' => true,
                'approvementFlow' => $hasApprovementFlowToTrigger
            );
            
        } catch (\Throwable $th) {
            throw new \Exception("There is no Approvement flow to be triggered", 2302);
        }
    }

    public $isEditTaskLink = false;
    /**
     * Show form box to select and link task
     * @return boolean
     */
    public function editTaskLink()
    {
        $this->isEditTaskLink = true;
    }

    /**
     *
     * Search Budgets - para associar a actividade
     *
     * @param string search_input
     * @return \App\Models\SolicitacaoFundos
     */
    public function updatedSearchIssue()
    {
        if ($this->searchIssue !== '') {
            $this->isSearchIssue = true;
            return $this->search_IssueRequest_result = Issues::where('project_id', $this->project->id)
                //->where('solicitacao_fundos_id', null)
                ->where(function ($query) {
                    $query->where('id', 'like', '%' . $this->searchIssue . '%')
                        ->orWhere('subject', 'like', '%' . $this->searchIssue . '%');
                })->limit(15)->get();
        } else {
            $this->reset_search();
            $this->selectedIssue = [
                'id' => null,
                'subject' => '',
                'description' => ''
            ];
            $this->selected_issue_id = null;
        }
    }

    public $selectedIssue = [
        'id' => null,
        'subject' => '',
        'description' => ''
    ];
    public function selectIssue(int $issueID, string $issueSubject)
    {
        $this->selected_issue_id = $issueID;
        $this->selectedIssue = [
            'id' => $issueID,
            'subject' => $issueSubject,
            'description' => Issues::select('description')->where('id', $issueID)->first()->description ?? '',
        ];
        $this->searchIssue = $issueSubject;
        $this->reset_search();
    }

    public function reset_search()
    {
        $this->isSearchIssue = false;
    }

    public function cancelTaskLink()
    {
        $this->isEditTaskLink = false;
        $this->selectedIssue = [
            'id' => null,
            'subject' => '',
            'description' => ''
        ];
        $this->selected_issue_id = null;
        $this->searchIssue = '';
    }

    public function storeTaskLinkUpdate(int $issueID)
    {
        try {
            $issue = Issues::where('id', $issueID)->first();
            $issue->solicitacao_fundos_id = $this->solicitacaoFundos->id;
            $issue->update(); // Update data into database

            $_solicitacaoFundos = SolicitacaoFundos::where('id', $this->solicitacaoFundos->id)->first();
            $_solicitacaoFundos->issue_id = $issue->id;
            $_solicitacaoFundos->update(); // Update data into database

            $this->solicitacaoFundos = $_solicitacaoFundos;
            $this->reset_search();
            $this->cancelTaskLink();
        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }
    }
}
