<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Issues;
use App\Models\Members;
use App\Models\Projects;
use App\Models\Trackers;
use App\Models\CustomFields;
use App\Models\CustomValues;
use App\Models\EnabledModules;
use App\Models\ProjectTrackers;
use App\Myclass\TreeView;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProjectMembersResource;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Helpers\ModulesHelper;
use App\Http\Controllers\Helpers\ProjectsHelper;
use App\Http\Controllers\Helpers\TrackersHelper;
use App\Http\Controllers\EnabledModulesController;
use App\Http\Controllers\Helpers\CustomFieldsHelper;

class ProjectsController extends Controller
{

    // use CustomFiedls Helper trait
    use CustomFieldsHelper, ProjectsHelper, ModulesHelper, TrackersHelper;

    protected $tracked_task = array();
    protected $project;
    protected $sub_project = array();
    protected $projectIssues = array();
    protected $modules;
    protected $Custom_field_type = "ProjectCustomField";
    protected $type = "Project";
    protected $roles_permissions;

    public function __construct()
    {
        $this->modules = new EnabledModulesController();
    }

    /**
     * Set User Roles Permissions
     * Return users permissions
     * @return users Permissions if avalible ?? null
     */
    private function user_roles_permissions($project_id)
    {
        $is_member = auth()->user()->member_roles()->where('project_id', $project_id)->first();
        return $this->roles_permissions = Yaml::parse($is_member['member_roles']['roles'][0]['permissions'] ?? '');
    }

    private function enabledModules()
    {
        return $this->modules->enabledModules($this->project);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // return Projects::where("status", 1)->limit(10)->get();

        $projects_status = $request->has('closed') ? 5 : 1;

        if ($request->has('closed')) {
            $projects = Projects::where(function ($q) {
                $q->where('status', 1)->orWhere('status', 5);
                $q->Where('type', 'Program');
            })->orderby('name', 'asc')->get();
        } else {
            $projects = Projects::where('status', 1)->where(function ($q) {
                $q->Where('type', 'Program');
            })->orderby('name', 'asc')->get();
        }
        $data = array(
            'projects' => TreeView::makeview($projects),
        );


        // return $projects;
        // return view('projects.index', ['data' => $data]);
        return view("projects._leanView", compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('cadastrar_projectos', Projects::class)) {
            abort(401);
        }

        try {
            $parent = Projects::select('id', 'name', 'type', 'identifier')->where('identifier', request('parent'))->firstOrFail();
        } catch (\Throwable $th) {
            throw $th;
        }
        // return request();

        $projects = Projects::select('id', 'name')->where('type', '!=', 'Program')->where('status', 1)->get();
        $programs = Projects::select('id', 'name')->where('type', 'Program')->where('status', 1)->get();

        $_custom_fields = CustomFields::select('*')->where('type', $this->Custom_field_type)->get();
        $custom_fields = $this->custom_field_tag_with_label(null, [], $_custom_fields);
        // $custom_fields = $this->custom_field_tag_with_label($user->id, $user->custom_values()->get(), $_custom_fields);

        // return $programs;
        return view('projects.new', compact('projects', 'custom_fields', 'programs', 'parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('cadastrar_projectos', Projects::class)) {
            abort(401);
        }

        // Primeiro vamos validar o request
        $request->validate([
            'project.name' => 'required',
            'project.identifier' => 'required',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
            //'max' => __('lang.long_wrong_length')
        ], [
            'project.name' => __('lang.field_name'),
        ]);

        $project_parent = null;
        if (request()->has('parent')) {
            try {
                $project_parent = Projects::where('identifier', $request->parent)->firstOrFail();
            } catch (\Throwable $th) {
                throw ValidationException::withMessages(['project_parent' => 'O projeto que você está tentando acessar não exite ou foi removido.']);
            }
        } else {
            throw ValidationException::withMessages(['project_parent' => 'Não encontramos nenhum identificador no request para associar com este projecto.']);
        }

        // return $request;
        try {
            DB::beginTransaction();
            // Create new project Resource
            $project = new Projects();

            $project->name = preg_replace('/[^\w\s]/m', '-', $request->project['name']);
            $project->description = $request->project['description'];
            $project->identifier = $request->project['identifier'];
            $project->is_public = $request->project['is_public'];
            $project->inherit_members = request()->has('project.inherit_members') ? $request->project['inherit_members'] : 0;
            $project->parent_id = $project_parent->id;
            $project->type = $this->type;
            $project->author_id = Auth::user()->id;
            $project->start_date = $request->project['start_date'];
            $project->due_date = $request->project['due_date'];
            $project->created_on = now();
            $project->updated_on = now();
            $project->save(); // Save data into database

            // Segundo - Cadastramos os dados de todos os campos personalizados
            $this->store_custom_fildes_values($request['custom_field_values'], $project->id, 'Project');
            // Verificamos se o projecto criado vai herdar o membros do pai caso este tenha sido especificado

            if (request()->has('project.inherit_members')) {
                if ($request->project['parent_id'] && $request->project['inherit_members']) {
                    // Cadastramos os dados dos modulos selecionados
                    $this->inherit_members($request->project['parent_id'], $project->id);
                }
            }

            // Gravar modulos selecionados
            // $this->storeModules($request->project['enabled_module_names'], $project->id);
            $this->add_default_modules($project->id);
            // Add default project trackers
            $this->add_default_tracker($project->id, "Project");


            DB::commit();
            return redirect()->route('projects.overview', ['project_identifier' => $project->identifier])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('projects.new', ['parent' => $project_parent->identifier])->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $project_identifier)
    {

        $this->project = $project_identifier;
        $this->enabledModules();

        $project_identifier->parent;
        $project_identifier->issues;
        $project_identifier->issue_custom_fields;
        $project_identifier->members;
        $project_identifier->project_trackers;

        $custom_fields = CustomFields::select('*')->where('type', 'ProjectCustomField')->get();

        $project_identifier->custom_field_values = $this->custom_field_tag_with_label(
            $project_identifier->id,
            $project_identifier->custom_field_values()->get(),
            $custom_fields
        );

        $project = $project_identifier;
        $project->childs;

        $project_trackers_overview = [];
        $_project_trackers_overview = [];
        foreach ($project->project_trackers()->get() as $tracker) {
            if ($tracker->tracker != null) {
                $project_trackers_overview[$tracker->tracker['name']] = $tracker->tracker != null ? $tracker->tracker($project->id)->first()['issues'] : [];
            }
        }

        foreach ($project_trackers_overview as $key => $tracker) {
            if ($key !== '') {
                // dd($project_trackers_overview);
                if (empty($tracker)) {
                    $_project_trackers_overview[$key]['tracker_id'] = $tracker['tracker_id'];
                }
                foreach ($tracker as $tracker_key => $tracker) {
                    $_project_trackers_overview[$key]['tracker_id'] = $tracker['tracker_id'];
                    $_project_trackers_overview[$key][$tracker['status']['is_closed']][] = $tracker['status'];
                }
            }
        }
        // return $_project_trackers_overview;
        $project->project_trackers_overview = $_project_trackers_overview;

        $indicators = $this->map_project_indicators_overview($project->issues()->with('indicators')->get());

        $project->indicators = $indicators;
        
        // dd($indicators);

        return view('projects.projecto', compact('project'));
    }


    public function map_project_indicators_overview($issues)
    {
        $_indicators = [];
        foreach ($issues as $key => $issue) {

            foreach ($issue->indicators as $indicator) {
                // $achived_indicator_value = $indicator->indicator_field->indicator_issue_values->time_entries_values;
                $achived_indicator_value = "---";
                if ($indicator->indicator_field->indicator_issue_values->meta_type !== 'text') {
                    $achived_indicator_value = $indicator->indicator_field->indicator_issue_values->time_entries_values->sum('value');
                }
            //    dd($issue);
                $_indicators[] = array(
                    'name' => $indicator['indicator_field']['name'],
                    'is_cumulative' => $indicator['indicator_field']['is_cumulative'],
                    'meta' => $indicator['indicator_field']['indicator_issue_values']['meta'],
                    'meta_type' => $indicator['indicator_field']['indicator_issue_values']['meta_type'],
                    'achived_value' => $achived_indicator_value,

                );
                // dd($_indicators);
                // $_indicators[$indicator['indicator_field']['name']][][] = array(
                //     'name' => $indicator['indicator_field']['name'],
                //     'is_cumulative' => $indicator['indicator_field']['is_cumulative'],
                //     'meta' => $indicator['indicator_field']['indicator_issue_values']['meta'],
                //     'meta_type' => $indicator['indicator_field']['indicator_issue_values']['meta_type'],
                //     'achived_value' => $achived_indicator_value,
                // );
            }
        }
        // dd($indicator);
        return $_indicators;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projects $project_identifier)
    {
        $project = $project_identifier;

        if (!auth()->user()->can('editar_projectos', [Projects::class, $project])) {
            abort(401);
        }

        // Primeiro vamos validar o request
        $request->validate([
            'project.name' => 'required',
            'project.identifier' => 'required',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
            'max' => __('lang.long_wrong_length')
        ], [
            'project.name' => __('lang.field_name'),
            'project.identifier' => __('lang.field_identifier'),
        ]);

        // return $request;
        // trait to handle exceptions
        try {
            DB::beginTransaction();
            // Create new project Resource
            $project->name = $request->project['name'];
            $project->description = $request->project['description'];
            $project->identifier = preg_replace('/[^\w\s]/m', '-',  $request->project['identifier']);;
            $project->is_public = $request->project['is_public'];
            $project->has_shared_budget = $request->project['has_shared_budget'];
            $project->inherit_members = request()->has('project.inherit_members') ? $request->project['inherit_members'] : 0;

            // $project->type = $this->type;
            $project->start_date = $request->project['start_date'];
            $project->due_date = $request->project['due_date'];
            $project->updated_on = now();

            if (request()->has('project.parent_id')) {
                $project->parent_id = (int) $request->project['parent_id'] == 0 ? null : (int) $request->project['parent_id'];
            } else {
                $project->parent_id = null;
            }

            if ($project->isDirty('name')) {
                // Primeiro vamos validar o request
                $request->validate([
                    'project.name' => 'unique:projects,name',
                    'project.identifier' => 'required',
                ], [
                    'unique' => __('lang.errors.messages.taken'),
                ], [
                    'project.name' => __('lang.field_name'),
                    'project.identifier' => __('lang.field_identifier'),
                ]);
            }

            $project->update(); // Save data into database

            if (request()->has('custom_field_values')) {
                // Segundo - Cadastramos os dados de todos os campos personalizados
                $this->update_project_custom_fildes_values($request['custom_field_values'], $project->id, 'Project');
            }
            // Verificamos se o projecto criado vai herdar o membros do pai caso este tenha sido especificado
            if (request()->has('project.inherit_members')) {
                if ($request->project['parent_id'] && $request->project['inherit_members']) {
                    // Cadastramos os dados dos modulos selecionados
                    $this->inherit_members($request->project['parent_id'], $project->id);
                }
            }

            DB::commit();
            return redirect()->route('projects.settings', ['project_identifier' => $project->identifier])->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('projects.new')->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        //
    }

    /**
     * Listar Sub Projectos - Project Childs
     */
    private function subProjects($parent_id)
    {
        $subProjects = Projects::where('status', true)->where('parent_id', $parent_id)->get();
        // $this->sub_project = $subProjects;

        if (\sizeof($subProjects) > 0) {
            foreach ($subProjects as $subProject) {
                $this->sub_project[$subProject->identifier] = $this->subProjects($subProject->id);
            }
            // $this->sub_project = $this->sub_project;
        }
        return $this->sub_project;
    }

    /**
     * Gravar os modulos selecionados
     */
    private function storeModules(array $selected_models, $project_id)
    {
        try {

            foreach ($selected_models as $module) {
                // Create new EnabledModules Resource
                $enabled_modules = new EnabledModules();
                $enabled_modules->project_id = $project_id;
                $enabled_modules->name = $module;
                $enabled_modules->save(); // Save data into database
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Cadastrar heranca de membros do projecto pai
     */
    private function inherit_members($parent_id, $project_id)
    {
        // Primeiro pegamos o membros do projecto pai
        foreach (Members::where('project_id', $parent_id)->get() as $member) {
            try {
                // Create new Members Resource
                $child_members = new Members();
                $child_members->user_id = $member->user_id;
                $child_members->project_id = $project_id;
                $child_members->created_on = now();
                $child_members->mail_notification = $member->mail_notification;
                $child_members->save(); // Save data into database
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    /**
     * Cadastrar os tracker do projecto
     */

    private function project_trackers($project_id, array $trackers)
    {
        foreach ($trackers as $tracker) {
            try {
                // Create new Project Trackers Resource
                $project_tracker = new ProjectTrackers();
                $project_tracker->project_id = $project_id;
                $project_tracker->tracker_id = $tracker;
                $project_tracker->save(); // Save data into database
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    /**
     * Request project action
     * Fechar, Arquivar e Reabir Projecto
     */
    public function request_action(Projects $project_identifier, $action)
    {
        // return $this->action($action);
        $this->authorize('arquivar_projecto', $project_identifier);
        return $this->action_confirmation($project_identifier, $this->action($action));
    }

    /**
     * Realizar a action confirmada pela usuario
     */
    public function run_action(Projects $project_identifier, $action)
    {
        $this->authorize('arquivar_projecto', $project_identifier);
        return $this->chenge_project_status($project_identifier, $action);
    }


    /**
     * Api section
     */
}
