<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\ActivityHelper;

class ActivitiesController extends Controller
{

    use ActivityHelper;
    /**
     * Display activites
     */
    public function index()
    {
        $activities = [];
        $get_activities['type_issues'] = Issues::with('project', 'tracker', 'status', 'author')->where('author_id', auth()->user()->id)->get();
        $activities['issues'] = $this->generate_activities_history_time($get_activities['type_issues']);
        $activities['change_logs'] = [];
        $activities['news'] = [];
        // return $activities;
        return view('activities.index', compact('activities'));
    }

    /**
     * Display project activities
     */

    public function project(Projects $project_identifier)
    {
        $activities = [];
        $get_activities['type_issues'] = Issues::with('project', 'tracker', 'status', 'author')->where('project_id', $project_identifier->id)->get();

        $activities['issues'] = $this->generate_activities_history_time($get_activities['type_issues']);
        $activities['change_logs'] = [];
        $activities['news'] = [];

        // return $activities;
        return view('activities.index', compact('activities'));
    }
}
