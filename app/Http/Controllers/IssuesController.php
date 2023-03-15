<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Issues;
use App\Models\Queries;
use App\Models\Journals;
use App\Models\Projects;
use App\Models\Trackers;
use App\Myclass\TreeView;
use Illuminate\Support\Str;
use App\Models\CustomFields;
use Illuminate\Http\Request;
use App\Models\AprovacaoFundos;
use App\Models\ProjectTrackers;
use Symfony\Component\Yaml\Yaml;
use App\Models\IndicatorRelation;
use Illuminate\Support\Facades\DB;
use App\Models\IssuesBeneficiarios;
use Illuminate\Support\Facades\Log;
use App\Models\CustomFieldsTrackers;
use App\Models\ApprovementFlowModels;
use App\Events\IssuesNotificationEvent;
use App\Http\Controllers\QueriesController;
use App\Http\Controllers\Helpers\IssuesHelper;
use App\Events\ApprovementFlowNotificationEvent;
use App\Http\Controllers\Helpers\WatchersHelper;
use App\Http\Controllers\EnabledModulesController;
use App\Http\Controllers\Helpers\AttachmentsHelper;
use App\Http\Controllers\Helpers\IndicatoresHelper;
use App\Http\Controllers\Helpers\CustomFieldsHelper;
use App\Http\Controllers\Helpers\ApprovementFlowHelper;

class IssuesController extends Controller
{
    use IndicatoresHelper, WatchersHelper, IssuesHelper, ApprovementFlowHelper, AttachmentsHelper;
    //
    protected $project_identifier;
    protected $enabled_modules;
    protected $project_id;
    protected $modules;
    protected $query_parameters;
    protected $Queries;
    protected $cf_name;
    protected $cf_id;

    public function __construct()
    {
        $this->modules = new EnabledModulesController();
        $this->Queries = new QueriesController();
    }

    private function enabledModules()
    {
        // return $this->modules->enabledModules($this->project_id);
    }

    private function getProject($project_identifier)
    {
        $project = Projects::where('status', true)->where('identifier', $project_identifier)->orderby('name', 'desc')->first();
        return $project;
    }
    private function getProjectbyID($project_id)
    {
        $project = Projects::where('status', true)->where('id', $project_id)->orderby('name', 'desc')->first();
        return $project;
    }

    /**
     * App Issues
     */
    public function issues()
    {
        $issues = Issues::select('issues.id', 'issues.project_id', 'enumerations.name as priority', 'trackers.name as tracker', 'subject', 'issues.author_id', 'users.firstname as author_firstname', 'users.lastname as author_lastname', 'assigned_to_id', 'issues.status_id', 'issues.start_date', 'issues.due_date', 'issues.updated_on', 'issues.is_aproved')
            ->join('users', 'users.id', 'author_id')
            ->join('enumerations', 'enumerations.id', 'priority_id')
            ->join('trackers', 'trackers.id', 'tracker_id')
            ->join('projects', 'projects.id', 'issues.project_id')
            // ->where('status_id', true)
            ->where('enumerations.type', 'IssuePriority')
            ->with('project')
            ->where('projects.deleted_at', '=', null)
            //->orderby('trackers.position', 'asc')
            ->orderby('issues.updated_on', 'desc')
            ->paginate(30)->onEachSide(5);

        $this->project_id = null;
        // $issues->project;
        $i = 0;
        foreach ($issues as $issue) {
            $assined_to = User::select('firstname', 'lastname')
                ->where('id', $issue->assigned_to_id)
                ->first();

            $issues[$i]['tipo'] = $issue->tracker;
            $issues[$i]['assined_to'] = $assined_to;
            $issues[$i]['issue_start_at'] = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->start_date)->formatLocalized('%d %b %Y')));
            $issues[$i]['issue_end_at'] = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->due_date)->formatLocalized('%d %b %Y')));
            $issues[$i]->updated_at = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->updated_on)->formatLocalized('%d %b %Y %H:%M')));
            ++$i;
        }

        $data = array(
            'queries' => $this->queries(null, null),
            // 'projecto' => $this->getProject($project_identifier),
            'tracker' => false,
            'issues' => $issues,
        );

        // return $data;
        return view('issues.issues', ['data' => $data]);
    }


    /**
     * Show all issue for the project
     */
    public function index(Projects $project_identifier, Request $request)
    {
        if (isset($request->query_id)) {

            try {
                $query_parameters = $this->queries($request->query_id, $project_identifier->id);
            } catch (\Throwable $th) {
                // throw $th;

                if ($th->getMessage() == 'No query results for model [App\Models\Queries].') {
                    return view('issues.index', ['data' => [], 'notFound' => 'A página que está a tentar aceder não existe ou foi removida.']);
                } else {
                    return view('errors.internal');
                }
            }

            $queryHelper = $this->Queries->builder($query_parameters);

            // return $query_parameters;

            $columns = $queryHelper['selectable_columns'];
            $custom_fields = $queryHelper['custom_fields'];
            $filters = $queryHelper['filters'];
            $sort_criteria = $queryHelper['sort_criteria'];

            // return $queryHelper;

            $issues = Issues::select($columns);

            $issues->join('trackers', 'trackers.id', 'tracker_id');
            $issues->join('users', 'users.id', 'author_id');
            $issues->join('enumerations', 'enumerations.id', 'priority_id');
            $issues->join('issue_statuses', 'issue_statuses.id', 'status_id');
            $issues->join('projects', 'projects.id', 'issues.project_id');

            foreach ($custom_fields as $cf) {
                $this->cf_name = $cf['name'];
                $this->cf_id = $cf['id'];
                $issues->leftjoin("custom_values as $this->cf_name", function ($join) {
                    $join->on($this->cf_name . '.customized_id', '=', 'issues.id')
                        ->where($this->cf_name . '.customized_type', 'Issue')
                        ->where($this->cf_name . '.custom_field_id', $this->cf_id);
                });
            }

            $issues->where('issues.project_id', $project_identifier->id);
            $issues->where('issues.project_id', $project_identifier->id);
            $issues->whereRaw($filters);
            $issues->limit(30);
            $issues->orderby($sort_criteria[1], $sort_criteria[2]);
            // $issues->get();

            // return $issues->toSql();

            $data = array(
                'queries' => $this->queries(null, $project_identifier->id),
                'projecto' => $this->getProject($project_identifier),
                'columns' => $columns,
                'tracker' => false,
                'issues' => $issues->paginate(30)->onEachSide(5),
                'table' => $queryHelper['table'],
            );

            // return $data;
            return view('issues.index', ['data' => $data]);
        } else {

            $issues = Issues::select('issues.id', 'enumerations.name as priority', 'trackers.name as tracker', 'subject', 'author_id', 'users.firstname as author_firstname', 'users.lastname as author_lastname', 'assigned_to_id', 'status_id', 'start_date', 'due_date', 'issues.updated_on', 'issues.is_aproved')
                ->join('users', 'users.id', 'author_id')
                ->join('enumerations', 'enumerations.id', 'priority_id')
                ->join('trackers', 'trackers.id', 'tracker_id')
                // ->where('status_id', true)
                ->where('enumerations.type', 'IssuePriority')
                ->where('issues.project_id', $project_identifier->id)
                //->orderby('trackers.position', 'asc')
                ->orderby('issues.created_on', 'desc')
                ->paginate(30)->onEachSide(5);

            $i = 0;
            foreach ($issues as $issue) {
                $assined_to = User::select('firstname', 'lastname')
                    // ->where('status', true)
                    ->where('id', $issue->assigned_to_id)
                    ->first();
                $issues[$i]['tipo'] = $issue->tracker;
                $issues[$i]['assined_to'] = $assined_to;
                $issues[$i]['issue_start_at'] = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->start_date)->formatLocalized('%d %b %Y')));
                $issues[$i]['issue_end_at'] = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->due_date)->formatLocalized('%d %b %Y')));
                $issues[$i]->updated_at = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->updated_on)->formatLocalized('%d %b %Y %H:%M')));
                ++$i;
            }
        }

        $data = array(
            'projecto' => $this->getProject($project_identifier),
            'tracker' => false,
            'issues' => $issues,
            'queries' => $this->queries(null, $project_identifier->id)
        );

        // return $data;
        return view('issues.index', ['data' => $data]);
    }

    /**
     * Mostra as issues de um projecto by tracker
     */
    public function getIssues(Projects $project_identifier, $tracker, Request $request)
    {

        $this->project_identifier = $project_identifier;
        $getTracker = Trackers::select('name')->where('id', $tracker)->first();

        $issues = Issues::select('issues.id', 'enumerations.name as priority', 'subject', 'author_id', 'users.firstname as author_firstname', 'users.lastname as author_lastname', 'assigned_to_id', 'status_id', 'issues.updated_on', 'issues.is_aproved')
            ->join('users', 'users.id', 'author_id')
            ->join('enumerations', 'enumerations.id', 'priority_id')
            // ->where('status_id', true)
            ->join('trackers', 'trackers.id', 'tracker_id')
            ->where('enumerations.type', 'IssuePriority')
            ->where('tracker_id', $tracker)
            ->where('issues.project_id', $project_identifier->id)
            // ->orderby('trackers.position', 'asc')
            ->orderby('issues.updated_on', 'desc')
            ->paginate(30)->onEachSide(5);

        $i = 0;
        foreach ($issues as $issue) {
            $assined_to = User::select('firstname', 'lastname')
                // ->where('status', true)
                ->where('id', $issue->assigned_to_id)
                ->first();
            $issues[$i]['tipo'] = $getTracker->name;
            $issues[$i]['assined_to'] = $assined_to;
            $issues[$i]['issue_start_at'] = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->start_date)->formatLocalized('%d %b %Y')));
            $issues[$i]['issue_end_at'] = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->due_date)->formatLocalized('%d %b %Y')));
            $issues[$i]->updated_at = utf8_encode(ucwords(\Carbon\Carbon::parse($issue->updated_on)->formatLocalized('%d %b %Y %H:%M')));
            ++$i;
        }

        $data = array(
            'projecto' => $this->getProject($project_identifier),
            'tracker' => $getTracker,
            'issues' => $issues,
            'queries' => $this->queries(null, $project_identifier->id)
        );

        // return $data;
        return view('issues.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Projects $project_identifier = null)
    {
        if (!auth()->user()->can('add_issues', [Issues::class, $project_identifier])) {
            return abort(401);
        }
        $project = $project_identifier;
        $issue = [];
        return view('issues.new', compact('project', 'issue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Projects $project_identifier = null)
    {

        if ($project_identifier != null) {
            if (!auth()->user()->can('add_issues', [Issues::class, $project_identifier])) {
                return abort(401);
            }
        }


        $request->validate([
            'issue.type' => 'required',
            'issue.title' => 'required|max:254',
            'issue.status' => 'required|int',
            'issue.priority' => 'required|int',
        ], [
            'required' => __('lang.errors.messages.required'),
            'max' => __('lang.errors.messages.max')
        ], [
            'issue.type' => __('lang.field_type'),
            'issue.title' => __('lang.field_title'),
            'issue.status' => __('lang.field_status'),
            'issue.priority' => __('lang.field_priority')
        ]);

        if ($request->has('indicadores')) {
            // $this->validate_indicator_fields_request($request['indicadores']);
        }

        try {

            DB::beginTransaction();

            $issue = new Issues();
            $issue->tracker_id = $request->issue['type'];
            $issue->project_id = $project_identifier['id'];
            $issue->subject = $request->issue['title'];
            $issue->description = $request->issue['description'] ?? null;
            // $issue->category_id = $request->issue[''];
            $issue->status_id = $request->issue['status'];
            $issue->assigned_to_id = $request->issue['assigned_to'] ?? auth()->user()->id; // Default assign task to user owner
            $issue->priority_id = $request->issue['priority'];
            $issue->author_id = auth()->user()->id;
            $issue->due_date = $request->issue['_due_date'] ?? null;
            $issue->start_date = $request->issue['_start_date'] ?? null;
            $issue->done_ratio = $request->issue['done_ratio'] ?? 0;
            $issue->estimated_hours = $request->issue['time_tracking'] ?? null;
            $issue->parent_id = $request->issue['parent_id'] ?? null;
            $issue->is_private = $request->issue['is_private'] ?? 0;
            $issue->is_aproved = false;
            $issue->created_on = now();
            $issue->updated_on = now();

            $issue->save(); // Save data into database
            // Segundo - Cadastramos os dados de todos os campos personalizados
            $this->store_custom_fildes_values($request['custom_field_values'] ?? [], $issue->id, 'Issue');
            // 3 - Cadastramos os dados de indicadores
            
            if ($request->has('indicadores')) {
                $this->store_indicators_fildes($request['indicadores'] ?? [], $issue->id,  $request->issue['type'], 'Issue', $project_identifier['type']);
            }

            // Gravar documentos de suporte
            if ($request->has('attachments')) {
                foreach ($request->attachments as $file) {
                    if ($file != null) {
                        $this->store_attachment($issue->id, $file['file'], "IssueAttachs");
                    }
                }
            }

            // Store Beneficiários
            if ($request->issue['type'] != 15) {
                if ($request->has('beneficiarios')) {
                    foreach ($request->beneficiarios as $key => $benf) {
                        foreach ($request->beneficiarios[$key] as $value) {
                            // Check if has already been stored. if not store
                            try {
                                $issues_beneficiarios = IssuesBeneficiarios::where('issue_id', $issue->id)
                                    ->where('type', $key)
                                    ->where('faixa_etaria', $value['faixa_etaria'])
                                    ->firstOrFail();
                            } catch (\Throwable $th) {
                                $issues_beneficiarios = new IssuesBeneficiarios();

                                $issues_beneficiarios->issue_id = $issue->id;
                                $issues_beneficiarios->type = $key;
                                $issues_beneficiarios->faixa_etaria = $value['faixa_etaria'];
                                $issues_beneficiarios->meta = $value['num'];
                                $issues_beneficiarios->realizado = 0;
                                $issues_beneficiarios->author_id = auth()->user()->id;
                                $issues_beneficiarios->created_on = now();
                                $issues_beneficiarios->updated_on = now();

                                $issues_beneficiarios->save(); // Save data into database
                            }
                        }
                    }
                }
            }
           
            $user = User::where("id", auth()->user()->id)->with('member_roles')->firstOrFail();
            
            
            // Check if trackers uses an workflow and init if true
            $issue_tracker = Trackers::where("id", $issue->tracker_id)->firstOrFail();
           
            if ($issue_tracker->use_workflow) {
                /**
                 * check if exist approvement_flow triggered on task store
                 */
               
                if($user->member_roles[0]->member_roles->roles[0]->name == 'Facilitador Distrital'){
                    $getTigger = $this->ExistApprovementTriggerOnNewResource($issue_tracker->assined_workflow_tag);
                    //dd($getTigger);
                } else{
                    $getTigger = $this->ExistApprovementTriggerResource($issue_tracker->assined_workflow_tag);
                    //dd('Folege');
                }
                if ($getTigger->status) {
                    // Store workflow initial step
                    $StoreTriggeredApprovementFlow = $this->StoreTriggeredApprovementFlow($getTigger->trigger, $issue);
                    // store the user to approve the current workflow step
                   
                    $this->StoreUserApprovementRequest($StoreTriggeredApprovementFlow);
                   
                    // preventing notification error to stop issue storage
                    try {
                        //Send notification email to the user to approve the flow process step
                        event(new ApprovementFlowNotificationEvent(
                            auth()->user(),
                            $issue,
                            $StoreTriggeredApprovementFlow,
                            $this->email_content($issue)
                        ));
                    } catch (\Throwable $_th) {
                        Log::alert([
                            "message" => "Email Notification send failed",
                            "envet" => "StoreApprovementRequest",
                            "class" => ApprovementFlowNotificationEvent::class,
                            "Error" => $_th->getMessage()
                        ]);
                    }
                }
            }
            
            if (!$request->has('issue.init_approvement_flow') && (int)$request->issue['type'] == 14) {
                $issue->status_id = 2;
                $issue->save(); // Save data into database
            }

            if ((int)$request->issue['type'] !== 6 /*&& (int)$request->issue['type'] !== 15*/) {
                $issue->is_aproved = true;
                $issue->save(); // Save data into database
            }
            
            // Enviar email de criacao de tarefa para o user que criou a terfa com sucesso
            
           /* event(new IssuesNotificationEvent(
                $issue,
                auth()->user(),
                $this->new_issue_notification_content($issue),
                time() . " - Nova Tarefa Criada com sucesso",
                ['to_author']
            ));*/
    
            DB::commit();
            
            return redirect()->route('issues.show', ['issue' => $issue->id])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();

            if ($th->getCode() == 10701) {
                return back()->with('error', $th->getMessage());
            }
            // return back()->with('error', 'Ocorreu um erro ao gravar os dados! RF007x0001 Validação de dados / cadastro da issue. <br><b>Detailhes do Erro</b>: ' . $th->getMessage());
            throw $th;
        }
    }

    /**
     * Return email content
     */
    protected function email_content($issue)
    {
        $start_date = $issue->start_date ?? 'dd-mm-yyyy';

        $content = "Foi criada uma tarefa: <a href='" . route('issues.show', ['issue' => $issue->id]) . "'>" . $issue->subject . "</a> no projecto <a href='" . route('projects.overview', ['project_identifier' => $issue->project->identifier]) . "' target='_blank'>" . $issue->project->name . "</a> a decorrer (" . $start_date . "), criada por <i>" . $issue->author->full_name . "</i>. Para *Revisão da Solicitacao da aprovação* - <a href='" . route('orcamento.projecto.solicitacao-fundos.show', ['project_identifier' => $issue->project->identifier, 'issue' => $issue->id]) . "' target='_blank'>clique aqui</a>.";

        return $content;
    }

    /**
     * New Task Notification Content
     *@return string
     */
    private function new_issue_notification_content($issue)
    {
        $start_date = $issue->start_date ?? 'dd-mm-yyyy';

        return "Criou a tarefa: <a href='" . route('issues.show', ['issue' => $issue->id]) . "'>" . $issue->subject . "</a> no projecto <a href='" . route('projects.overview', ['project_identifier' => $issue->project->identifier]) . "' target='_blank'>" . $issue->project->name . "</a> a decorrer (" . $start_date . ").";
    }

    /**
     * Mostra deltalhes de uma issue - projecto
     */
    public $parent_issue;
    public function show(Issues $issue)
    {
        if (!auth()->user()->can('view_issues', [Issues::class, $issue->project])) {
            return abort(401);
        }

        $issue->project;
        $issue->tracker;
        $issue->author;
        $issue->watchers;
        $indicators = $issue->indicators;

        $tracker_custom_fields = CustomFieldsTrackers::where('tracker_id', $issue->tracker->id)
            ->with('custom_field')
            ->get()->toArray();

        $_custom_fields = [];
        foreach ($tracker_custom_fields as $key => $custom_fields) {
            $_custom_fields[] = $custom_fields['custom_field'];
        }
        $custom_field_values = $this->custom_field_tag_with_label(
            $issue->id,
            $issue->custom_field_values,
            $_custom_fields
        );

        // return $custom_field_values;
        // return $indicators;

        $this->parent_issue = $issue->id;

        // return $issue->project_trackers;

        $trackers = $this->projecttrackers($issue->project_id);

        // get Project issue structer
        $parent_id = $issue->parent_id;
        $issues = array(
            $issue
        );


        $start_date = $issue->start_date != null ? utf8_encode(ucwords(\Carbon\Carbon::parse($issue->start_date)->formatLocalized('%d %B %Y'))) : null;
        $due_date = $issue->due_date != null ? utf8_encode(ucwords(\Carbon\Carbon::parse($issue->due_date)->formatLocalized('%d %B %Y'))) : null;

        $data_issues = array(
            'id' => $issue->id,
            'parent_id' => $issue->parent_id,
            'project' => $issue->project,
            'subject' => $issue->subject,
            'description' => $issue->description,
            'author_id' => $issue->author_id,
            'tracker_id' => $issue->tracker_id,
            'user_path' => '/users/' . $issue->author_id,
            'author_firstname' => $issue->author['firstname'],
            'author_lastname' => $issue->author['lastname'],
            'assigned_to' => $issue->assignedTo,
            'issue_start_at' =>  $start_date,
            'issue_end_at' => $due_date,
            'issue_status' => $issue->status->name,
            'issue_priority' => $issue->priority->name,
            'isWhatcked' => $issue->isWhatcked == null ? false : true,
            'done_ratio' => $issue->done_ratio,
            'estimated_hours' => \number_format(($issue->estimated_hours), 2),
            'created_on' => $issue->created_on->diffForHumans(),
            'updated_on' => $issue->updated_on->diffForHumans(),
            'is_aproved' => $issue->is_aproved,
            'aproved_by' => $issue->aprovado_por,
            'aproved_on' => $issue->aproved_on,
            'status_id' => $issue->status_id,
            // 'updated_on' => ucwords(\Carbon\Carbon::parse($issue->updated_on)->formatLocalized('%d %B %Y')),
            '_time' => $issue->created_on->diffForHumans(),
            'isInitApproval' => $issue->isInitApproval(),
            'attachments' => $issue->attachments,
            'beneficiarios' => $issue->beneficiarios
        );

        /**
         * get Historic updated from Journalized issues
         */

        $journalized = Journals::select('*', 'journals.id as id', 'journals.created_on as created_on')
            ->leftjoin('journal_details', 'journal_details.journal_id', 'journals.id')
            ->join('users', 'users.id', 'user_id')
            ->where('journalized_type', 'Issue')
            ->where('journals.journalized_id', $issue->id)
            ->get();


        $journals = $this->jounalized_values_with_labels($journalized);
        // return $journals;

        foreach ($trackers as $tracker) {
            $issuesTrackers = Issues::select('issues.id', 'project_id', 'parent_id', 'tracker_id', 'root_id', 'name as tracker', 'subject')
                ->join('trackers', 'trackers.id', 'tracker_id')
                ->where('issues.id', $parent_id)
                ->first();

            if ($issuesTrackers) {
                $parent_id = $issuesTrackers->parent_id;
                $issues = array(
                    $issuesTrackers
                );
            }
        }

        $queries = $this->queries(null, $issue->project_id);
        // return $queries;
        $data = array(
            'projecto' => $issue->project,
            'issue_id' => $issue->id,
            'tracker' => $issue->tracker->name,
            'tracker_id' => $issue->tracker_id,
            'issue' => $data_issues,
            'journals' => $journals,
            'issues' => TreeView::makeview($issues),
            'issues_info' => TreeView::makeview($this->issues_childs($issue->id)),
            'queries' => $queries,
            'is_watcher' => $issue->is_watcher ? true : false,
            'watchers' => $issue->watchers,
        );

        // return $issue;
        // return $data;
        return view('issues.show', ['data' => $data, 'notFound' => false, 'indicators' => $indicators, 'custom_field_values' => $custom_field_values]);
    }




    /**
     * Display issue edit from
     */
    public function edit(Issues $issue)
    {
        if (!auth()->user()->can('edit_issues', [Issues::class, $issue->project])) {
            return abort(401);
        }
        $issue->project;
        $issue->tracker;
        $issue->author;
        $issue->custom_field_values;
        $issue->is_watcher = $issue->is_watcher == null ? false : true;
        $issue->beneficiarios;

        $indicators = [];
        foreach ($issue->indicators()->get() as $indicator) {

            $indicator_relation = IndicatorRelation::where('child', $indicator->indicator_field['id'])
                ->where('relationed_by', $issue->id)
                ->first();

            $indicators[] = array(
                'related_to' => $indicator_relation['parent'] ?? null,
                'pri_relation_id' => $indicator_relation['pri_parent'] ?? null,
                'indicator_isNew' => false,
                'indicator_id' => $indicator->indicator_field['id'],
                'indicator_name' => $indicator->indicator_field['name'],
                'indicator_value' => $indicator->indicator_field->indicator_issue_values['value'],
                'indicator_type' => $indicator->indicator_field['is_cumulative'],
                'meta_value' => $indicator->indicator_field->indicator_issue_values['meta'],
                'm_trim_01' => $indicator->indicator_field->indicator_issue_values['m_trim_01'],
                'm_trim_02' => $indicator->indicator_field->indicator_issue_values['m_trim_02'],
                'm_trim_03' => $indicator->indicator_field->indicator_issue_values['m_trim_03'],
                'm_trim_04' => $indicator->indicator_field->indicator_issue_values['m_trim_04'],
                'meta_type' => $indicator->indicator_field->indicator_issue_values['meta_type'],
                'fonte_ver' => $indicator->indicator_field->indicator_issue_values['fonte_ver'],
                'base_ref' => $indicator->indicator_field->indicator_issue_values['base_ref'],
            );
        }

        // return $indicators;
        $issue->indicators = $indicators;
        //return $issue;
        return view('issues.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IssueStatuses  $issueStatuses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issues $issue)
    {
        // return $request;

        if (!auth()->user()->can('edit_issues', [Issues::class, $issue->project])) {
            return abort(401);
        }

        if (!$issue->is_aproved) {
            // Validar o Request
            $request->validate([
                'issue.type' => 'required',
                'issue.title' => 'required|max:254',
                'issue.status' => 'required|int',
                'issue.priority' => 'required|int',
            ], [
                'required' => __('lang.errors.messages.required'),
                'max' => __('lang.errors.messages.max')
            ], [
                'issue.type' => __('lang.field_type'),
                'issue.title' => __('lang.field_title'),
                'issue.status' => __('lang.field_status'),
                'issue.priority' => __('lang.field_priority')
            ]);
        }

        if ($request->has('indicadores')) {
            // return $request;
            // $this->validate_indicator_fields_request($request['indicadores']);
        }

        // Iniciar o procedimento de actualizacao de dados na DB
        // return $request;
        try {
            DB::beginTransaction();

            $old_title = $issue->subject;

            if (!$issue->is_aproved || $request->issue['type']) {
                $old_title = $issue->subject;

                $issue->subject = $request->issue['title'];
                $issue->priority_id = $request->issue['priority'];
                $issue->status_id = $request->issue['status'];
                // $issue->assigned_to_id = $request->issue['assigned_to'] ?? null;
                $issue->tracker_id = $request->issue['type'];

                $request->has('issue.description') ? $issue->description = $request->issue['description'] : $issue->description;
                $request->has('issue.description') ? $issue->description = $request->issue['description'] : $issue->description;
                $request->has('issue.start_date') ? $issue->start_date = $request->issue['start_date'] : $issue->start_date;
                $request->has('issue.due_date') ? $issue->due_date = $request->issue['due_date'] : $issue->due_date;
                $request->has('issue.time_tracking') ? $issue->estimated_hours = $request->issue['time_tracking'] : $issue->estimated_hours;
                $issue->is_private = $request->issue['is_private'] ?? 0;


                // Journals
                if ($issue->isDirty('subject')) {
                    $this->jornalize_attr_changes($issue, $request->issue['title'], 'subject', 'Issue');
                }
                if ($issue->isDirty('description')) {
                    $this->jornalize_attr_changes($issue, $request->issue['description'], 'description', 'Issue');
                }
                if ($issue->isDirty('priority_id')) {
                    $this->jornalize_attr_changes($issue, $request->issue['priority'], 'priority_id', 'Issue');
                }
                if ($issue->isDirty('status_id')) {
                    $this->jornalize_attr_changes($issue, $request->issue['status'], 'status_id', 'Issue');
                }

                if ($issue->isDirty('tracker_id')) {
                    $this->jornalize_attr_changes($issue, $request->issue['type'], 'tracker_id', 'Issue');
                }
                if ($issue->isDirty('start_date')) {
                    $this->jornalize_attr_changes($issue, $request->issue['start_date'], 'start_date', 'Issue');
                }
                if ($issue->isDirty('due_date')) {
                    $this->jornalize_attr_changes($issue, $request->issue['due_date'], 'due_date', 'Issue');
                }

                if ($issue->isDirty('estimated_hours')) {
                    $this->jornalize_attr_changes($issue, $request->issue['time_tracking'], 'time_tracking', 'Issue');
                }
                if ($issue->isDirty('is_private')) {
                    $this->jornalize_attr_changes($issue, $request->issue['is_private'], 'is_private', 'Issue');
                }

                if ($request->has('issue.notes') && $request->issue['notes'] != null) {
                    $this->jornalize_attr_changes($issue, $request->issue['notes'], 'notes', 'Issue', 'attr', true);
                }

                // Segundo - Atualizamos os dados de todos os campos personalizados
                $this->update_custom_fildes_values($request['custom_field_values'] ?? [], $issue->id, 'Issue');
            }

            $request->has('issue.assigned_to') ? $issue->assigned_to_id = $request->issue['assigned_to'] : $issue->assigned_to_id;
            if ($issue->isDirty('assigned_to_id')) {
                $this->jornalize_attr_changes($issue, $request->issue['assigned_to'], 'assigned_to_id', 'Issue');
            }

            $request->has('issue.done_ratio') ? $issue->done_ratio = $request->issue['done_ratio'] : $issue->done_ratio;
            if ($issue->isDirty('done_ratio')) {
                $this->jornalize_attr_changes($issue, $request->issue['done_ratio'], 'done_ratio', 'Issue');
            }


            $issue->updated_on = now();
            $issue->update(); // Save data into database

            // 3 - Cadastramos os dados de indicadores
            $this->deleted_indicators($request['deleted_indicators']['ids'], $issue->id,  'Issue');

            if ($request->has('indicadores')) {
                if ($issue->is_aproved) {
                    $this->update_indicators_fildes_values($request['indicadores'] ?? [], $issue->id,  $request->issue['type'], 'Issue', $issue->project->type);
                } else {
                    $this->update_indicators_fildes_values($request['indicadores'] ?? [], $issue->id,  $request->issue['type'], 'Issue', $issue->project->type);
                }
            }

            // Gravar documentos de suporte de solicitação de fundos
            if ($request->has('attachments')) {
                foreach ($request->attachments as $file) {
                    if ($file != null) {
                        $this->store_attachment($issue->id, $file['file'], "IssueAttachs");
                    }
                }
            }


            // Store Beneficiários
            if ($request->issue['type'] != 15) {

                foreach ($request->beneficiarios as $key => $benf) {

                    foreach ($request->beneficiarios[$key] as $value) {
                        try {
                            $issues_beneficiarios = IssuesBeneficiarios::where('id', $value['_onStorageID'])
                                ->where('issue_id', $issue->id)
                                ->where('type', $key)
                                ->firstOrFail();

                            $issues_beneficiarios->faixa_etaria = $value['faixa_etaria'];
                            $issues_beneficiarios->meta = $value['num'];
                            $issues_beneficiarios->updated_on = now();

                            $issues_beneficiarios->update(); // Save data into database
                        } catch (\Throwable $th) {
                            $issues_beneficiarios = new IssuesBeneficiarios();

                            $issues_beneficiarios->issue_id = $issue->id;
                            $issues_beneficiarios->type = $key;
                            $issues_beneficiarios->faixa_etaria = $value['faixa_etaria'];
                            $issues_beneficiarios->meta = $value['num'];
                            $issues_beneficiarios->realizado = 0;
                            $issues_beneficiarios->author_id = auth()->user()->id;
                            $issues_beneficiarios->created_on = now();
                            $issues_beneficiarios->updated_on = now();

                            $issues_beneficiarios->save(); // Save data into database
                        }
                    }
                }
            }


            $title = "Tarefa: " . $old_title;

            $content = "Foram alterados dados da tarefa: <a href='" . route('issues.show', ['issue' => $issue->id]) . "'>" . $old_title . "</a> do projecto <a href='" . route('projects.overview', ['project_identifier' => $issue->project->identifier]) . "' target='_blank'>" . $issue->project->name . "</a>, a decorrer " . \Carbon\Carbon::parse($issue->start_date)->format('d-m-Y') . ", com sucesso. Para mais detalhes .<a href='" . route('issues.show', ['issue' => $issue->id]) . "'>click aqui</a> e veja a seção <i>Histórico</i>.";

            // Email para o author da tarefa
            event(new IssuesNotificationEvent($issue, auth()->user(), $content, $title, ['to_author']));

            DB::commit();
            return redirect()->route('issues.show', ['issue' => $issue->id])->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return back()->with('error', 'Ocorreu um erro no update de dados da tarefa!');
        }
    }

    /**
     * Custom Query isssue
     */
    private function queries($id = null, $project_id = null)
    {
        if ($id == null) {
            return array(
                'publicQueries' => Queries::select('id', 'name')
                    ->where('visibility', 2)
                    ->Where('project_id', $project_id)
                    ->orWhere('project_id', null)
                    ->orderby('project_id', 'desc')
                    ->get(),

                'userQueries' => Queries::select('id', 'name')->where('user_id', 67)
                    ->Where('project_id', $project_id)
                    ->orWhere('project_id', null)
                    ->where('visibility', 0)
                    ->orderby('project_id', 'desc')
                    ->get(),
            );
        } else {
            try {
                $query = Queries::where('id', $id)->firstOrFail();
            } catch (\Exception $th) {
                // throw $th;
                return back()->with('error', 'Error Processing Request!');
            }

            $columns = \str_replace(':', '', Yaml::parse($query->column_names));
            $filters = Yaml::parse($query->filters);
            $options = \str_replace(':draw_relations:', '---', Yaml::parse($query->options));
            $sort_criteria = \str_replace(':', '', Yaml::parse($query->sort_criteria));
            $sort_criteria =  \array_filter(\str_replace(' ', '', \explode('-', $sort_criteria[0])));

            $_options = array();
            $_filters = array();

            if (!is_array($options) || !is_array($filters)) {
                throw new Exception("Error Processing Request!\nWe have detected an error in you query.", 1);
            }

            foreach ($options as $key => $value) {
                $_options[\str_replace(':', '', $key)] = \str_replace(':', '', $value);
            }
            foreach ($filters as $pkey => $array) {
                foreach ($array as $key => $value) {
                    $_filters[$pkey][\str_replace(':', '', $key)] = \str_replace(':', '', $value);
                }
            }

            return array(
                // $query,
                'columns' => $columns,
                'filters' => $_filters,
                'options' => $_options,
                'sort_criteria' => $sort_criteria,
            );
        }
    }

    /**
     * get project trackers
     */
    private function projecttrackers($projecto)
    {
        return ProjectTrackers::select('tracker_id', 'name as tracker')
            ->join('trackers', 'trackers.id', 'tracker_id')
            ->where('project_id', $projecto)
            ->orderby('position', 'desc')
            ->get();
    }

    public $all_childs = array();
    private function issues_childs($issue_id, $start = false)
    {
        try {
            $immediate_childs = $this->getImmediateChilds($issue_id);
            if (count($immediate_childs)) {
                foreach ($immediate_childs as $chld) {
                    $chld['id'] = $chld['id'];
                    array_push($this->all_childs, $chld);
                    $this->issues_childs($chld['id'], false);
                }
            }
            return $this->all_childs;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function getImmediateChilds($issue_id)
    {
        try {
            return $i_childs = Issues::select('issues.id', 'project_id', 'parent_id', 'tracker_id', 'root_id', 'name as tracker', 'subject')
                ->join('trackers', 'trackers.id', 'tracker_id')
                ->where('parent_id', $issue_id)
                ->get();
            // return $i_childs;
            $childs = array();
            foreach ($i_childs as $i_child) {
                if ($i_child->parent_id == $this->parent_issue) {
                    $i_child->parent_id = 0;
                }
                array_push($childs, $i_child);
            }
            return $childs;
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function reportActioin(Issues $issue, $action)
    {
        if (!auth()->user()->can('approve_issues', [Issues::class, $issue->project])) {
            return abort(401);
        }

        if (!auth()->user()->can('approve_my_issues', [Issues::class, $issue->project])) {
            return back()->with('error', 'Não pode aprovar tarefas criadas por si');
        }

        try {
            $issue->is_aproved = true;
            $issue->aproved_by = auth()->user()->id;
            $issue->aproved_on = now();
            $issue->updated_on = now();
            $issue->update(); // Update info

            $this->jornalize_attr_changes($issue, $issue->is_aproved, 'is_aproved', 'Issue');

            return back()->with('success', 'Tarefa Aprovada com sucesso!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocorreu um erro ao tentar validar a tarefa!');
        }
        return $action;
    }

    public function getActividadesAlocadasByUSer($issue_id = 1)
    {
        return $i_childs = Issues::select('issues.id', 'project_id', 'parent_id', 'tracker_id', 'root_id', 'name as tracker', 'subject')
            ->join('trackers', 'trackers.id', 'tracker_id')
            ->where('parent_id', $issue_id)
            ->get();
    }

    public function getActividadesPendentesAlocadasByUser($id)
    {
        try {
            $actividadesPendente = Issues::where("author_id", $id)->where("is_aproved", false)->get();
            return $actividadesPendente;
        } catch (\Throwable $th) {
            return ["message" => "ERROR"];
        }
    }

    public function cadatrarActividade(Request $request)
    {
        DB::beginTransaction();
        try {
            $actividade = new Issues();

            $actividade->tracker_id = $request->tracker_id;
            $actividade->project_id = $request->project_id;
            $actividade->subject = $request->subject;
            $actividade->description = $request->description ?? null;
            $actividade->due_date = $request->due_date;
            $actividade->category_id = $request->category_id;
            $actividade->status_id = $request->status_id;
            $actividade->assigned_to_id = $request->assigned_to_id ?? null;
            $actividade->priority_id = $request->priority_id;
            $actividade->author_id = $request->author_id;
            $actividade->start_date = $request->start_date;
            $actividade->done_ratio = $request->done_ratio;
            $actividade->estimated_hours = $request->estimated_hours;
            $actividade->parent_id = $request->parent_id;
            $actividade->root_id = $request->root_id;
            $actividade->is_private = $request->is_private;
            $actividade->is_aproved = false;
            $actividade->created_on = now();
            $actividade->updated_on = now();

            $actividade->save();
            DB::commit();
            return ["message" => "Saved successfully"];
        } catch (\Throwable $error) {
            DB::rollback();
            return [
                "message" => "saving error",
                "erro" => $error
            ];
        }
    }
}
