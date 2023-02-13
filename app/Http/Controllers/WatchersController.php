<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Watchers;
use Illuminate\Http\Request;

class WatchersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function watch(Request $request, Issues $issue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Watchers  $watchers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Watchers $watchers, Issues $issue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Watchers  $watchers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Watchers $watchers, Issues $issue)
    {
        //
    }
}
