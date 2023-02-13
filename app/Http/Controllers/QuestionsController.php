<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use App\Models\QuestionnaireCategories;
use Symfony\Component\Yaml\Yaml;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionnaireCategories $questionnaireCategory)
    {
        // return $questionnaireCategory;
        $questions = Questions::where('category_id', $questionnaireCategory->id)->get();
        return view('questions.index', compact('questionnaireCategory', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(QuestionnaireCategories $questionnaireCategory)
    {
        return view('questions.new', compact('questionnaireCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, QuestionnaireCategories $questionnaireCategory)
    {
        $request->validate([
            'question.title' => 'required|unique:questions,title',
            'question.format' => 'required',
        ], [
            'required' => __('lang.errors.messages.required')
        ], [
            'question.title' => __('lang.field_title'),
            'question.format' => __('lang.field_format'),
        ]);

        $question_possible_values = null;
        if ($request->question['format'] == 'list') {
            $values =  explode("\n", str_replace("\r", "", $request->question['possible_values']));
            $question_possible_values = Yaml::dump($values);
        }

        // return $request;
        // return $question_possible_values;
        try {
            $question = new Questions();

            $question->title = $request->question['title'];
            $question->category_id = $questionnaireCategory->id;
            $question->format = $request->question['format'];
            $question->options_values = $question_possible_values;
            $question->multiple = $request->question['multiple'] ?? 0;
            $question->required = $request->question['required'] ?? 0;
            $question->is_outro_available = $request->question['is_outro_available'] ?? 0;
            $question->created_on = now();
            $question->updated_on = now();

            $question->save(); // Save data into database

            if ($request->has('continue')) {
                return back()->with('questions.index', ['questionnaireCategory' => $questionnaireCategory->id])->with('success', 'A pergunta foi salva com sucesso!');
            }

            return redirect()->route('questions.index', ['questionnaireCategory' => $questionnaireCategory->id])->with('success', 'A pergunta foi salva com sucesso!');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'Os dados nao foram cadastrados.<br>Encontramos um erro!, Type: \App\Question::class Store Request.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Questions  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Questions  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionnaireCategories $questionnaireCategory, Questions $question)
    {
        return view('questions.edit', compact('questionnaireCategory', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Questions  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuestionnaireCategories $questionnaireCategory, Questions $question)
    {
        $request->validate(
            [
                'question.title' => 'required|unique:questions,title,' . $question->id,
                'question.format' => 'required',
            ],
            [
                'required' => __('lang.errors.messages.required')
            ],
            [
                'question.title' => __('lang.field_title'),
                'question.format' => __('lang.field_format'),
            ]
        );

        $question_possible_values = null;
        if ($request->question['format'] == 'list') {
            $values =  explode("\n", str_replace("\r", "", $request->question['possible_values']));
            $question_possible_values = Yaml::dump($values);
        }

        try {
            $question->title = $request->question['title'];
            $question->category_id = $questionnaireCategory->id;
            $question->format = $request->question['format'];
            $question->options_values = $question_possible_values;
            $question->multiple = $request->question['multiple'] ?? 0;
            $question->required = $request->question['required'] ?? 0;
            $question->is_outro_available = $request->question['is_outro_available'] ?? 0;
            $question->updated_on = now();

            $question->update(); // Update data into database
            return back()->with('success', 'A pergunta foi atualizada com sucesso!');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Ocorreu um erro ao atualizar os dados!');
        }
    }

    public function remvoe_request(QuestionnaireCategories $questionnaireCategory, Questions $question)
    {
        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'question_title' => $question->title,
            'question_id' => $question->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Questions  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionnaireCategories $questionnaireCategory, Questions $question)
    {
        try {
            $question->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocorreu um erro ao tentar remover a pergunta! Se o erro se repetir contacte o Administrador.');
            //throw $th;
        }
    }


    public function from()
    {
        $questionnaireCategories = QuestionnaireCategories::where('active', true)->with('questions')->get();

        // return $questionnaireCategories;

        return view('questions.formulario.index', compact('questionnaireCategories'));
    }
}
