<?php

namespace App\Http\Controllers\Api\WebAuth;

use App\Models\Issues;
use App\Models\TimeEntries;
use App\Models\FlowReportTask;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\UsersApprovementFlow;
use App\Models\ApprovementFlowModels;
use App\Models\FlowSolicitacaoFundos;
use App\Http\Controllers\Features\SolicitacaoFundos\SolicitacaoFundosRepository;


class DashboardControllerWebApi extends Controller
{

    // private SolicitacaoFundosRepository $solicitacaoFundos;
    private $solicitacaoFundos;
    private $requestsSolicitacaoFundos;

    public function __construct()
    {
        $this->solicitacaoFundos = new SolicitacaoFundosRepository();
    }

    /**
     * Return json object
     */
    public function index()
    {
        $my_tasks = Issues::where('author_id', auth()->user()->id)->count();
        $assigned_tasks = Issues::where('assigned_to_id', auth()->user()->id)->count();


        $tasks_to_report = 0;
        $budgetRequestToApprove = FlowSolicitacaoFundos::where('user_id_to', auth()->user()->id)
            ->with('solicitacao')
            ->with('requestBy')
            ->whereHas('solicitacao')
            ->whereHas('requestBy')
            ->where('approved_on', null)
            ->where('approved_by', null)
            ->where('is_rejected', false)

            ->where('is_approved', false)
            ->count();
        $tasks_to_approve_report = [];//sizeof($this->solicitacaoFundos->findRequestByUserID(auth()->user()->id, 0, []));

        $start_date = date('Y-m-d', strtotime('- 30 day'));
        $end_date = date('Y-m-d');
        /**
         * Pegar as actividades recentes
         */
        $getIssueActivities = Issues::select('issues.id', 'issues.subject', 'issues.status_id as i_status', 'issue_statuses.name as status_name', 'projects.name as project', 'trackers.name as tracker', 'users.firstname', 'users.lastname', 'issues.created_on', 'issues.updated_on')
            ->join('projects', 'projects.id', 'project_id')
            ->join('trackers', 'trackers.id', 'issues.tracker_id')
            ->join('issue_statuses', 'issue_statuses.id', 'status_id')
            ->join('users', 'users.id', 'projects.author_id')
            ->where('issues.created_on', '>=', $start_date)
            // ->where('issues.updated_on', '<=', $end_date)
            ->where('is_private', false)
            ->limit(10)
            ->orderby('updated_on', 'desc')
            ->get();

        $activities = [];
        foreach ($getIssueActivities as $key => $activitie) {
            $_created_date = mb_strtolower(ucwords(\Carbon\Carbon::parse($activitie->updated_on)->formatLocalized('%d %B %Y')));
            if ($activitie->created_on == $activitie->updated_on) {
                $activitie['isUpdated'] = false;
                $activitie['_time'] = $activitie->created_on->diffForHumans();
            } else {
                $activitie['isUpdated'] = true;
                $activitie['_time'] = $activitie->updated_on->diffForHumans();
            }

            $activities[$_created_date][] = $activitie;
        }

        $data = Issues::select(
            DB::raw('COUNT(CASE WHEN status_id = 1 THEN 1 ELSE null END) AS opened'),
            DB::raw('COUNT(CASE WHEN status_id = 2 THEN 1 ELSE null END) AS in_progress'),
            DB::raw('COUNT(CASE WHEN status_id = 5 THEN 1 ELSE null END) AS closed')
        )->where('author_id', auth()->user()->id)->first();

        $issuesToApprove = FlowSolicitacaoFundos::where('user_id_to', auth()->user()->id)
            ->with('solicitacao')
            ->with('requestBy')
            ->whereHas('solicitacao')
            ->whereHas('requestBy')
            ->where('approved_on', null)
            ->where('approved_by', null)
            //->where('is_rejected', false)
            ->where('is_approved', false)
            ->limit(15)
            ->orderBy('created_on', 'desc')
            ->get();

        foreach ($issuesToApprove as $task) {
            $task->_time = \Carbon\Carbon::parse($task->created_on)->diffForHumans();
            $task->end_at = \Carbon\Carbon::parse($task->solicitacao->date)->diffForHumans();
        }

        return response()->json([
            'my_tasks' => $my_tasks,
            'to_report' => $tasks_to_report,
            'budgetRequestToApprove' => $budgetRequestToApprove,
            'taskToApproveReport' => [],



            'assigned_tasks' => $assigned_tasks,
            'assignedTasks' => Issues::with('project')->whereHas('project')->where('assigned_to_id', auth()->user()->id)->get(),
            'tasksToReport' => $this->TasksToReport(),
            'recent_activities' => $activities,
            'taskOverview' => [
                "opened" => $data->opened,
                "in_progress" => $data->in_progress,
                "closed" => $data->closed,
            ],
            'issuesToApprove' => $issuesToApprove,
            'myBudgetRequestProcesses' => $this->solicitacaoFundos->findRequestByUserID(
                auth()->user()->id,
                0,
                [
                    'is_approved' => 0,
                    'is_rejected' => 0
                ],
                15
            ),
        ]);
    }

    /**
     * get hotTasks config from user settings on __construct method
     */
    private function TasksToReport()
    {
        $confDay = -5;
        $tasks = ApprovementFlowModels::where('assigned_to', auth()->user()->id)
            ->where('is_approved', false)
            ->where('is_rejected', false)
            ->where('rejected_on', null)
            ->with(['issue', 'requestBy', 'assignedTo'])
            //->whereHas('time_entrie')
            ->limit(40)
            //->paginate(30)
            ->get();
        
        foreach ($tasks as $task) {
            $task->_time = \Carbon\Carbon::parse($task->created_on)->diffForHumans();
            $task->end_at = \Carbon\Carbon::parse($task->due_date)->diffForHumans();
        }

        return $tasks;
    }


    /**
     * Dados do grafico - Over View de tarefas
     *
     * @return array
     */
    public function iniGrafico()
    {
        $data = Issues::select(
            DB::raw('COUNT(CASE WHEN status_id = 1 THEN 1 ELSE null END) AS opened'),
            DB::raw('COUNT(CASE WHEN status_id = 2 THEN 1 ELSE null END) AS in_progress'),
            DB::raw('COUNT(CASE WHEN status_id = 5 THEN 1 ELSE null END) AS closed')
        )->where('author_id', auth()->user()->id)->first();

        return response()->json([
            __('Planificadas') => $data['opened'],
            __('Em Curso') => $data['in_progress'],
            __('Concluídas') => $data['closed'],
        ], 200);
    }
}
