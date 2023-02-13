<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;

class ReportsPDEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Projects $project)
    {
        // Expected response
        // Tipo	Designacao	Orcamento	Valor gasto (total)	Valor gasto / projecto	Percentual (valor gasto / orcamento)

        if ($request->has('setFilter') && $request->setFilter === '1') {
            return $issues = Issues::where('project_id', $project->id)
                ->with('tracker')
                ->with('indicators')
                ->with('orcamento')
                ->where('start_date', '>=', $request->start_date)
                ->get();
        }

        return $issues = Issues::where('project_id', $project->id)
            ->with('tracker')
            ->with('indicators')
            ->with('orcamento')
            ->get();
    }
}
