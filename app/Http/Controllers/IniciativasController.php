<?php

namespace App\Http\Controllers;

use App\Models\Iniciativa;
use Illuminate\Http\Request;

class IniciativasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $iniciativas = Iniciativa::all();
        return view('iniciativas.index',compact('iniciativas'));
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
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function show(Iniciativa $iniciativa)
    {
        return view('iniciativas.show', compact('iniciativas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function edit(Iniciativa $iniciativa)
    {
        return view('iniciativas.edit', compact('iniciativa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iniciativa $iniciativa)
    {
        $request->validate([
            'nome' => 'required',

        ]);

        $iniciativa->update($request->all());

        return redirect()->route('iniciativas.index')
                            ->with('success', 'iniciativa Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iniciativa  $iniciativa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iniciativa $iniciativa)
    {
        $iniciativa->delete();

        return redirect()->route('iniciativas.index')
                            ->with('success', 'Iniciativa Deleted Successfully!');
    }
}
