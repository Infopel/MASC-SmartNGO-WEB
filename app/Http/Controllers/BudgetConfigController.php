<?php

namespace App\Http\Controllers;

use App\Models\CustomFields;
use App\Models\BudgetTrackers;
use App\Models\BudgetCUstomFIelds;
use Illuminate\Http\Request;

class BudgetConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $budget_trackers = BudgetTrackers::get();

        $issues_custom_fields = CustomFields::where('type', 'IssueCustomField')->get();
        $used_custom_fields = BudgetCustomFields::get()->map(function ($item) {
            return $item->custom_field_id;
        })->toArray();
        return view('budget.config.index', compact('budget_trackers', 'issues_custom_fields', 'used_custom_fields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
