<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireCategories;
use Illuminate\Http\Request;

class QuestionnaireCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaireCategories = QuestionnaireCategories::paginate(30);

        return view('questions.categories.index', compact('questionnaireCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questionnaireCategory = [];
        return view('questions.categories.new', compact('questionnaireCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'questionnaireCategory.name' => 'required|unique:questionnaire_categories,name',
            'questionnaireCategory.active' => 'required|int'
        ],[
            'required' => __('lang.errors.messages.required')
        ],[
            'questionnaireCategory.name' => __('lang.field_name'),
            'questionnaireCategory.active' => "Estado"
        ]);

        try {
            $questionnaireCategory = new QuestionnaireCategories();
            $questionnaireCategory->name = $request->questionnaireCategory['name'];
            $questionnaireCategory->position = 1;
            $questionnaireCategory->author_id = auth()->user()->id;
            $questionnaireCategory->active = $request->questionnaireCategory['active'];
            $questionnaireCategory->created_on = now();
            $questionnaireCategory->updated_on = now();
            $questionnaireCategory->save(); // Save data into database

            return back()->with('success', 'Categoria: <b>'.$questionnaireCategory->name.'. - </b>'.__('lang.notice_successful_create'));

        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error', 'Os dados nao foram cadastrados. Encontramos um erro! Error Type [RF002] - Categoria de Avaliação!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuestionnaireCategories  $questionnaireCategory
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnaireCategories $questionnaireCategory)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuestionnaireCategories  $questionnaireCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireCategories $questionnaireCategory)
    {
        return view('questions.categories.edit', compact('questionnaireCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuestionnaireCategories  $questionnaireCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionnaireCategories $questionnaireCategory)
    {

        $request->validate([
            'questionnaireCategory.name' => 'required',
            'questionnaireCategory.active' => 'required|int'
        ], [
            'required' => __('lang.errors.messages.required')
        ], [
            'questionnaireCategory.name' => __('lang.field_name'),
            'questionnaireCategory.active' => "Estado"
        ]);


        $questionnaireCategory->name = $request->questionnaireCategory['name'];
        $questionnaireCategory->active = $request->questionnaireCategory['active'];
        $questionnaireCategory->updated_on = now();

        if($questionnaireCategory->isDirty('name')){
            $request->validate([
                'questionnaireCategory.name' => 'unique:questionnaire_categories,name',
            ], [
                'unique' => __('lang.errors.messages.taken')
            ], [
                'questionnaireCategory.name' => __('lang.field_name'),
            ]);
        }

        try {
            $questionnaireCategory->update(); // update
            return back()->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Os dados nao foram cadastrados Encontramos um erro. Error Type [RF002] - Update Categoria de Avaliação!');
        }
    }

    public function remvoe_request(QuestionnaireCategories $questionnaireCategory)
    {
        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'category_name' => $questionnaireCategory->name,
            'category_id' => $questionnaireCategory->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuestionnaireCategories  $questionnaireCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnaireCategories $questionnaireCategory)
    {
        try {
            if(count($questionnaireCategory->questions) > 0){
               $questionnaireCategory->questions()->delete();
            }
            $questionnaireCategory->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            throw $th;
            return back()->with('error', 'Ocorreu um erro ao tentar remover categoria de avaliação');
        }
    }
}
