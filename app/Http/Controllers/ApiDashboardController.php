<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDashboardController extends Controller
{

    protected $dashboardSettings = [];

    /**
     * Pegar as configuracoes do dashboard de cada usuario ou gerais
     * @return array $DashboardSettings
     */
    public function __construct()
    {

    }


    public function index()
    {
        $start_date = date('Y-m-d', strtotime('- 30 day'));
        $end_date = date('Y-m-d');

        dd(auth()->user());

        /**
         * Pegar todas as tasks
         */
        $issues = Issues::select('issues.id', 'issues.tracker_id', 'issues.subject', 'issues.due_date', 'issues.start_date', 'issues.priority_id', 'issues.category_id', 'projects.name as project', 'enumerations.name as priority', 'issues.created_on', 'issues.updated_on', 'issues.closed_on')
            ->join('projects', 'projects.id', 'project_id')
            ->join('enumerations', 'enumerations.id', 'priority_id')
            ->where('is_public', true)
            ->where('issues.status_id', 1)
            ->where('issues.author_id', auth()->user()->id)
            ->limit(8)
            ->orderby('issues.updated_on', 'desc')
            ->get();

        $_issues = [];
        foreach ($issues as $issue) {
            $_issues[] = array(
                'id' => $issue->id,
                'subject' => $issue->subject,
                'description' => $issue->description,
                'category_id' => $issue->category_id,
                'assigned_to_id' => $issue->assigned_to_id,
                'priority_id' => $issue->priority_id,
                'project' => $issue->project,
                'priority' => $issue->priority,
                'due_date' => $issue->due_date,
                'start_date' => $issue->start_date,
                'created_on' => $issue->created_on->diffForHumans(),
                'updated_on' => $issue->updated_on->diffForHumans(),
            );
        }

        /**
         * Pegar as actividades recentes
         */
        $activities = Issues::select('issues.id', 'issues.subject', 'issues.status_id as i_status', 'issue_statuses.name as status_name', 'projects.name as project', 'trackers.name as tracker', 'users.firstname', 'users.lastname', 'issues.created_on', 'issues.updated_on')
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

        $_activities = [];
        foreach ($activities as $key => $activitie) {
            $_created_date = mb_strtolower(ucwords(\Carbon\Carbon::parse($activitie->updated_on)->formatLocalized('%d %B %Y')));
            if($activitie->created_on == $activitie->updated_on)
            {
                $activitie['isUpdated'] = false;
                $activitie['_time'] = $activitie->created_on->diffForHumans();
            }else{
                $activitie['isUpdated'] = true;
                $activitie['_time'] = $activitie->updated_on->diffForHumans();
            }

            $_activities[$_created_date][] = $activitie;
        }

        $data = array(
            'issues' => $_issues,
            'activities' => $_activities,
            'taskOverview' => $this->taskOverview(null, null),
            'hotTasks' => $this->hotTasks()
        );

        return $data;
    }

    /**
     * Tasks overview
     */
    public function taskOverview($taskTrackers = null, $taskType_id = null)
    {
        $_tasksoverview = [];

        if($taskTrackers != null){

        }else{
            $_tasksoverview = Issues::select(
                DB::raw('COUNT(CASE WHEN status_id = 1 THEN 1 ELSE null END) AS opened'),
                DB::raw('COUNT(CASE WHEN status_id = 2 THEN 1 ELSE null END) AS in_progress'),
                DB::raw('COUNT(CASE WHEN status_id = 5 THEN 1 ELSE null END) AS closed')
            )->where('author_id', auth()->user()->id)->first();
        }

        $_mTasks = Issues::where('author_id', auth()->user()->id)->count();
        $_tasks_assign = Issues::where('assigned_to_id', auth()->user()->id)->count();
        $_mc_tasks = \number_format((($_mTasks + $_tasks_assign) / Issues::count()), 2);

        $_tasksoverview['_mTasks'] = $_mTasks;
        $_tasksoverview['_tasks_assign'] = $_tasks_assign;
        $_tasksoverview['_mc_tasks'] = $_mc_tasks;

        return $_tasksoverview;
    }

    /**
     * get hotTasks config from user settings on __construct method
     */

    public function hotTasks()
    {
        $confDay = -5;
        $hotTasks = Issues::select('*')
            ->whereRaw(DB::raw('datediff(now(), due_date) >= '.$confDay.''))
            ->where('due_date', '!=', null)
            ->where('author_id', auth()->user()->id)
            ->where(DB::raw('datediff(now(), due_date)'), '<=', 1)
            ->limit(5)
            ->orderby('due_date', 'desc')
            ->get();

        $_hotTasks = [];

        foreach ($hotTasks as $task) {
            $task->_time = $task->created_on->diffForHumans();
            $task->end_at = $task->due_date->diffForHumans();
            $_hotTasks[] = $task;
        }

        $response = array(
            'hotTasks' => $_hotTasks,
            '_hotTasks' => $hotTasks->count(),
        );

        return $response;
    }

    public function iniGrafico()
    {
        $data = Issues::select(
            DB::raw('COUNT(CASE WHEN status_id = 1 THEN 1 ELSE null END) AS opened'),
            DB::raw('COUNT(CASE WHEN status_id = 2 THEN 1 ELSE null END) AS in_progress'),
            DB::raw('COUNT(CASE WHEN status_id = 5 THEN 1 ELSE null END) AS closed')
        )->where('author_id', auth()->user()->id)->first();

        return response()->json([
            // __('lang.label_open_issues_plural') => $data['opened'],
            __('Planificadas') => $data['opened'],
            __('Em Curso') => $data['in_progress'],
            __('Concluídas') => $data['closed'],
            // __('lang.label_closed_issues_plural') => $data['closed'],
        ], 200);
        // {name: 'www.site1.com', upload: 200, download: 200, total: 400},
    }
}
