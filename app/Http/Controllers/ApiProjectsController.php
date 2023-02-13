<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ApiProjectsController extends Controller
{
    //
    /**
     * Display list of projects
     */
    public function index()
    {
        $projects = Projects::where('status', true)->where('parent_id', null)->get();

        $data = array(
            'projects' => $projects,
        );

        return $data;
    }

    /**
     * get overview Budget for the projects
     */
    public function project_budget($parent)
    {

        $projectBugdet = array(
            'project_budget' => 0,
            'exp_budget' => 0,
            'planed_budget' => 0,
            'planed_exp_budget' => 0,
            'real_budget' => 0,
            'real_exp_budget' => 0,
            'childsBudget' => $this->childsBudget($parent),
        );

        $data = array(
            'projectBugdet' => $projectBugdet,
        );
        return $data;
    }

    /**
     * get childs project budget
     */
    private function childsBudget($parent)
    {
        $projects = Projects::where('status', true)->where('parent_id', $parent)->get();

        $data = array();
        $val = 3187;
        foreach ($projects as $project) {
            $data[] = array(
                'name' => $project->name,
                'budget' => $val,
                'exp_budget' => 0,
            );

            $val *= 2;
        }

        return $data;
    }
}
