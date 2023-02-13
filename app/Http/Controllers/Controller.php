<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Documents;
use App\Models\Issues;
use App\Models\Projects;
use App\Models\EnabledModules;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $parameters;

    public function __construct()
    {
        // Check AuthorizesRequests
        // $this->middleware('auth');

        $parameters = Route::current()->parameters();

        // dd($parameters);

        $this->parameters = $parameters;
        switch (key($parameters)) {
            case 'issue':
                try {
                    $issue = Issues::where('id', $parameters[key($parameters)])->firstOrFail();
                } catch (\Throwable $th) {
                    // \abort(401);
                    return $this->default_error();
                }
                $this->project_init($issue->project);
                break;
            case 'document':
                try {
                    $document = Documents::where('id', $parameters[key($parameters)])->firstOrFail();
                } catch (\Throwable $th) {
                    return $this->default_error();
                }
                $this->project_init($document->project);
                break;
            case 'project_identifier':
                // query by project identifier
                try {
                    $project = Projects::where('identifier', $parameters[key($parameters)])->firstOrFail();
                } catch (\Throwable $th) {
                    // throw $th;
                    return $this->default_error();
                }
                $this->project_init($project);
                break;
            default:
                // $this->default_error();
                break;
        }
    }

    /**
     * Defauld error in cade project not found
     */
    public function default_error()
    {
        $_project = array(
            'id' => null,
            'identifier' => false,
            'status' => false,
            'name' => "SGMP",
        );
        View::share([
            '_modules' => [],
            '_project' => $_project
        ]);
    }

    /**
     * Select query type
     */

    /**
     * Initialize the project
     * and share data to all rended views
     */
    private function project_init($project)
    {
        // dd($project);
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
    }
}
