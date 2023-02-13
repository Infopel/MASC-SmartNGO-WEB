<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Questions;
use Symfony\Component\Yaml\Yaml;

class EvaluationSurveyComponent extends Component
{
    public $partner;
    public $partnerAssessment;
    public $assessmentSurvey = [];
    public $answer_multiple_values = [];
    public $answer_one_value = null;
    public $answer_bool_value = null;

    public function mount($partner, $partnerAssessment)
    {
        $this->partnerAssessment = $partnerAssessment;
        $this->partner = $partner;

        $this->assessmentSurvey = $partnerAssessment->assessment_survey()
            ->where('partner_id', $partner->id)
            ->get();
    }

    /**
     * Render Component
     */
    public function render()
    {
        return view('livewire.evaluation-survey-component');
    }


    /**
     * Save Non Multiple Option Answer
     *
     * @param $question_id
     * @param $value
     */
    public function saveNonMultipleOptionAnswer($question_id, $value)
    {
        if ($this->partnerAssessment->is_submited) {
            return;
        }

        $this->temp_saved_values = [];

        try {
            $question = Questions::where('id', $question_id)->firstOrFail();

            $assessmentSurvey = $this->partnerAssessment->assessment_survey()
                ->where('partner_id', $this->partner->id)
                ->where('question_id', $question->id)
                ->firstOrFail();

            $assessmentSurvey->value = $value;
            $assessmentSurvey->updated_on = now();
            $assessmentSurvey->status = true;
            $assessmentSurvey->update();

            $this->temp_saved_values = array("temp_answer_question_id_" . $question->id . "");

            return session()->flash('success', 'Saved');
        } catch (\Throwable $th) {
            // throw $th;
            return session()->flash('error', 'This Question is not a avalible or an error has occured. Please if this happen again reload the page or contact the support team!');
        }
    }


    public $temp_saved_values = [];
    /**
     * Save on Multiple Answer
     *
     * @param int $question_id
     * @param array $value
     * @return \Illuminate\Http\Response
     * @return Session Flash Response
     */
    public function saveMultipleValueAnswer($question_id, $value, $isChecked = false)
    {
        if ($this->partnerAssessment->is_submited) {
            return;
        }

        $this->temp_saved_values = array();

        try {
            $question = Questions::where('id', $question_id)->where('multiple', true)->firstOrFail();
            $assessmentSurvey = $this->partnerAssessment->assessment_survey()
                ->where('partner_id', $this->partner->id)
                ->where('question_id', $question->id)
                ->firstOrFail();

            $parsed_yaml = Yaml::parse($assessmentSurvey->value ?? "") ?? [];

            if (in_array($value, $parsed_yaml)) {
                $parsed_yaml = array_diff($parsed_yaml, [$value]);
            } else {
                array_push($parsed_yaml, $value);
            }

            $assessmentSurvey->value = Yaml::dump($parsed_yaml);
            $assessmentSurvey->updated_on = now();
            $assessmentSurvey->status = true;
            $assessmentSurvey->update();

            $this->temp_saved_values = array("temp_answer_question_id_" . $question->id . "");

            return session()->flash('success', 'Saved');
        } catch (\Throwable $th) {
            return session()->flash('error', 'Ocorreu um erro ao salvar a respotada temporariamente...
                Se continuar, por favor preencha e submeta as respotas de todo formulario. "Thank you!"');
            // throw $th;
        }
    }
}
