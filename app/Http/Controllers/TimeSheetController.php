<?php

namespace App\Http\Controllers;

use App\Models\TimeSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AppApprovementFlows;
use App\Models\ApprovementFlow;
use App\Models\ApprovementFlowModels;
use App\Models\Issues;
use App\Models\MemberRoles;
use App\Models\Members;
use App\Models\Ts_workflow;
use App\Models\TsActivity;
use App\Models\TsSubmission;
use App\Models\User;
use App\Models\UsersApprovementFlow;
use App\Models\WorkFlowDecisionTree;
use Illuminate\Support\Facades\Auth;

class TimeSheetController extends Controller
{
    public $project_id = null;
    public $approvement;
    public $appApprovement;
    public $flow_comments;
    public $resourceType;
    public $canAprove;
    public $sel_option;
    public $issue;
    public $next_flow;
    public $member_role;
    public $ts_sub;
    public $ts_selected;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $timesheets = TimeSheet::where('user_id',  Auth::user()->id)->orderby('id', 'desc')->with('activities')->get();

        $users = user::all();

        return view("timesheet.index", ['timesheets' => $timesheets, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        return view("timesheet.new");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Primeiro vamos validar o request
        $request->validate([
            //'timesheet.descrition' => 'required',
            //'timesheet.identifier' => 'required',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
        ], [
            'timesheet.name' => __('lang.field_name'),
        ]);

        try {
            $tag_code = Auth::user()->login . '' . now();
            DB::beginTransaction();
            // Create new timesheet Resource
            $timesheet = new TimeSheet();
            $timesheet->descrition = $request->timesheet['descrition'];
            $timesheet->tag_code = $tag_code;
            $timesheet->user_id = Auth::user()->id;
            $timesheet->data_inicio = $request->timesheet['start_date'];
            $timesheet->data_fim = $request->timesheet['due_date'];
            $timesheet->created_at = now();
            $timesheet->updated_at = now();
            $timesheet->approved = false;
            $timesheet->save(); // Save data into database

            DB::commit();
            return redirect()->route('app.timesheets', ['timesheet_identifier' => $timesheet->identifier])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('timesheets.new')->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $timesheets
     * @return \Illuminate\Http\Response
     */
    // public function show(Projects $timesheet_identifier)
    // {

    //     $this->timesheet = $timesheet_identifier;

    //     $timesheet_identifier->parent;
    //     $timesheet_identifier->issues;
    //     $timesheet_identifier->issue_custom_fields;
    //     $timesheet_identifier->members;
    //     $timesheet_identifier->timesheet_trackers;

    //     $custom_fields = CustomFields::select('*')->where('type', 'ProjectCustomField')->get();

    //  

    //     $timesheet = $timesheet_identifier;
    //     $timesheet->childs;

    //     $timesheet_trackers_overview = [];
    //     $_timesheet_trackers_overview = [];
    //     foreach ($timesheet->timesheet_trackers()->get() as $tracker) {
    //         if ($tracker->tracker != null) {
    //             $timesheet_trackers_overview[$tracker->tracker['name']] = $tracker->tracker != null ? $tracker->tracker($timesheet->id)->first()['issues'] : [];
    //         }
    //     }

    //     foreach ($project_trackers_overview as $key => $tracker) {
    //         if ($key !== '') {
    //             // dd($project_trackers_overview);
    //             if (empty($tracker)) {
    //                 $_project_trackers_overview[$key]['tracker_id'] = $tracker['tracker_id'];
    //             }
    //             foreach ($tracker as $tracker_key => $tracker) {
    //                 $_project_trackers_overview[$key]['tracker_id'] = $tracker['tracker_id'];
    //                 $_project_trackers_overview[$key][$tracker['status']['is_closed']][] = $tracker['status'];
    //             }
    //         }
    //     }
    //     // return $_project_trackers_overview;
    //     $project->project_trackers_overview = $_project_trackers_overview;

    //     $indicators = $this->map_project_indicators_overview($project->issues()->with('indicators')->get());

    //     $project->indicators = $indicators;

    //     // dd($indicators);

    //     return view('projects.projecto', compact('project'));
    // }



}
