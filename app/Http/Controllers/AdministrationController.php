<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Myclass\TreeView;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\ProjectsHelper;

class AdministrationController extends Controller
{
    use ProjectsHelper;
    /**
     * List all projects
     */
    public function projects()
    {

        $status = request()->status;

        if(request()->has('status')){
            if(request()->status == null){
                $projects = Projects::orderby('created_on', 'desc')->where(function ($q) {
                })->paginate(30)->onEachSide(5);
            }else{
                $projects = Projects::orderby('created_on', 'desc')->where(function ($q) {
                    $q->where('status', request()->status);
                })->paginate(30)->onEachSide(5);
            }
        }else{
            $projects = Projects::orderby('created_on', 'desc')->where(function ($q) {
                // $q->where('type', 'Project')->orWhere('type', 'PDE');
            })->paginate(30)->onEachSide(5);
        }

        $data = array(
            'projects' => TreeView::makeview($projects),
        );

        // return $data;
        return view('admin.projects', compact('projects', 'data', 'status'));
    }


    /**
     * App info
     */
    public function info()
    {
        return view('admin.info');
    }
}
