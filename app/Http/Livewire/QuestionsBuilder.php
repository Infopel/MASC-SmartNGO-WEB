<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Symfony\Component\Yaml\Yaml;

class QuestionsBuilder extends Component
{

    public $question_format = 'bool';
    public $is_multiple_values;
    public $is_outro_available;
    public $possible_values;
    public $questionnaireCategory;
    public $isEdit;
    public $question;

    public $question_title;


    public function mount($questionnaireCategory, $question = [], $isEdit = false)
    {
        // dd($question['question']);
        $this->isEdit = $isEdit;
        $this->questionnaireCategory = $questionnaireCategory['questionnaireCategory'];
        $this->question = $question['question'];

        $this->question_title = $question['question']['title'] ?? null;
        $this->is_multiple_values = $question['question']['multiple'] ?? 0;
        $this->possible_values = $question['question']['options_values'] ?? null;
        $this->possible_values = str_replace('- ', '', $this->possible_values);
        $this->possible_values = str_replace('\'', '', $this->possible_values);
        $this->question_format = $question['question']['format'] ?? $this->question_format;
    }

    public function render()
    {
        return view('livewire.questions-builder');
    }


    /**
     * Alterar tipo de entrada de dados para as resposta da questao.
     */
    public function updatedQuestionFormat()
    {
    }

    public $preview_possible_values = [];
    public function preview()
    {
        /** List format type */
        if ($this->question_format !== 'list') {
            return;
        }
        $this->preview_possible_values = collect(explode("\n", str_replace("\r", "", $this->possible_values)))->filter(function ($value) {
            if ($value !== '') {
                return $value;
            }
        })->toArray();
    }
}
