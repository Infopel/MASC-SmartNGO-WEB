<?php

namespace App\Http\Controllers;

use App\Models\Wikis;
use Illuminate\Http\Request;

class WikisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('wikis.index');
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
     * @param  \App\Models\Wikis  $wikis
     * @return \Illuminate\Http\Response
     */
    public function show(Wikis $wikis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wikis  $wikis
     * @return \Illuminate\Http\Response
     */
    public function edit(Wikis $wikis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wikis  $wikis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wikis $wikis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wikis  $wikis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wikis $wikis)
    {
        //
    }
}
