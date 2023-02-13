<?php

namespace App\Http\Controllers;

use App\Models\Enumerations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnumerationsController extends Controller
{

    protected $enumeration_types = array(
        'DocumentCategory',
        'IssuePriority',
        'TimeEntryActivity',
        'PartnersCategory',
        'IssueArea',
        'IssueActividade',
        'IssueNecessidade',
        // 'MultiIndicators',
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        foreach ($this->enumeration_types as $enumeration_type) {
            $enumerations[$enumeration_type] = Enumerations::where('type', $enumeration_type)->orderby('type')->get();
        }

        // return $enumerations;
        return view('enumerations.index', compact('enumerations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!auth()->user()->can('criar_tipos_categorias', Enumerations::class)) {
            abort(401);
        }

        switch ($request->type) {
            case 'DocumentCategory':
                $enumeration_type = __('lang.enumeration_doc_categories');
                break;
            case 'IssuePriority':
                $enumeration_type = __('lang.enumeration_issue_priorities');
                break;
            case 'TimeEntryActivity':
                $enumeration_type = __('lang.enumeration_activities');
                break;
            case 'PartnersCategory':
                $enumeration_type = __('lang.enumeration_partner_type');
                break;
            case 'MultiIndicators':
                $enumeration_type = __('Indicadores Multidimensionais');
                break;
            default:
                $enumeration_type = __('lang.label_enumerations');
                break;
        }

        $enumeration = [];
        // return $data;
        return view('enumerations.new', compact('enumeration', 'enumeration_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('criar_tipos_categorias', Enumerations::class)) {
            abort(401);
        }

        if (!in_array($request->type, $this->enumeration_types)) {
            return abort(401);
        }

        $request->validate([
            'enumeration.name' => 'required|max:30'
        ], [
            'required' => __('lang.errors.messages.required')
        ]);

        $position = Enumerations::select('position')->where('type', $request->type)->latest('id')->first()->position ?? 0;

        // Performe save query
        try {
            DB::beginTransaction();

            $enumeration = new Enumerations();
            $enumeration->name = $request->enumeration['name'];
            $enumeration->is_default = $request->enumeration['is_default'];
            $enumeration->active = $request->enumeration['active'];
            $enumeration->type = $request->type;
            $enumeration->position = ++$position;
            $enumeration->save(); // Save data into database

            DB::commit();
            return redirect()->route('enumerations.index')->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->with('error', 'Ocorreu um erro na ao gravar os dados!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enumerations  $enumerations
     * @return \Illuminate\Http\Response
     */
    public function show(Enumerations $enumeration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enumerations  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Enumerations $enumeration)
    {
        if (!auth()->user()->can('editar_tipos_categorias', $enumeration)) {
            abort(401);
        }
        // return $enumeration;
        return view('enumerations.edit', compact('enumeration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enumerations  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enumerations $enumeration)
    {
        if (!auth()->user()->can('editar_tipos_categorias', $enumeration)) {
            abort(401);
        }

        $request->validate([
            'enumeration.name' => 'required|max:30'
        ], [
            'required' => __('lang.errors.messages.required')
        ]);

        try {
            $enumeration->name = $request->enumeration['name'];
            $enumeration->is_default = $request->enumeration['is_default'];
            $enumeration->active = $request->enumeration['active'];
            $enumeration->update();

            return redirect()->route('enumerations.index')->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Ocorreu um erro na ao gravar os dados!');
        }
    }


    public function remove_permission(Enumerations $enumeration)
    {
        if (!auth()->user()->can('excluir_tipos_categorias', $enumeration)) {
            abort(401);
        }

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'enumeration_name' => $enumeration->name,
            'enumeration_id' => $enumeration->id
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enumerations  $enumeration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enumerations $enumeration)
    {
        if (!auth()->user()->can('excluir_tipos_categorias', $enumeration)) {
            abort(401);
        }

        try {
            $enumeration->delete();
            return redirect()->route('enumerations.index')->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Ocorreu um erro na ao gravar os dados!');
        }
    }
}
