<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;
use App\Models\ApprovementFlow;
use Illuminate\Support\Facades\DB;
use App\Models\UsersApprovementFlow;
use App\Models\ApprovementFlowModels;

class SolicitacaoFundos extends Component
{
    public $project;
    public $issues = [];
    public $filter_ano;
    public $filter_mes;
    public $search_issue;
    public $provincia = 'null';
    public $project_provincias = [];
    public $years = [2020];


    public $issues_status = false;

    public $approvement_flows = [];
    public $approvement_requests = [];

    public $status = 'pending';
    public $is_approved = false;
    public $is_reject = false;

    public $approvement_flow_id;
    public $selected_approval = [];
    public $userApprovalRequests = [];
    public $showUserApprovalRequests = false;

    public function mount($project)
    {
        $this->project = $project;
        $this->filter_ano = date('Y');
        $this->filter_mes = 'null';
        $this->filters_year();

        $this->project_provincias = \App\Models\CustomValues::where('customized_type', 'Project')
            ->where('customized_id', $project->id)
            ->where('custom_field_id', 30)
            ->get();

        $this->approvement_flows = ApprovementFlow::where('is_active', true)->get();

        $this->approvement_requests = UsersApprovementFlow::where('user_id', auth()->user()->id)
            ->with('aprovement')
            ->with(['aprovement.issue' => function($query){
                $query->where('project_id', $this->project->id);
            }])
            ->whereHas('aprovement.issue')
            ->orderby('created_on', 'desc')
            ->get()->filter(function ($Item) {
                if ($Item->aprovement !== null && $Item->aprovement->issue !== null) {
                    return $Item;
                }
            });

        // dd($this->approvement_requests);
    }

    public function render()
    {
        return view('livewire.solicitacao-fundos');
    }

    public function load_issues($status, $month = null, $year = null)
    {

    }

    public function updatedFilterAno()
    {
        $this->load_issues($this->issues_status);
    }
    public function updatedFilterMes()
    {
        $this->load_issues($this->issues_status);
    }
    public function updatedProvincia()
    {
        $this->load_issues($this->issues_status);
    }

    public function filters_year()
    {
        $this->years = Issues::select(DB::raw('year(created_on) as year'))->groupBy('year')->get()->toArray();
    }

    /**
     *
     * Display list of resource
     */
    public function load_user_aproves()
    {
        if ($this->approvement_flow_id !== null) {
            if (!$this->showUserApprovalRequests) {
                $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
                return $this->approvement_requests = UsersApprovementFlow::where('user_id', auth()->user()->id)
                    ->with(['aprovement' => function ($query) {
                        return $query->where('approvement_flow_id', $this->selected_approval->id);
                    }])
                    ->with(['aprovement.issue' => function ($query) {
                        $query->where('project_id', $this->project->id);
                    }])
                    ->whereHas('aprovement.issue')
                    ->orderby('created_on', 'desc')
                    ->get()->filter(function ($Item) {
                        if ($Item->aprovement !== null && $Item->aprovement->issue !== null) {
                            return $Item;
                        }
                    });
            }

            return $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
                ->whereHas('approvement_flow')
                ->where('is_approved', $this->is_approved)
                ->where('is_rejected', $this->is_reject)
                ->with(['issue' => function ($query) {
                    $query->where('project_id', $this->project->id);
                }])
                ->get()->filter(function ($Item) {
                    if ($Item->approvement_flow !== null && $Item->issue !== null) {
                        return $Item;
                    }
                });

        } else {
            if (!$this->showUserApprovalRequests) {
                $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
                return $this->approvement_requests = UsersApprovementFlow::where('user_id', auth()->user()->id)
                    ->with(['aprovement'])
                    ->whereHas('aprovement')
                    ->where('is_approved', $this->is_approved)
                    ->where('is_rejected', $this->is_reject)
                    ->with(['aprovement.issue' => function ($query) {
                        $query->where('project_id', $this->project->id);
                    }])
                    ->whereHas('aprovement.issue')
                    ->orderby('created_on', 'desc')
                    ->get()->filter(function ($Item) {
                        if ($Item->aprovement !== null && $Item->aprovement->issue !== null) {
                            return $Item;
                        }
                    });
            }

            return $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
                ->whereHas('approvement_flow')
                ->where('is_approved', $this->is_approved)
                ->where('is_rejected', $this->is_reject)
                ->with(['issue' => function ($query) {
                    $query->where('project_id', $this->project->id);
                }])
                ->get()->filter(function ($Item) {
                    if ($Item->approvement_flow !== null && $Item->issue !== null) {
                        return $Item;
                    }
                });
        }
    }

    /**
     * Show users task that he has submit to be approved
     */
    public function load_user_submits()
    {
        $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
            ->with(['approvement_flow'])
            ->with(['issue' => function ($query) {
                $query->where('project_id', $this->project->id);
            }])
            ->whereHas('approvement_flow')
            ->get()->filter(function ($Item) {
                if ($Item->approvement_flow !== null && $Item->issue !== null) {
                    return $Item;
                }
            });
    }

    /**
     * When user select approvement_flow type
     */
    public function updatedApprovementFlowId()
    {
        if ($this->approvement_flow_id === "null") {
            return [];
        }

        if (!$this->showUserApprovalRequests) {
            $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
            return $this->approvement_requests = UsersApprovementFlow::where('user_id', auth()->user()->id)
                ->with(['aprovement' => function ($query) {
                    return $query->where('approvement_flow_id', $this->selected_approval->id);
                }])
                ->whereHas('aprovement')
                ->where('is_approved', $this->is_approved)
                ->where('is_rejected', $this->is_reject)
                ->get()->filter(function ($Item) {
                    if ($Item->aprovement !== null) {
                        return $Item;
                    }
                });
        }

        $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
        return $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
            ->with(['approvement_flow' => function ($query) {
                return $query->where('id', $this->selected_approval->id);
            }])
            ->whereHas('approvement_flow')
            ->where('is_approved', $this->is_approved)
            ->where('is_rejected', $this->is_reject)
            ->with(['issue' => function ($query) {
                $query->where('project_id', $this->project->id);
            }])
            ->whereHas('approvement_flow')
            ->get()->filter(function ($Item) {
                if ($Item->approvement_flow !== null && $Item->issue !== null) {
                    return $Item;
                }
            });
    }

    public $statusTitle = "Pendente";
    /**
     * On Staus changes
     */
    public function updatedStatus()
    {
        if ($this->status == 'approved') {
            $this->statusTitle = 'Aporvado';
            $this->is_approved = true;
            $this->is_reject = false;
        }
        if ($this->status == 'pending') {
            $this->statusTitle = "Pendente";
            $this->is_approved = false;
            $this->is_reject = false;
        }
        if ($this->status == 'rejected') {
            $this->statusTitle = "Reporvado";
            $this->is_reject = true;
            $this->is_approved = false;
        }

        return $this->load_user_aproves();
    }

    /**
     * switch
     */
    public function choseDataPoll($type)
    {
        switch ($type) {
            case 'UserApprovalRequest':
                $this->showUserApprovalRequests = true;
                $this->load_user_submits();
                break;
            default:
                $this->showUserApprovalRequests = false;
                break;
        }
    }
}
