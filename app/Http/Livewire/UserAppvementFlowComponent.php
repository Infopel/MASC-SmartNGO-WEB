<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ApprovementFLow;
use App\Models\ApprovementFlowModels;
use App\Models\UsersApprovementFlow;

class UserAppvementFlowComponent extends Component
{

    public $status = 'pending';
    public $is_approved = false;
    public $is_reject = false;
    public $search;

    public $resources = [];

    public $approvement_flows = [];
    public $approvement_flow_id;
    public $selected_approval = [];
    public $userApprovalRequests = [];
    public $showUserApprovalRequests = false;

    public function mount()
    {
        $this->approvement_flows = ApprovementFlow::where('is_active', true)->get();
        // $this->selected_approval = $this->approvement_flows[0];

        $this->resources = UsersApprovementFlow::where('user_id', auth()->user()->id)
            ->with('aprovement')
            ->orderby('created_on', 'desc')
            ->get()->filter(function ($Item) {
                if ($Item->aprovement !== null) {
                    return $Item;
                }
            });
    }

    public function render()
    {
        return view('livewire.user-appvement-flow-component');
    }

    /**
     *
     * Display list of resource
     */
    public function load_user_aproves()
    {
        if ($this->selected_approval !== []) {
            if (!$this->showUserApprovalRequests) {
                $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
                return $this->resources = UsersApprovementFlow::where('user_id', auth()->user()->id)
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
            } else {
                return $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
                    ->whereHas('approvement_flow')
                    ->where('is_approved', $this->is_approved)
                    ->where('is_rejected', $this->is_reject)
                    ->get();
            }
        } else {
            if (!$this->showUserApprovalRequests) {
                $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
                return $this->resources = UsersApprovementFlow::where('user_id', auth()->user()->id)
                    ->with(['aprovement'])
                    ->whereHas('aprovement')
                    ->where('is_approved', $this->is_approved)
                    ->where('is_rejected', $this->is_reject)
                    ->get()->filter(function ($Item) {
                        if ($Item->aprovement !== null) {
                            return $Item;
                        }
                    });
            } else {
                return $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
                    ->whereHas('approvement_flow')
                    ->where('is_approved', $this->is_approved)
                    ->where('is_rejected', $this->is_reject)
                    ->get();
            }
        }
    }

    /**
     * Show users task that he has submit to be approved
     */
    public function load_user_submits()
    {
        $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
            ->with(['approvement_flow'])
            ->whereHas('approvement_flow')
            ->get()->filter(function ($Item) {
                if ($Item->approvement_flow !== null) {
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
            return $this->resources = UsersApprovementFlow::where('user_id', auth()->user()->id)
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
        } else {
            $this->selected_approval = ApprovementFlow::where('id', $this->approvement_flow_id ?? 1)->first();
            return $this->userApprovalRequests = ApprovementFlowModels::where('request_by', auth()->user()->id)
                ->with(['approvement_flow' => function ($query) {
                    return $query->where('id', $this->selected_approval->id);
                }])
                ->whereHas('approvement_flow')
                ->where('is_approved', $this->is_approved)
                ->where('is_rejected', $this->is_reject)
                ->get()->filter(function ($Item) {
                    if ($Item->approvement_flow !== null) {
                        return $Item;
                    }
                });
        }
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
