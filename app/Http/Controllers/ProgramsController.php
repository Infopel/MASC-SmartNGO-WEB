<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Helpers\CustomFieldsHelper;
use App\Http\Controllers\Helpers\Notifications\EventNotifications;

class ProgramsController extends Controller
{
    // Use my Envet Notifications
    use EventNotifications, CustomFieldsHelper;

    protected $type = "Program";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Projects::where('status', true)->where('type', $this->type)->paginate(10);

        return view('programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('criar_linhas_estrategicas', Projects::class)) {
            abort(401);
        }

        return view('programs.new');
    }

    /**
     * Show form for creating new programa
     * This program is going to be used to group projects
     *
     */
    public function create_related_to(Projects $indentifier)
    {
        if (!auth()->user()->can('criar_linhas_estrategicas', Projects::class)) {
            abort(401);
        }

        $project = $indentifier;
        return view('programs.new', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('criar_linhas_estrategicas', Projects::class)) {
            abort(401);
        }
        $project = null;
        if (request()->has('project_identifier')) {
            try {
                $project = Projects::where('identifier', $request->project_identifier)->firstOrFail();
            } catch (\Throwable $th) {
                throw ValidationException::withMessages(['project_parent' => 'O projeto que você está tentando acessar não exite ou foi removido.']);
            }
        } else {
            throw ValidationException::withMessages(['project_parent' => 'Não encontramos nenhum identificador de projeco no request para associar com este programa.']);
        }

        $request->validate([
            'program.name' => 'required|max:30|unique:projects,name',
            'program.identifier' => 'required|unique:projects,identifier',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
            //'max' => __('lang.long_wrong_length'),
        ], [
            'program.name' => __('lang.field_name'),
            'program.identifier' => __('lang.field_identifier'),
        ]);

        // handle exceptions
        try {
            // Create new project Resource
            $program = new Projects();
            $program->name = $request->program['name'];
            $program->description = $request->program['description'];
            $program->identifier = $request->program['identifier'];
            $program->author_id = Auth::user()->id;
            $program->type = $this->type;
            $program->parent_id = $project->id;
            // $program->is_public = $request->program['is_public'] ?? 1;
            $program->is_public = 1;
            $program->created_on = now();
            $program->updated_on = now();

            $program->save(); // Save data into database

            // Segundo - Cadastramos os dados de todos os campos personalizados
            $this->store_custom_fildes_values($request['custom_field_values'], $program->id, 'Program');

            return redirect()->route('programs.show', ['program' => $program->identifier])->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->route('programs.create', ['program' => $program->identifier])->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projects  $program
     * @return \Illuminate\Http\Response
     */
    public function show(Projects $program)
    {

        // return $program;
        return view('programs.show', compact('program'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projects  $program
     * @return \Illuminate\Http\Response
     */
    public function edit(Projects $program)
    {
        if (!auth()->user()->can('editar_linhas_estrategicas', [Projects::class, $program])) {
            abort(401);
        }

        $program->objectivoEsp = $program->customFieldValues()->where('customized_type', 'Program')->where('custom_field_id', 39)->first()->value ?? null;
        $program->resultado = $program->customFieldValues()->where('customized_type', 'Program')->where('custom_field_id', 40)->first()->value ?? null;

        return view('programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projects  $program
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projects $program)
    {
        if (!auth()->user()->can('editar_linhas_estrategicas', [Projects::class, $program])) {
            abort(401);
        }

        $request->validate([
            'program.name' => 'required|max:180',
            'program.identifier' => 'required|max:100',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken'),
            'max' => __('lang.long_wrong_length')
        ], [
            'program.name' => __('lang.field_name'),
            'program.identifier' => __('lang.field_identifier')
        ]);


        // trait to handle exceptions
        try {
            // Create new project Resource
            $program->name = $request->program['name'];
            $program->description = $request->program['description'];
            $program->identifier = $request->program['identifier'];
            // $program->is_public = $request->program['is_public'];
            $program->updated_on = now();

            $program->update(); // Save data into database

            if (request()->has('custom_field_values')) {
                // Segundo - Cadastramos os dados de todos os campos personalizados
                $this->update_project_custom_fildes_values($request['custom_field_values'], $program->id, 'Program');
            }

            return redirect()->route('programs.show', ['program' => $program->identifier])->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->route('projects.store', ['program' => $program->identifier])->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }


    /**
     * Remove resource Confirmation request
     *
     * @param \App\Models\Projects  $program
     * @return \Illuminate\Http\Response
     */
    public function remove_confirmation(Projects $program)
    {
        $this->authorize('gerir_linhas_estrategicas', auth()->user());

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'program_name' => $program->name ?? null,
            'program_identifier'  => $program->identifier ?? null,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projects  $program
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projects $program)
    {
        $this->authorize('gerir_linhas_estrategicas', auth()->user());
        try {
            // Remover o programa
            $program->delete();
            // Remover todos os associados
            return redirect()->route('programs.index')->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('programs.index')->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }
}
