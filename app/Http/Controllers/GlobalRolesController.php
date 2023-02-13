<?php

namespace App\Http\Controllers;

use App\Models\GlobalRoles;
use Illuminate\Http\Request;

class GlobalRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $roles = GlobalRoles::get();
        $roles = [];

        return view('roles.global.index', compact('roles'));
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
     * @param  \App\Models\GlobalRoles  $globalRoles
     * @return \Illuminate\Http\Response
     */
    public function show(GlobalRoles $globalRoles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GlobalRoles  $globalRoles
     * @return \Illuminate\Http\Response
     */
    public function edit(GlobalRoles $globalRoles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GlobalRoles  $globalRoles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GlobalRoles $globalRoles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GlobalRoles  $globalRoles
     * @return \Illuminate\Http\Response
     */
    public function destroy(GlobalRoles $globalRoles)
    {
        //
    }
}
