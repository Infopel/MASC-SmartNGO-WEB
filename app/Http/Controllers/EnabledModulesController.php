<?php

namespace App\Http\Controllers;

use App\Models\Boot;
use App\Models\EnabledModules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class EnabledModulesController extends Controller
{
    public function enabledModules($project = null)
    {
        $enabled_modules = EnabledModules::select('enabled_modules.name as module')->where('project_id', $project->id)->get()->toArray();
        $_project = array(
            'id' => $project->id,
            'identifier' => $project->identifier,
            'status' => $project->status,
            'type' => $project->type,
            'name' => $project->name,
            'project' => $project
        );
        View::share([
            '_modules' => $enabled_modules,
            '_project' => $_project,
        ]);

        return $_project;
    }
}
