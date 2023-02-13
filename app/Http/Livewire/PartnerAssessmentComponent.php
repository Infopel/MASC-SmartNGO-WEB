<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Assessment;
use App\Models\AssessmentAnswers;
use App\Models\PartnerAssessments;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionnaireCategories;

class PartnerAssessmentComponent extends Component
{

    public $description;
    public $modal_create_assessment = false;
    public $partnerAssessments = [];
    public $assessments = [];
    public $questionsCategories = [];
    public $partner;
    public $isNewAssessment = false;
    public $selectedAssessment;

    public function mount($partner)
    {
        $this->partner = $partner;
        $this->assessments = Assessment::get();
        $this->loadAssessment();
    }

    public function render()
    {
        return view('livewire.partner-assessment-component');
    }

    public function loadAssessment()
    {
        $this->partnerAssessments = PartnerAssessments::with('partner', 'assessment')->where('partner_id', $this->partner->id)->get();
    }

    /**
     * Set Assessment Type
     * \n\n Options: (new)/(use)
     *
     * @param boolean $assessmentType
     * @return boolean $isNewAssessment
     */
    public function toogleAssessment($assessmentType = false)
    {
        if ($assessmentType) return $this->isNewAssessment = true;
        return $this->isNewAssessment = false;
    }

    public function modalCreateAssessment()
    {
        $this->modal_create_assessment = true;
        $this->questionsCategories = QuestionnaireCategories::where('active', true)->get();
    }

    public function closeModal()
    {
        $this->modal_create_assessment = false;
        $this->description = null;
    }

    public function createPartnerAssessmet()
    {
        try {
            DB::beginTransaction();
            if ($this->isNewAssessment) {
                // Criar Parter Assessmet
                $assessment = new Assessment();
                $assessment->description = $this->description;
                $assessment->data = now();
                $assessment->author_id = auth()->user()->id;
                $assessment->created_on = now();
                $assessment->updated_on = now();
                $assessment->status = false;

                $assessment->save();
            } else {
                $assessment = Assessment::where('id', $this->selectedAssessment)->first();
            }

            // Inicalizar o store do formulario de avaliação
            $partnerAssessment = new PartnerAssessments();
            $partnerAssessment->partner_id = $this->partner->id;
            $partnerAssessment->assessment_id = $assessment->id;
            $partnerAssessment->is_submited = false;
            $partnerAssessment->author_id = auth()->user()->id;
            $partnerAssessment->created_on = now();
            $partnerAssessment->updated_on = now();
            $partnerAssessment->save(); // Save data into database

            // 1 - Pegar as Categorias -> perguntas
            foreach ($this->questionsCategories as $category) {
                foreach ($category->questions as $question) {
                    $assessmentAnswers = new AssessmentAnswers();
                    $assessmentAnswers->assessment_id = $partnerAssessment->id;
                    $assessmentAnswers->partner_id = $this->partner->id;
                    $assessmentAnswers->question_id = $question->id;
                    $assessmentAnswers->category_id = $category->id;
                    $assessmentAnswers->value = null;
                    $assessmentAnswers->status = false;
                    $assessmentAnswers->created_on = now();
                    $assessmentAnswers->updated_on = now();

                    $assessmentAnswers->save();
                }
            }

            DB::commit();
            $this->loadAssessment();
            $this->closeModal();
            return session()->flash('success', 'Avaliação criada com sucesso!');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
