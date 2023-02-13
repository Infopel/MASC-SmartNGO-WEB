<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ApprovementFlow;
use App\Models\SolicitacaoFundos;
use App\Models\FlowSolicitacaoFundos;

class ActivityPlanApprovementComponent extends Component
{

    public $activityPlanApprovalSteps = [];


    public function mount()
    {
        $this->activityPlanApprovalSteps = ApprovementFlow::where('type', 'ProjectActivitiesValidation')->where('is_active', true)->get();
        // dd($this->activityPlanApprovalSteps);

        $this->getStuckedAct_onFlowStrep(22);
    }


    public function getStuckedAct_onFlowStrep(int $flowStpeID)
    {
        $stucked_tasks = SolicitacaoFundos::where('request_by', auth()->user()->id)->get();
        // $stucked_tasks = FlowSolicitacaoFundos::where()
        // dd($stucked_tasks[1]->latestAprovement()->get());
    }

    public function render()
    {
        return view('livewire.activity-plan-approvement-component');
    }
}
