<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Issues;
use  App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;
use App\Models\Projects;

class AppController extends Controller
{

    /**
     * Index Home APP
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * return welcome page view
     */
    public function show()
    {
        return view('welcome.index');
    }

    /**
     * Dispay user page
     * @return View
     */
    public function user($user_id)
    {
        return view('account.page');
    }

    /**
     * Display Helper page
     */

    public function help()
    {
        return view('help.index');
    }


    public function getActividadesPendentesAlocadasByUser(Request $request)
    {
        try {

            $actividadesPendente = Issues::select(
                                                'issues.id',
                                                'issues.subject',
                                                'issues.description',
                                                'projects.name as project',
                                                'issues.due_date'
                                                )
                                        //->with('project')
                                        ->join('projects', 'issues.project_id','projects.id')
                                        ->where("issues.author_id" , $request->author_id)
                                        ->where("issues.is_aproved" , false)
                                        ->where("issues.tracker_id",14)
                                         ->get();
            return $actividadesPendente;
        } catch (\Exception $e) {
            return ["message" => "ERROR"];
        }
    }

    public function reportar(Request $request)
    {
        $issueStatuses = Issues::where('id', $request->id)->firstOrFail();

        $issueStatuses['is_aproved'] = $request->is_aproved;
        $issueStatuses->update();
        return $issueStatuses['is_aproved'];

       /* try {

            $issueStatuses->update();
            $issueStatuses = Issues::where('id', $request->id)->firstOrFail();
            return $issueStatuses;
            /*return [
                "message" => "Actualizacao feita com Sucesso",
            ];*/
       /* } catch (\Exception $error) {
            return [
                "message" => "saving error",
                "erro" => $error
            ];
        }*/
    }


    public function cadatrarActividade(Request $request)
    {
        try {
            $actividade = new Issues();
            $actividade->tracker_id = $request->tracker_id ;
            $actividade->project_id = $request->project_id;
            $actividade->subject = $request->subject;
            $actividade->description = $request->description;
            $actividade->due_date = $request->due_date;
            $actividade->category_id = $request->category_id;
            $actividade->status_id = $request->status_id;
            $actividade->assigned_to_id = $request->assigned_to_id;
            $actividade->priority_id = $request->priority_id;
            $actividade->fixed_version_id = $request->fixed_version_id;
            $actividade->author_id = $request->author_id;
            $actividade->author_id = $request->author_id;
            $actividade->start_date = $request->start_date;
            $actividade->done_ratio = $request->done_ratio;
            $actividade->estimated_hours = $request->estimated_hours;
            $actividade->parent_id = $request->parent_id;
            $actividade->root_id = $request->root_id;
            $actividade->lft = $request->lft;
            $actividade->rgt = $request->rgt;
            $actividade->is_private = $request->is_private;
            $actividade->closed_on  = $request->closed_on;
            $actividade->is_aproved = $request->is_aproved;
            $actividade->aproved_by = $request->aproved_by;
            $actividade->aproved_on  = $request->aproved_on;

            $actividade->save();
            return ["message" => "Saved successfully"];
        } catch (\Exception $error) {
            return [
                "message" => "saving error",
                "erro" => $error
            ];
        }
    }
}
