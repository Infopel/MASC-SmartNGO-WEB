<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Members;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\ApprovementFlow;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\MemberProject;
use App\Models\ApprovementFlowModels;
use App\Models\IndicatorFieldsIssues;
use App\Models\ActivityPlanApprovement;
use App\Http\Controllers\Helpers\ApprovementFlowHelper;


class ActivityPlanApprovementController extends Controller
{
    use ApprovementFlowHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $PFEProjects = ApprovementFlowModels::where("customized_type", "PFEProject")
            ->with('project')
            ->whereHas('project');
        // ->get();

        $workflows = ApprovementFlow::where('type', '=', 'IssueApprovement')->get();


        // $projects = Projects::whereIn('ids', [$PFEProjects->toArray()])
        //     ->with('issues')
        //     ->whereHas('issues.workflowPFE')
        //     ->GET();


        // dd($workflows->toArray());

        // $a = str_replace('a')


        $tab = '$workflow->flow->description';
        return view('issues.approval_plan.index', compact('PFEProjects', 'workflows', 'tab'));
    }


    /**
     * Inicializar nivel de aprovação
     *
     * @return void
     */
    public function initWorflowP2F()
    {
        return back()->with("error", 'WorflowP2F initialized successfully');
        $data = [];
        $issues = [];
        $indicators = [];
        $permissionsAndMemberSteps = null;
        //GetWorkflowStepPipes
        //GetPermissionsAndMemberSteps
        //FetchProjectIssues
        //FetchPIssuesIndicator
        //ProcessWorkflowStep
        // -- initializa step with data
        //Workflowfallback
        // use hasone approvement_flow_models


        //GetWorkflowStepPipes
        try {
            $WorkflowInitialPipeLine = ApprovementFlow::where("type", "IssueApprovement")->where('trigger', 'NewIssue')->firstOrFail();
            $data['PFEPipeLine'] = $WorkflowInitialPipeLine->id;
        } catch (\Throwable $th) {
            throw new \Exception("Workflow PFE pipeline with 'Initial trigger' not found");
        }

        // GetPermissionsAndMemberSteps
        try {
            $flowMembers = Members::where('project_id', 24)->whereHas('member_roles', function ($query) use ($WorkflowInitialPipeLine) {
                $query->where('role_id', $WorkflowInitialPipeLine->role_id)->with("user");
            })->with('member_roles', 'user')->firstOrFail();

            $data['flowMember'] = $flowMembers->user_id;
        } catch (\Throwable $th) {
            throw new \Exception("Member on " . $WorkflowInitialPipeLine->description . " pipeline with 'RolePermission' " . $WorkflowInitialPipeLine->role->name . " not found");
        }

        //FetchProjectIssues
        $projects = Projects::select('id')->where('type', 'Project')
            ->with('issues')
            ->whereHas('issues')
            ->whereHas('issues.tracker')
            ->limit('3')
            ->get();


        foreach ($projects as $project) {
            $data['PFEProject'][] = $project->id;
            //FetchProjectIssues
            $issues = Issues::where("project_id", $project->id)->where('tracker_id', 14)->get();
            if (\sizeof($issues) >  0) {
            } {
                foreach ($issues as $key => $issue) {
                    $data['PFEIssueProjecct'][] = $issue->id;
                    //FetchPIssuesIndicator
                    $indicators = IndicatorFieldsIssues::where('issue_id', $issue->id)->get();
                    foreach ($indicators as $key => $indicator) {
                        $data['PFEIssueProjecctIndicator'][] = $issue->id;
                    }
                }
            }
        }

        // ProcessWorkflowStep

        foreach ($data['PFEProject'] as $key => $project) {
            $resource = \collect([
                'customized_id' => $project,
                'customized_type' => 'PFEProject',
                'flowMember' => $data['flowMember']
            ]);
            $this->iniStoreTriggeredApprovementFlow($WorkflowInitialPipeLine, $resource);
        }

        foreach ($data['PFEIssueProjecct'] as $key => $IssueProjecct) {
            $resource = \collect([
                'customized_id' => $IssueProjecct,
                'customized_type' => "PFEIssueProjecct",
                'flowMember' => $data['flowMember']
            ]);
            $this->iniStoreTriggeredApprovementFlow($WorkflowInitialPipeLine, $resource);
        }

        foreach ($data['PFEIssueProjecctIndicator'] as $key => $indicator) {
            $resource = \collect([
                'customized_id' => $indicator,
                'customized_type' => "PFEIssueProjecctIndicator",
                'flowMember' => $data['flowMember']
            ]);
            $this->iniStoreTriggeredApprovementFlow($WorkflowInitialPipeLine, $resource);
        }

        return back()->with('success', 'Aprovação inicializada com sucesso');
    }


    /**
     * Inicializar o trigger store
     * Cadastrar o ApprovementFlowModel do resource
     *
     * @param \App\Models\ApprovementFlow::class as $trigger
     * @param \Illuminate\Model $resource
     */
    private function iniStoreTriggeredApprovementFlow(ApprovementFlow $tigger, $resource)
    {
        try {
            DB::beginTransaction();
            // Cadastrar os dados do fluxo de aprovação
            $approvement_flow_model = new ApprovementFlowModels();

            $approvement_flow_model->flow_id = $tigger->id;
            $approvement_flow_model->role_id = $tigger->role_id;
            $approvement_flow_model->customized_id = $resource['customized_id'];
            $approvement_flow_model->customized_type = $resource['customized_type'];
            $approvement_flow_model->request_by = auth()->user()->id;
            $approvement_flow_model->assigned_to = $resource['flowMember'];
            $approvement_flow_model->is_approved = false;
            $approvement_flow_model->created_on = now();
            $approvement_flow_model->updated_on = now();

            $approvement_flow_model->save(); // Save data into database

            DB::commit();
            return $approvement_flow_model;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
            return new ApprovementFlowModels();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ActivityPlanApprovement  $activityPlanApprovement
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityPlanApprovement $activityPlanApprovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActivityPlanApprovement  $activityPlanApprovement
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityPlanApprovement $activityPlanApprovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActivityPlanApprovement  $activityPlanApprovement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityPlanApprovement $activityPlanApprovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActivityPlanApprovement  $activityPlanApprovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityPlanApprovement $activityPlanApprovement)
    {
        //
    }
}
