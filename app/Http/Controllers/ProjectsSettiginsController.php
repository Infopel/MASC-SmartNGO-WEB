<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Trackers;
use App\Models\CustomFields;
use App\Models\EnabledModules;
use App\Models\Enumerations;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\ModulesHelper;
use App\Http\Controllers\Helpers\ProjectsHelper;
use App\Http\Controllers\Helpers\CustomFieldsHelper;
use App\Models\ProjectTrackers;

class ProjectsSettiginsController extends Controller
{
    use CustomFieldsHelper, ProjectsHelper, ModulesHelper;

    protected $Custom_field_type = "ProjectCustomField";
    protected $type = "Project";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Projects $project_identifier)
    {
        $project = $project_identifier;
        $project->modules = $this->project_modules($project->modules()->get()->toArray());

        $projects = Projects::select('id', 'name')->where('type', $this->type)->where('status', 1)->get();
        $programs = Projects::select('id', 'name')->where('type', 'Program')->where('status', 1)->get();

        $_custom_fields = CustomFields::select('*')->where('type', $this->Custom_field_type)->get();
        $custom_fields = $this->custom_field_tag_with_label($project->id, $project->custom_field_values, $_custom_fields);

        // Get Application avalible Trackers
        $trackers = Trackers::select('id', 'name')->get();
        $project->trackers = $this->project_tracker_with_label($project->id, $project->project_trackers, $trackers);

        $time_entry_activity = Enumerations::where('type', 'TimeEntryActivity')->get();

        // return $project->members;
        // return $custom_fields;
        return view('projects.settings', compact('project', 'projects', 'custom_fields', 'programs', 'trackers', 'time_entry_activity'));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $project_identifier
     * @return \Illuminate\Http\Response
     */
    public function update_modules(Request $request, Projects $project_identifier)
    {
        $project = $project_identifier;
        if($request->has('enabled_module_names')){
            try {
                // removemos da base dados todos modulos do projecto que nao estao na lista do request
                EnabledModules::whereNotIn('name', $request->enabled_module_names)->where('project_id', $project_identifier->id)->delete();
                foreach ($request->enabled_module_names as $module) {
                    // Check is model exist
                    $is_model_avalible = EnabledModules::where('name', $module)->where('project_id', $project_identifier->id)->first();
                    if ($is_model_avalible) {
                        // return $module;
                    } else {
                        // create new EnabledModules resource
                        $enabled_module = new EnabledModules();

                        $enabled_module->project_id = $project_identifier->id;
                        $enabled_module->name = $module;
                        $enabled_module->save(); // Save data into database
                    }
                }
                return back()->with('success', __('lang.notice_successful_update'));
            } catch (\Throwable $th) {
                throw $th;
                return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            }
        }else{
            try {
                EnabledModules::where('project_id', $project_identifier->id)->delete();
                return back()->with('success', __('lang.notice_successful_update'));
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    /**
     * Create/Update Project Trackers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $project_identifier
     * @return \Illuminate\Http\Response
     */
    public function project_tracker(Request $request, Projects $project_identifier)
    {
        $project = $project_identifier;
        // return $project;
        if ($request->has('enabled_project_tracker')) {
            try {
                // removemos da base dados todos modulos do projecto que nao estao na lista do request
                ProjectTrackers::whereNotIn('tracker_id', $request->enabled_project_tracker)->where('project_id', $project->id)->delete();
                foreach ($request->enabled_project_tracker as $tracker_id) {
                    // Check is model exist
                    $is_tracker_avalible = ProjectTrackers::where('tracker_id', $tracker_id)->where('project_id', $project->id)->first();
                    if ($is_tracker_avalible) {
                        // return $module;
                    } else {
                        // create new Trackers_Projects resource
                        $enabled_project_tracker = new ProjectTrackers();
                        $enabled_project_tracker->project_id = $project->id;
                        $enabled_project_tracker->tracker_id = $tracker_id;
                        $enabled_project_tracker->save(); // Save data into database
                    }
                }
                return back()->with('success', __('lang.notice_successful_update'));
            } catch (\Throwable $th) {
                throw $th;
                return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            }
        } else {
            try {
                ProjectTrackers::where('project_id', $project->id)->delete();
                return back()->with('success', __('lang.notice_successful_update'));
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}
