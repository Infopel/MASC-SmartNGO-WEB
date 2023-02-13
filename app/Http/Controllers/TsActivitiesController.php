<?php

namespace App\Http\Controllers;

use App\Models\ApprovementFlow;
use App\Models\MemberRoles;
use App\Models\Members;
use App\Models\TsActivity;
use App\Models\Projects;
use App\Models\Roles;
use App\Models\TimeSheet;
use App\Models\Ts_workflow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TsActivitiesController extends Controller
{

    public $tsactivity;
    public $projects_id;
    public $members_roles;
    public $approvement_flow;
    public $member;
    public $assigned_to;


    public function index()
    {

        $this->tsactivity = TsActivity::all();
        $projects = Projects::where('type', 'project')->orderby('id', 'desc')->get();
        $activities = TimeSheet::all();
        foreach ($projects as $project) {
            $this->projects_id = $project->id;
        }

        return view(
            "ts_activities.index",
            [
                'tsactivity' => $this->tsactivity,
                'actividade' => $activities,
                'projects' => $projects,
            ]
        );
    }



    public function create()
    {
        $projects = Projects::where('type', 'project')->orderby('id', 'desc')->get();
        $timesheets = TimeSheet::all();

        return view("ts_activities.new", ['projects' => $projects, 'timesheets' => $timesheets]);
    }

    public function store(Request $request)
    {


        try {
            DB::beginTransaction();
            // Create new timesheet Resource
            $tsactivity = new TsActivity();
            $tsactivity->descrition = $request->tsactivity['descrition'];
            $tsactivity->data = $request->tsactivity['data'];
            $tsactivity->nr_horas = $request->tsactivity['nr_horas'];
            $tsactivity->resultado = $request->tsactivity['resultado'];
            $tsactivity->execucao = $request->tsactivity['execucao'];
            $tsactivity->constragimentos = $request->tsactivity['constragimentos'];
            $tsactivity->tag_code_ts = $request->tsactivity['timesheet'];
            $tsactivity->project_id = $request->tsactivity['project_id'];
            $tsactivity->created_by = Auth::user()->id;
            $tsactivity->updated_by = Auth::user()->id;
            $tsactivity->created_at = now();
            $tsactivity->updated_at = now();
            $tsactivity->save(); // Save data into database
            DB::commit();
            return redirect()->route('timesheets.activity.index', ['timesheet_identifier' => $request->tag_code])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('timesheets.activity.new', ['tag_code' => 'Folege'])->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            throw $th;
        }
    }

    //get id
    public function show($id)
    {
        $tsactivity = TsActivity::find($id);
        return response()->json([$tsactivity], 200);
    }

    //update
    public function update(Request $request, $id)
    {
        $tsactivity = TsActivity::find($id);
        $tsactivity->update($request->all());
        return response()->json([$tsactivity], 200);
    }

    //delete
    public function destroy($id)
    {
        try {
            $tsactivity = TsActivity::find($id);

            $tsactivity->delete();
            return response()->json([$tsactivity], 200);
        } catch (\Throwable $th) {
            return response()->json([$th], 401);
        }
    }


    public function mount(Request $request)
    {
        $actividade = $request->timesheet['activite'];
        $timesheets = TsActivity::where('id', $actividade)->get();
        foreach ($timesheets as $timesheet) {
            $members = Members::where('project_id', $timesheet->project_id)->where('user_id', auth()->user()->id)->get();
            // dd($members);
            foreach ($members as $member) {
                $this->members_roles = MemberRoles::where('member_id', $member->id)->get();
                foreach ($this->members_roles as $member_role) {
                    $this->approvement_flow = ApprovementFlow::where('role_id', $member_role->role_id)->get();
                    // foreach($this->approvement_flow as $app_flow){
                    //     $ts_workflow = Ts_workflow::where('flow_id',$app_flow->id)
                    //     ->where('project_id',$timesheet->project_id)->get();
                    // }
                }
            }
        }

        return view('timesheet.timesheet_flow', [
            'actividades' => $timesheets,
            'members_roles' => $this->members_roles,
            'members' => $members,
            'approvement_flow' => $this->approvement_flow,
            // 'ts_workflows' => $ts_workflow,
        ]);
    }




    public function history_flow(TsActivity $ts_activite)
    {
        $timesheets = TsActivity::where('id', $ts_activite->id)->get();
        // foreach ($timesheets as $timesheet) {
        //     foreach( $ts_workflows as  $ts_workflow){
                
        //         // $this->approvement_flow = ApprovementFlow::where('id', $ts_workflow->flow_id)->get();
        //     }
        // }
        // dd();
        // dd($this->approvement_flow);
        foreach ($timesheets as $timesheet) {
            
            $members = Members::where('project_id', $timesheet->project_id)->where('user_id', auth()->user()->id)->get();
            foreach ($members as $member) {
                $this->members_roles = MemberRoles::where('member_id', $member->id)->get();
                foreach ($this->members_roles as $member_role) {
                    $this->approvement_flow = ApprovementFlow::where('role_id', $member_role->role_id)->get();
                    //         // foreach($this->approvement_flow as $app_flow){
            $ts_workflows = Ts_workflow::where('project_id', $timesheet->project_id)->where('ts_activity_id', $ts_activite->id)->where('tag_code', $timesheet->tag_code_ts)->get();

                }
                }
            }
        // }
        // dd($ts_workflow );
        return view('timesheet.approve_timesheet', [
            'ts_workflows' => $ts_workflows,
            'actividades' => $timesheets,
            'members' => $members,
            'members_roles' => $this->members_roles,
            'approvement_flow' => $this->approvement_flow
        ]);
    }


    public function flow_approvement(Request $request, Ts_workflow $tsworkflow)
    {
        //    dd($request->timesheet);
        if ($request->timesheet['new'] == "new") {
            $flow_id = \str_replace('flow_', '', $request->timesheet['approved_goto']);
            $approvement_flow = ApprovementFlow::where('id', $flow_id)->firstOrFail();
            $this->member = Members::where('project_id', $request->timesheet['project_id'])->get();
            foreach ($this->member as $member) {
                $members_roles = MemberRoles::where('role_id', $approvement_flow->role_id)->where('member_id', $member->id)->get();
                foreach ($members_roles as $roles) {
                    $userTo = Members::where('id', $roles->member_id)->first();
                    $this->assigned_to = $userTo->user_id;
                }
            }
            $tsActivity = TsActivity::where('tag_code_ts', $request->timesheet['tag_code'])->firstOrFail();
            //   dd( $tsActivity->id);

            // try {

            //code...
            DB::beginTransaction();
            $tsworkflow->tag_code = $request->timesheet['tag_code'];
            $tsworkflow->flow_id = $request->timesheet['id'];
            $tsworkflow->role_id = $approvement_flow->role_id;
            $tsworkflow->comments = $request->timesheet['comments'];
            $tsworkflow->request_by = auth()->user()->id;
            $tsworkflow->ts_activity_id = $tsActivity->id;
            $tsworkflow->assigned_to = $this->assigned_to;
            $tsworkflow->is_approved = true;
            $tsworkflow->approved_by = auth()->user()->id;
            $tsworkflow->created_on = now();
            $tsworkflow->approved_on = now();
            $tsworkflow->updated_on = now();
            $tsworkflow->next_flow = $flow_id;
            $tsworkflow->is_end = $request->timesheet['is_end'];
            $tsworkflow->project_id = $request->timesheet['project_id'];
            $tsworkflow->save();  # Save data into
            DB::commit();

            return redirect()->route('app.flow_approve_timesheet', ['ts_activite' => $tsActivity->id])->with('success', __('lang.notice_successful_create'));
            // } catch (\Throwable $th) {
            //throw $th;
            // DB::rollback();
            // return redirect()->route('app.flow_approve_timesheet')->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            // throw $th;
            // }
        } else {
            $approvement_flow = ApprovementFlow::whereNull('approved_goto')->where('id', $request->timesheet['id'])->firstOrFail();
            $this->member = Members::where('project_id', $request->timesheet['project_id'])->get();
            foreach ($this->member as $member) {
                $members_roles = MemberRoles::where('role_id', $approvement_flow->role_id)->where('member_id', $member->id)->get();
            }
            $tsActivity = TsActivity::where('tag_code_ts', $request->timesheet['tag_code'])->firstOrFail();

            // dd($tsActivity->id);
            try {
                //code...
                DB::beginTransaction();
                $tsworkflow->tag_code = $request->timesheet['tag_code'];
                $tsworkflow->flow_id = $request->timesheet['id'];
                $tsworkflow->role_id = $approvement_flow->role_id;
                $tsworkflow->comments = $request->timesheet['comments'];
                $tsworkflow->request_by = auth()->user()->id;
                $tsworkflow->assigned_to = null;
                $tsworkflow->is_approved = true;
                $tsworkflow->approved_by = auth()->user()->id;
                $tsworkflow->ts_activity_id = $tsActivity->id;
                $tsworkflow->approved_on = now();
                $tsworkflow->created_on = now();
                $tsworkflow->updated_on = now();
                $tsworkflow->next_flow = $request->timesheet['approved_goto'];
                $tsworkflow->is_end = $request->timesheet['is_end'];
                $tsworkflow->project_id = $request->timesheet['project_id'];
                $tsworkflow->save();  # Save data into
                // dd($tsworkflow);
                DB::commit();
                return redirect()->route('app.flow_approve_timesheet', ['ts_activite' => $tsActivity->id])->with('success', __('lang.notice_successful_create'));
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();
                return redirect()->route('app.flow_approve_timesheet')->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
                throw $th;
            }
        }
    }
}
