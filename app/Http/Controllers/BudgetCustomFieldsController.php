<?php

namespace App\Http\Controllers;

use App\Models\CustomFields;
use App\Models\BudgetCUstomFIelds;
use Illuminate\Http\Request;

class BudgetCustomFieldsController extends Controller
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
        $issues_custom_fields = CustomFields::where('type', 'IssueCustomField')->get();
        $used_custom_fields = BudgetCustomFields::get()->map(function ($item){
            return $item->custom_field_id;
        })->toArray();

        return view('budget.config.custom_fields.new', compact('issues_custom_fields', 'used_custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = collect($request->custom_fields)->filter(function($item){
            return $item;
        });
        try {
            BudgetCustomFields::whereNotIn('custom_field_id', $request)->delete();
            foreach ($request as $key => $custom_field_id) {
                $budget_custom_fileds = new BudgetCustomFields();
                $budget_custom_fileds->custom_field_id = $custom_field_id;
                $budget_custom_fileds->created_on = now();
                $budget_custom_fileds->updated_on = now();
                // Don't save data if we found an record related to the reqested field id
                if(!BudgetCustomFields::where('custom_field_id', $custom_field_id)->withTrashed()->first()){
                    $budget_custom_fileds->save(); // Save data into database
                }
                // if we found trashed we restore the data
                $trashed = BudgetCustomFields::where('custom_field_id', $custom_field_id)->onlyTrashed()->first();
                if($trashed){
                    $trashed->restore();
                }
            }
            return back()->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'Encontramos um erro. Não foi possivel cadastrar os dados!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetCustomFields  $budgetCustomFields
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetCustomFields $budgetCustomFields)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetCustomFields  $budgetCustomFields
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetCustomFields $budgetCustomFields)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetCustomFields  $budgetCustomFields
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetCustomFields $budgetCustomFields)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetCustomFields  $budgetCustomFields
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetCustomFields $budgetCustomFields)
    {
        //
    }
}
