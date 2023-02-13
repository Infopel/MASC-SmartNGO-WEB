<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\ModulesHelper;
use App\Http\Controllers\Helpers\TrackersHelper;

class PDEController extends Controller
{
    use ModulesHelper, TrackersHelper;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('cadastrar_plano_estrategico', Projects::class)){
            abort(401);
        }
        return view('pde.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('cadastrar_plano_estrategico', Projects::class)) {
            abort(401);
        }

        $request->validate([
            'pde.name' => 'required|max:50|unique:projects,name',
            'pde.identifier' => 'required|unique:projects,identifier',
            'pde.start_date' => 'required',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
            'max' => __('lang.long_wrong_length')
        ], [
            'pde.name' => __('lang.field_name'),
            'pde.start_date' => __('lang.field_start_date'),
            'pde.identifier' => __('lang.field_identifier')
        ]);

        // return $request;

        // trait to handle exceptions
        try {
            DB::beginTransaction();
            // Create new project Resource
            $pde = new Projects();
            $pde->name = $request->pde['name'];
            $pde->description = $request->pde['description'];
            $pde->identifier = $request->pde['identifier'];
            $pde->author_id = Auth::user()->id;
            $pde->type = "PDE";
            $pde->is_public = 1;
            $pde->due_date = $request->pde['due_date'] ?? null;
            $pde->start_date = $request->pde['start_date'] ?? null;
            $pde->created_on = now();
            $pde->updated_on = now();

            $pde->save(); // Save data into database

            // add default modulos
            $this->add_default_modules($pde->id);
            // add default project trackers
            $this->add_default_tracker($pde->id, "PDE");

            DB::commit();
            return redirect()->route('projects.overview', ['project_identifier' => $pde->identifier])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function edit(Projects $project)
    {
        if (!auth()->user()->can('editar_plano_estrategico', Projects::class)) {
            abort(401);
        }

        return view('pde.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projects $projects)
    {
        dd("Falata Error! Contact Admin");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $projects
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projects $projects)
    {
        //
    }
}
