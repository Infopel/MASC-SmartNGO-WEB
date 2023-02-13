<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Trackers;
use App\Models\Workflows;
use App\Models\CustomFields;
use App\Models\CustomFieldsTrackers;
use App\Models\IssueStatuses;
use App\Myclass\TreeView;
use App\Models\ProjectTrackers;
use App\Models\AppApprovementFlows;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;

class TrackersController extends Controller
{
    /**
     * Display a list
     */
    protected $projects;

    public function __construct()
    {
        $this->projects = TreeView::makeview(Projects::where('status', true)->orderby('created_on', 'asc')->get());
    }

    public function index()
    {
        // $this->authorize('viewAny', Trackers::class);

        $trackers = Trackers::select('*')->orderby('position', 'asc')->get();

        foreach ($trackers as $tracker) {
            $tracker['workflows'] = false;
            if (Workflows::select('tracker_id')->where('tracker_id', $tracker->id)->first()) {
                $tracker['workflows'] = true;
            }
        }

        $data = array(
            'trackers' => $trackers
        );
        // return $data;
        return view('trackers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Trackers::class);

        $issues_status = IssueStatuses::select('*')->orderby('position', 'asc')->get();
       // dd($issues_status);
        $tracker = [];
        $aprovement_flows = AppApprovementFlows::select('id', 'tagCode', 'title')->get();
        $projects = $this->projects;

        $custom_field_tracker_ids = CustomFields::select('custom_fields.id', 'name')
            ->where('type', 'IssueCustomField')
            ->get();

        // return $data;
        return view('trackers.new', compact('tracker', 'issues_status', 'projects', 'custom_field_tracker_ids', 'aprovement_flows'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Trackers::class);

        $request->validate([
            'tracker.name' => 'required|string|unique:trackers,name|max:30',
            'default_status_id' => 'required',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
        ]);

        // return $request;

        $position = Trackers::select('position')->latest('id')->first()->position ?? 0;

        try {

            DB::beginTransaction();
            
            

            $tracker = new Trackers();
            $tracker->name = $request->tracker['name'];
            $tracker->position = ++$position;
            if ($request->tagCode !== null) {
                $tracker->assined_workflow_tag = $request->tagCode;
                $tracker->use_workflow = 1;
            }
            $tracker->is_in_roadmap = $request->tracker['is_in_roadmap'];
            $tracker->core_fields = Yaml::dump($request->tracker['core_fields']);
            $tracker->default_status_id = $request->default_status_id;

            $tracker->save(); // Save data into database

            // Cadastro dos compos personalizados dos trackers
            $this->store_custom_fields_trackers($request->custom_field_ids, $tracker->id);
            // Cadastro dos projectos associados aos Trackers
            $this->store_project_trackers($request->project_ids, $tracker->id);

            DB::commit();
            return back()->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return back()->with('error', 'Os dados nao foram cadastrados Encontramos um erro. Error Type [RF002] - Trackers!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Trackers $tracker)
    {
        $this->authorize('create', Trackers::class);
        return $tracker;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Trackers $tracker)
    {
        $this->authorize('gerir_tipos_tarefas', Trackers::class);

        $issues_status = IssueStatuses::select('*')->orderby('position', 'asc')->get();
        $aprovement_flows = AppApprovementFlows::select('id', 'tagCode', 'title')->get();
        $tracker->core_fields = Yaml::parse($tracker->core_fields);
        $tracker->custom_fields_trackers;
        $tracker->projects_trackers;
        $projects = $this->projects;

        $custom_field_tracker_ids = CustomFields::select('custom_fields.id', 'name')
            ->where('type', 'IssueCustomField')
            ->get();

        // return $custom_field_tracker_ids;
        // return $tracker;
        return view('trackers.edit', compact('tracker', 'issues_status', 'projects', 'custom_field_tracker_ids', 'aprovement_flows'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trackers $tracker)
    {
        $this->authorize('gerir_tipos_tarefas', Trackers::class);

        $request->validate([
            'tracker.name' => 'required|max:30',
            'default_status_id' => 'required',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
        ]);

        try {
            DB::beginTransaction();

            $tracker->name = $request->tracker['name'];
            $tracker->core_fields = Yaml::dump($request->tracker['core_fields']);
            if ($request->tagCode !== null) {
                $tracker->assined_workflow_tag = $request->tagCode;
                $tracker->use_workflow = 1;
            }
            $tracker->default_status_id = $request->default_status_id;
            $tracker->is_in_roadmap = $request->tracker['is_in_roadmap'];

            $tracker->save(); // Save data into database

            // Cadastro dos compos personalizados dos trackers
            $this->store_custom_fields_trackers($request->custom_field_ids, $tracker->id);
            // Cadastro dos projectos associados aos Trackers
            $this->store_project_trackers($request->project_ids, $tracker->id);

            DB::commit();
            return redirect()->route('tracker.index')->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', 'Os dados nao foram cadastrados Encontramos um erro. Error Type [RF002] - Trackers!');
            // throw $th;
        }
    }

    public function remove_confirmation(Trackers $tracker)
    {
        $this->authorize('delete', $tracker);

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'tracker_id' => $tracker->id,
            'tracker_name' => $tracker->name,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trackers $tracker)
    {
        $this->authorize('delete', $tracker);
        try {
            $tracker->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Os dados nao foram cadastrados Encontramos um erro. Error Type [RF002] - Trackers!');
        }
    }


    /**
     * Store custom_fields_trackers
     */
    public function store_custom_fields_trackers($custom_field_ids, $tracker_id)
    {
        if ($custom_field_ids != null) {
            $CustomFieldsTrackers = CustomFieldsTrackers::where('tracker_id', $tracker_id)->delete();
            foreach ($custom_field_ids as $custom_field_id) {
                $custom_field_id_tracker = new CustomFieldsTrackers();
                $custom_field_id_tracker->custom_field_id = $custom_field_id;
                $custom_field_id_tracker->tracker_id = $tracker_id;
                $custom_field_id_tracker->save(); // Save data into database
            }
        }
    }
    /**
     * Store custom_fields_trackers
     */
    public function store_project_trackers($project_ids, $tracker_id)
    {
        if ($project_ids != null) {

            $CustomFieldsTrackers = ProjectTrackers::where('tracker_id', $tracker_id)->delete();

            foreach ($project_ids as $project_id) {
                $project_tracker = new ProjectTrackers();
                $project_tracker->project_id = $project_id;
                $project_tracker->tracker_id = $tracker_id;
                $project_tracker->save(); // Save data into database
            }
        }
    }
}
