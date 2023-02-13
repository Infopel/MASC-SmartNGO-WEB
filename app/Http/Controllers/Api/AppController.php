<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issues;
use  App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\User;

class AppController extends Controller
{
    //
    public function index()
    {
        $my_tasks = Issues::where('author_id', 29);
        $assigned_tasks = Issues::where('assigned_to_id', auth()->user()->id)->count();

        return response()->json([
            'my_tasks' => $my_tasks,
        ]);
    }

    /**
     * get hotTasks config from user settings on __construct method
     */
    private function TasksToReport()
    {
        $confDay = -5;
        $tasks = FlowReportTask::where('assigned_to', auth()->user()->id)
            ->where('is_approved', false)
            ->where('is_rejected', false)
            ->where('rejected_on', null)
            ->with(['flow', 'requestBy', 'assignedTo', 'time_entrie'])
            ->limit(15)
            ->get();

        foreach ($tasks as $task) {
            $task->_time = \Carbon\Carbon::parse($task->created_on)->diffForHumans();
            $task->end_at = \Carbon\Carbon::parse($task->due_date)->diffForHumans();
        }

        return $tasks;
    }

    public function login(Request $request)
    {
        return 'Folege';
        $validator = Validator::make($request->all(), [
            'login' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Either email or password is wrong.'], 401);
        }
        return $this->createNewToken($token);
    }

    public function getActividadesPendentesAlocadasByUser($id)
    {

        try {
            $actividadesPendente = Issues::where("author_id" , $id)->where("is_aproved" , false)->get();
            return $actividadesPendente;
        } catch (\Exception $e) {
            return ["message" => "ERROR"];
        }
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
