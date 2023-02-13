<?php

namespace App\Http\Controllers;

use App\Models\BudgetTrackers;
use Illuminate\Http\Request;
use App\Models\BudgetTrackerDefaultValues;
use Illuminate\Validation\ValidationException;

class BudgetTrackerDefaultValuesController extends Controller
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
        if (!auth()->user()->can('cadastrar_valores_base', \App\Models\Budgets::class)) {
            abort(401);
        }

        $budget_trackers = BudgetTrackers::get();
        if(request()->has('provincia')){
            $defaultValues = BudgetTrackerDefaultValues::with('budget_tracker')->whereHas('budget_tracker')->where('provincia',request('provincia'))->get();
        }else{
            $defaultValues = BudgetTrackerDefaultValues::with('budget_tracker')->whereHas('budget_tracker')->get();
        }
        // return $defaultValues;
        return view('budget.config.default_values', compact('budget_trackers', 'defaultValues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('cadastrar_valores_base', \App\Models\Budgets::class)){
            abort(401);
        }

        $request->validate([
            'tipo_despesa' => 'required|string',
            'provincia' => 'required|string',
            'value' => 'required',
        ],[
            'required' => __('lang.errors.messages.required')
        ],[
            'tipo_despesa' => __('Tipo de Despesa'),
            'provincia' => __('Província'),
            'value' => __('Valor'),
        ]);

        try {

            $check_data = BudgetTrackerDefaultValues::where('budget_tracker_id', $request['tipo_despesa'])
                ->where('provincia', $request['provincia'])
                ->first();

            if($check_data){
                return back()->with('error', 'Ja foi cadastrado um valor base para esse tipo de despesa e provincia!');
            }

            $valor_base = new BudgetTrackerDefaultValues();
            $valor_base->budget_tracker_id = $request['tipo_despesa'];
            $valor_base->provincia = $request['provincia'];
            $valor_base->value = $request['value'];
            $valor_base->author_id = auth()->user()->id;
            $valor_base->created_on = now();
            $valor_base->updated_on = now();
            $valor_base->save(); // Save data into database

            return back()->with('success', 'Dados Cadastrados com sucesso!');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'Ocorreu um erro ao gravar os dados. Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetTrackerDefaultValues  $budgetTrackerDefaultValues
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetTrackerDefaultValues $budgetTrackerDefaultValues)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetTrackerDefaultValues  $default_value
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetTrackerDefaultValues $default_value)
    {
        if (!auth()->user()->can('atualizar_valores_base', \App\Models\Budgets::class)) {
            abort(401);
        }

        $budget_trackers = BudgetTrackers::get();

        $defaultValues = BudgetTrackerDefaultValues::with('budget_tracker')->whereHas('budget_tracker')->get();
        // return $defaultValues;
        return view('budget.config.default_values_edit', compact('budget_trackers', 'defaultValues', 'default_value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetTrackerDefaultValues  $default_value
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetTrackerDefaultValues $default_value)
    {
        if (!auth()->user()->can('atualizar_valores_base', \App\Models\Budgets::class)) {
            abort(401);
        }

        $request->validate([
            'tipo_despesa' => 'required|string',
            'provincia' => 'required|string',
            'value' => 'required',
        ], [
            'required' => __('lang.errors.messages.required')
        ], [
            'tipo_despesa' => __('Tipo de Despesa'),
            'provincia' => __('Província'),
            'value' => __('Valor'),
        ]);

        try {
            $default_value->value = $request['value'];
            $default_value->author_id = auth()->user()->id;
            $default_value->update(); // Update
            return redirect()->route('budget.config.valor_base')->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'Ocorreu um erro ao gravar os dados. Error');
        }
        return $default_value;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetTrackerDefaultValues  $default_value
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetTrackerDefaultValues $default_value)
    {
        //
    }
}
