<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class GanntController extends Controller
{
    /**
     * Show all Gantt
     */
    public function index()
    {
        return view('gantt.index');
    }

    public function gantt_main_global(Request $request)
    {
        $has_project_identifier = false;

        if ($request->has('project_identifier') && $request->project_identifier !== null) {
            try {
                $project_with_childs_issues = Projects::where('status', true)->where(function ($q) {
                    $q->where('type', 'Project')->orWhere('type', 'PDE');
                })->where('identifier', $request->project_identifier)
                    ->orderby('created_on', 'desc')
                    ->with('issues')->firstOrFail();

                $has_project_identifier = true;
            } catch (\Throwable $e) {
                return response()->json([
                    "data" => [],
                    "links" => [],
                ]);
            }
        } else {
            $project_with_childs_issues = Projects::where('status', true)->where(function ($q) {
                $q->where('type', 'Project')->orWhere('type', 'PDE');
            })->orderby('created_on', 'desc')->with('issues')->get();

            $has_project_identifier = false;
        }

        $tasks = [];
        $links = [];

        if ($has_project_identifier) {
            $startDate = strtotime($project_with_childs_issues->start_date);
            $endDate = strtotime($project_with_childs_issues->due_date);
            $interval = $endDate - $startDate;
            $duration = floor($interval / (60 * 60 * 24));

            $tasks[] = array(
                'id' => $project_with_childs_issues->id,
                'open' => true,
                'type' => 'project',
                'text' => $project_with_childs_issues->name,
                'start_date' => $project_with_childs_issues->start_date ?? date('Y-m-d'),
                'duration' => $duration,
                'progress' => 0,
                'parent' => 0,
                'priority' => "Alta",
                'type' => $project_with_childs_issues->type,
            );

            $projects =  $project_with_childs_issues;

            if (isset($projects->childs)) {

                foreach ($projects->childs as $child) {

                    $startDate = strtotime($child->start_date);
                    $endDate = strtotime($child->due_date);
                    $interval = $endDate - $startDate;
                    $duration = floor($interval / (60 * 60 * 24));

                    $tasks[] = array(
                        'id' => $child->id,
                        'open' => true,
                        'type' => 'Sub-Projecto',
                        'text' => $child->name,
                        'start_date' => $child->start_date ?? date('Y-m-d'),
                        'duration' => $duration,
                        'progress' => 10,
                        'parent' => $child->parent_id,
                        'priority' => "Alta",
                        'type' => $child->type,
                    );

                    $links = array(
                        [
                            'id' => $projects->id,
                            'source' => $projects->id,
                            'target' => $child->id,
                            'type' => 1
                        ]
                    );
                }
            }


            foreach ($projects->issues()->where('tracker_id', 14)->get() as $issue) {
                $startDate = strtotime($issue->start_date);
                $endDate = strtotime($issue->due_date);
                $interval = $endDate - $startDate;
                $duration = floor($interval / (60 * 60 * 24));

                $tasks[] = array(
                    'id' => $issue->id,
                    'open' => true,
                    'type' => 'task',
                    'text' => $issue->subject,
                    'start_date' => $issue->start_date,
                    'duration' => $duration,
                    'progress' => 10,
                    'parent' => $issue->project_id,
                    'priority' => $issue->status->name,
                    'type' => $issue->tracker->name,
                    'usege' => [
                        'id' => '1',
                        'value' => 'value test 2'
                    ]
                );
            }
        } else {

            foreach ($project_with_childs_issues as $key => $projects) {
                $startDate = strtotime($projects->start_date);
                $endDate = strtotime($projects->due_date);
                $interval = $endDate - $startDate;
                $duration = floor($interval / (60 * 60 * 24));

                $tasks[] = array(
                    'id' => $projects->id,
                    'open' => true,
                    'type' => 'project',
                    'text' => $projects->name,
                    'start_date' => $projects->start_date ?? date('Y-m-d'),
                    'duration' => $duration,
                    'progress' => 0,
                    'parent' => $projects->parent_id,
                    'priority' => "Alta",
                    'type' => $projects->type,
                );

                if (isset($projects->childs)) {

                    foreach ($projects->childs as $child) {

                        $startDate = strtotime($child->start_date);
                        $endDate = strtotime($child->due_date);
                        $interval = $endDate - $startDate;
                        $duration = floor($interval / (60 * 60 * 24));

                        $tasks[] = array(
                            'id' => $child->id,
                            'open' => true,
                            // 'type' => 'Sub-Projecto',
                            'text' => $child->name,
                            'start_date' => $child->start_date ?? date('Y-m-d'),
                            'duration' => $duration,
                            'progress' => 10,
                            'parent' => $child->parent_id,
                            'priority' => "Alta",
                            'type' => $child->type,
                        );

                        $links = array(
                            [
                                'id' => $projects->id,
                                'source' => $projects->id,
                                'target' => $child->id,
                                'type' => 1
                            ]
                        );
                    }
                }


                foreach ($projects->issues()->where('tracker_id', 14)->get() as $issue) {
                    $startDate = strtotime($issue->start_date);
                    $endDate = strtotime($issue->due_date);
                    $interval = $endDate - $startDate;
                    $duration = floor($interval / (60 * 60 * 24));

                    $tasks[] = array(
                        'id' => $issue->id,
                        'open' => true,
                        'type' => 'task',
                        'text' => $issue->subject,
                        'start_date' => $issue->start_date,
                        'duration' => $duration,
                        'progress' => 10,
                        'parent' => $issue->project_id,
                        'priority' => $issue->status->name,
                        'type' => $issue->tracker->name,
                        'usege' => [
                            'id' => '1',
                            'value' => 'value test 2'
                        ]
                    );
                }
            }
        }



        // return $tass_;
        // return $duration = date('d', \strtotime('2010-11-24'));

        return response()->json([
            "data" => $tasks,
            "links" => $links,
        ]);
    }

    /**
     * Show all Gantt
     */
    public function show($project_identifier)
    {
        return view('gantt.show');
    }


    /**
     * Gantt project data
     */
    public function show_project_data(Projects $project_identifier)
    {

        $tasks = [];
        $links = [];
        $projects = $project_identifier;
        foreach ($project_identifier->issues as $issue) {

            $startDate = strtotime($projects->start_date);
            $endDate = strtotime($projects->due_date);
            $interval = $endDate - $startDate;
            $duration = floor($interval / (60 * 60 * 24));

            $tasks[] = array(
                'id' => $issue->id,
                'open' => true,
                'type' => 'project',
                'text' => $issue->subject,
                'start_date' => $issue->start_date,
                'duration' => $duration,
                'progress' => 0,
                'parent' => $issue->parent_id,
                'priority' => $issue->status->name,
                'type' => $issue->type,
            );

            if (isset($projects->childs)) {

                foreach ($projects->childs as $child) {

                    $links = array(
                        [
                            'id' => $projects->id,
                            'source' => $projects->id,
                            'target' => $child->id,
                            'type' => 1
                        ]
                    );
                }
            }
        }

        return $project_identifier;

        return response()->json([
            "data" => $tasks,
            "links" => $links,
        ]);
    }
}
