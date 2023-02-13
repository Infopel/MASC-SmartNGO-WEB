<?php

namespace App\Http\Controllers;

use App\Models\BudgetTrackers;
use Illuminate\Http\Request;

class BudgetTrackersController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('cadastrar_tipos_despesa', \App\Models\Budgets::class)){
            abort(401);
        }

        $budgetTracker = [];
        return view('budget.config.trackers.new', compact('budgetTracker'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('cadastrar_tipos_despesa', \App\Models\Budgets::class)) {
            abort(401);
        }

        $request->validate([
            'budgetTracker.name' => 'required|unique:budget_trackers,name'
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'budgetTracker.name' => __('lang.field_name')
        ]);

        try {
            $budgetTracker = new BudgetTrackers();
            $budgetTracker->name = $request->budgetTracker['name'];
            $budgetTracker->type = "expense";
            // $budgetTracker->position = $budgetTracker->increment('position');
            $budgetTracker->status = $request->budgetTracker['active'];
            $budgetTracker->created_on = now();
            $budgetTracker->updated_on = now();
            $budgetTracker->save(); // Save data into database

            if($request->has('continue')){
                return back()->with('success', '<b>' . $budgetTracker->name . '</b> - ' . __('lang.notice_successful_create'));
            }
            return redirect()->route('budget.config.index')->with('success', '<b>'.$budgetTracker->name.'</b> - '.__('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error', ' Os dados não foram cadastrados. Encontramos um erro! Error Type [RF002] - Budget Trackers!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetTrackers  $budgetTracker
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetTrackers $budgetTracker)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetTrackers  $budgetTracker
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetTrackers $budgetTracker)
    {
        if (!auth()->user()->can('atualizar_tipos_despesa', \App\Models\Budgets::class)) {
            abort(401);
        }

        return view('budget.config.trackers.edit', compact('budgetTracker'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetTrackers  $budgetTracker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetTrackers $budgetTracker)
    {
        if (!auth()->user()->can('atualizar_tipos_despesa', \App\Models\Budgets::class)) {
            abort(401);
        }

        $request->validate([
            'budgetTracker.name' => 'required'
        ],[
            'required' => __('lang.errors.messages.required')
        ],[
            'budgetTracker.name' => __('lang.field_name')
        ]);

        $budgetTracker->name = $request->budgetTracker['name'];

        if($budgetTracker->isDirty('name')){
            $request->validate([
                'budgetTracker.name' => 'unique:budget_trackers,name'
            ],[
                'unique' => __('lang.errors.messages.taken')
            ],[
                'budgetTracker.name' => __('lang.field_name')
            ]);
        }

        try {
            $budgetTracker->name = $request->budgetTracker['name'];
            $budgetTracker->status = $request->budgetTracker['active'];
            $budgetTracker->updated_on = now();
            $budgetTracker->update();

            return redirect()->route('budget.config.index')->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', ' Os dados não foram cadastrados. Encontramos um erro! Error Type [RF002] - Budget Trackers!');
        }
    }


    /**
     * Remove Confirmation
     */
    public function remove_confirmation(BudgetTrackers $budgetTracker)
    {
        if (!auth()->user()->can('excluir_tipos_despesa', \App\Models\Budgets::class)) {
            abort(401);
        }

        return back()->with('isRemoveTrue',[
            'msg' => __('lang.text_are_you_sure'),
            'budgetTracker' => $budgetTracker->name,
            'budgetTracker_id' => $budgetTracker->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetTrackers  $budgetTracker
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetTrackers $budgetTracker)
    {
        if (!auth()->user()->can('excluir_tipos_despesa', \App\Models\Budgets::class)) {
            abort(401);
        }

        try {
            $budgetTracker->delete(); // Delete
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', ' Não foi possível excluir. Encontramos um erro! Error Type [RF002] - Budget Trackers');
        }
    }
}
