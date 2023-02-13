<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Issues;
use Illuminate\Http\Request;

class ReportsActividadesProject extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = "actividades_project";
        $projectsPDE = Projects::where('type', "Program")->get();
        return view('reports.index', compact('active', 'projectsPDE'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Projects $project)
    {
        //p
    }

    /**
     * Display a listing of projects childs of PDE
     */
    public function getProjectByParent(Request $request, Projects $project)
    {
        return response()->json([
            'projects' => Projects::where('parent_id', $project->id)->get()
        ]);
    }

    public function getActivityByParent(Request $request, Projects $project)
    {
        return response()->json([
            'projects' => Issues::where('project_id', $project->id)
                                ->where('tracker_id', 14)
                                ->with('indicators')->get()
        ]);
    }

    public function getActivityByDate(Request $request, Projects $project)
    {
        return response()->json([
            'projects' => Issues::where('project_id', $project->id)
                                ->where('tracker_id', 14)
                                /*->whereColumn([
                                    ['start_date', '>=', $request->start_date],
                                    ['created_on', '<=', $request->end_date],
                                ])*/
                                ->where('start_date', '>=', $request->start_date)
                                ->where('due_date', '<=', $request->end_date)
                                /*->where(function ($query) {
                                    $query->where('votes', '>', 100)
                                          ->orWhere('title', '=', 'Admin');
                                })*/
                                ->with('indicators')->get()
        ]);
    }

    /**
     * Expor Data into Excle file
     */
    public function exportData(Request $request)
    {

        try {
            if ($request->start_date != null and $request->end_date != null ) {
                $project = Issues::where('project_id', $project->id)
                                ->where('tracker_id', 14)
                                ->where('start_date', '>=', $request->start_date)
                                ->where('due_date', '<=', $request->end_date)
                                ->with('indicators')->get();
            } else {
                $project =  Issues::where('project_id', $project->id)
                                ->where('tracker_id', 14)
                                ->with('indicators')->get();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Project not found');
        }
        dd('Folege');
        $application =  AppBoot::application();
        $title = "RELATORIO DE ACTIVIDADES";
        $start_date = $request->start_date == 'null' ? 'dd-mm-yyyy' : $request->start_date;
        $end_date = $request->end_date == 'null' ? 'dd-mm-yyyy' : $request->end_date;

        $data = $this->approvement_flow($request);
        $data = $data->original['approvementFlow'];

        $export = new ExportsReportApprovementFlow($title, $application, $project, $start_date, $end_date, $data);
        $file_name = time() . "Relatorio-mensal-de-Actividades";
        return Excel::download($export, $file_name . '.xlsx');


        return view('report_files.exports.export_actividades_project', compact(
            'application',
            'title',
            'project',
            'start_date',
            'end_date',
            'data'
        ));
    }

}
