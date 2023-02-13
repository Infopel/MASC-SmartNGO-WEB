<?php

namespace App\Http\Controllers;

use App\Models\Partners;
use App\Models\Assessment;
use App\Models\CustomFields;
use App\Models\CustomValues;
use App\Models\Enumerations;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use App\Models\AssessmentAnswers;
use App\Models\PartnerAssessments;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\AttachmentsHelper;
use App\Http\Controllers\Helpers\CustomFieldsHelper;

class PartnersController extends Controller
{

    use CustomFieldsHelper, AttachmentsHelper;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partners::with('tipo')->paginate(30)->onEachSide(5);

        // return $partners;
        return view('partners.index', compact('partners'));
    }

    /**
     * Display Survey Resource
     */
    public function survey(Partners $partner, PartnerAssessments $partnerAssessment)
    {
        return view('partners.survey.index', compact('partner', 'partnerAssessment'));
    }

    /**
     * Store Servey Submission
     *
     * @param Request  $request
     * @param Partners $partner
     * @param Assessment $assessment
     */
    public function surveyStore(Request $request, Partners $partner, PartnerAssessments $partnerAssessment)
    {
        // return $request;
        try {

            DB::beginTransaction();
            // Store Radio - One Option Answer
            if ($request->has('answer.radio')) {
                if ($request->has('answer.radio.outra')) {
                    foreach ($request->answer['radio']['outra'] as $questionID => $answer) {
                        $assessmentAnswers = AssessmentAnswers::where('question_id', $questionID)
                            ->where('assessment_id', $partnerAssessment->id)
                            ->first();

                        $assessmentAnswers->value = null;
                        $assessmentAnswers->outro_value = $answer;
                        $assessmentAnswers->updated_on = now();
                        $assessmentAnswers->update(); // Update data into database
                    }
                } else {
                    foreach ($request->answer['radio']['question'] as $questionID => $answer) {
                        $assessmentAnswers = AssessmentAnswers::where('question_id', $questionID)
                            ->where('assessment_id', $partnerAssessment->id)
                            ->first();

                        $assessmentAnswers->value = $answer;
                        $assessmentAnswers->updated_on = now();
                        $assessmentAnswers->update(); // Update data into database
                    }
                }
            }

            // Store Multiple Options Answer
            if ($request->has('answer.checkbox')) {

                foreach ($request->answer['checkbox']['question'] as $questionID => $answer) {
                    $assessmentAnswers = AssessmentAnswers::where('question_id', $questionID)
                        ->where('assessment_id', $partnerAssessment->id)
                        ->first();

                    $assessmentAnswers->value = Yaml::dump($answer);
                    $assessmentAnswers->updated_on = now();
                    $assessmentAnswers->update(); // Update data into database
                }

                if ($request->has('answer.checkbox.outra')) {
                    foreach ($request->answer['checkbox']['outra'] as $questionID => $answer) {
                        $assessmentAnswers = AssessmentAnswers::where('question_id', $questionID)
                            ->where('assessment_id', $partnerAssessment->id)
                            ->first();

                        $assessmentAnswers->outro_value = $answer;
                        $assessmentAnswers->updated_on = now();
                        $assessmentAnswers->update(); // Update data into database
                    }
                }
            }

            // Store Text Values
            if ($request->has('answer.text')) {
                foreach ($request->answer['text']['question'] as $questionID => $answer) {
                    $assessmentAnswers = AssessmentAnswers::where('question_id', $questionID)
                        ->where('assessment_id', $partnerAssessment->id)
                        ->first();

                    $assessmentAnswers->value = $answer;
                    $assessmentAnswers->updated_on = now();
                    $assessmentAnswers->update(); // Update data into database
                }
            }

            $partnerAssessment->is_submited = true;
            $partnerAssessment->submited_on = now();
            $partnerAssessment->update(); // Update data into database

            DB::commit();

            return back()->with('success', "Submissão da avaliação registada com sucesso!.");
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', "Ocorreu um erro ao gravar os dados da submissão da avaliação.");
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('cadastrar_parceiros', Partners::class)) {
            abort(401);
        }

        $partner = [];
        $partners_type = Enumerations::where('type', 'PartnersCategory')->get();
        $custom_fields_values = CustomValues::where('customized_type', 'Partners')->get();
        $_custom_fields = CustomFields::where('type', 'PartnerCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label(null, [], $_custom_fields);

        // return $custom_fields;
        return view('partners.new', compact('partner', 'partners_type', 'custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('cadastrar_parceiros', Partners::class)) {
            abort(401);
        }


        // Validar os dados do request
        $request->validate([
            'partner.name' => 'required||unique:partners,name',
            'partner.type' => 'required|int',
            'partner.address' => 'required',
            'partner.email_address' => 'required|unique:partners,email_address|email',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'partner.name' => __('lang.field_name'),
            'partner.type' => __('lang.field_type'),
            'partner.address' => __('lang.label_partner_address'),
            'parnenr.email_address' => __('lang.field_mail')
        ]);

        // return $request;

        try {
            DB::beginTransaction();

            $partner = new Partners();
            $partner->name = $request->partner['name'];
            $partner->type = $request->partner['type'];
            $partner->natureza = $request->partner['natureza'];
            $partner->address = $request->partner['address'];
            $partner->email_address = $request->partner['email_address'];
            // $partner->identity_url = $request->partner['identity_url'] ?: null;
            $partner->start_date = $request->partner['start_date'];
            $partner->created_on = now();
            $partner->updated_on = now();
            $partner->save(); // Save data into database

            // Store CustomValues into Database
            $this->store_custom_fildes_values($request->custom_field_values, $partner->id, "Partner");

            // Store Attachments
            if ($request->has('attachments')) {
                foreach ($request->attachments as $file) {
                    if ($file['file'] != null) {
                        $this->store_attachment($partner->id, $file['file'], "Partner", $partner->name);
                    }
                }
            }

            DB::commit();

            return redirect()->route('partners.index')->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            // throw $th;
            return redirect()->route('partners.index')->with('error', __('Ocorreu um erro ao gravar os dados do parceiro.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partners  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partners $partner)
    {
       // dd($partner);
        $partners_type = Enumerations::where('type', 'PartnersCategory')->get();
        $custom_fields_values = CustomValues::where('customized_type', 'Partner')->get();
        $_custom_fields = CustomFields::where('type', 'PartnerCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label($partner->id, $custom_fields_values, $_custom_fields);
        //dd($partner->attachments);
        // return $custom_fields;
        return view('partners.show', compact('partner', 'partners_type', 'custom_fields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partners  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit(Partners $partner)
    {
        if (!auth()->user()->can('cadastrar_parceiros', Partners::class)) {
            abort(401);
        }

        $partners_type = Enumerations::where('type', 'PartnersCategory')->get();
        $custom_fields_values = CustomValues::where('customized_type', 'Partners')->get();
        $_custom_fields = CustomFields::where('type', 'PartnerCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label(null, [], $_custom_fields);

        return view('partners.edit', compact('partner', 'partners_type', 'custom_fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partners  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partners $partner)
    {
        if (!auth()->user()->can('cadastrar_parceiros', Partners::class)) {
            abort(401);
        }
        // Validar os dados do request
        $request->validate([
            'partner.name' => 'required|',
            'partner.type' => 'required|int',
            'partner.address' => 'required',
            'partner.email_address' => 'required|email',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.errors.messages.taken')
        ], [
            'partner.name' => __('lang.field_name'),
            'partner.type' => __('lang.field_type'),
            'partner.address' => __('lang.label_partner_address'),
            'parnenr.email_address' => __('lang.field_mail')
        ]);

        // return $request;
        try {
            DB::beginTransaction();

            $partner->name = $request->partner['name'];
            $partner->type = $request->partner['type'];
            $partner->natureza = $request->partner['natureza'];
            $partner->address = $request->partner['address'];
            $partner->email_address = $request->partner['email_address'];
            $partner->type_fund = $request->partner['type_fund'];
            // $partner->identity_url = $request->partner['identity_url'] ?: null;
            $partner->start_date = $request->partner['start_date'];
            $partner->end_date = $request->partner['end_date'];
            $partner->updated_on = now();
            $partner->update(); // Update

            // Store CustomValues into Database
            $this->update_custom_fildes_values($request->custom_field_values, $partner->id, "Partner");

            // Store Attachments
            if ($request->has('attachments')) {
                foreach ($request->attachments as $file) {
                    if ($file['file'] != null) {
                        $this->store_attachment($partner->id, $file['file'], "Partner", $partner->name);
                    }
                }
            }

            DB::commit();
            return back()->with('success', __('lang.notice_successful_create'));
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return back()->with('error', __('Ocorreu um erro ao atualizar os dados do parceiro.'));
        }
    }


    /**
     * Confirmation for delete partner request
     */
    public function remove_confirmation(Partners $partner)
    {
        if (!auth()->user()->can('remover_parceiros', [Partners::class, $partner])) {
            abort(401);
        }

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'partner_name' => $partner->name,
            'partner_id' => $partner->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partners  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partners $partner)
    {
        if (!auth()->user()->can('remover_parceiros', [Partners::class, $partner])) {
            abort(401);
        }

        try {
            $partner->delete(); // Delete
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Ocorreu um erro ao tentar remover o parceiro');
            //throw $th;
        }
    }
}
