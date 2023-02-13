<?php

namespace App\Http\Livewire;

use App\Models\BudgetsValues;
use App\Models\IndicatorFieldsIssues;
use App\Models\IndicatorFieldsValues;
use App\Models\RubricasOrcamento;
use Livewire\Component;

class AprovacaoFundos extends Component
{
    public $issue;
    public $project;
    public $filter_year;
    public $filter_month;
    public $filter_day;
    public $filter_provincia;
    public $filter_value;

    public $rubrica_orcamento = null;

    public $orcamento_solicitado;
    public $indicators = [];

    public $showModal = false;
    public $nivel_description = null;
    public $approvement;

    public function mount($issue, $project)
    {
        $this->project = $project;
        $this->issue = $issue;
        $this->getIndicators();

        // dd($issue->issue_approvement_requests);
    }

    public function render()
    {
        return view('livewire.aprovacao-fundos');
    }


    public function showModal($approvement = null, $nivel_description)
    {
        $this->nivel_description = $nivel_description;
        $this->approvement = $approvement;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->nivel_description = null;
        $this->nivel = null;
        $this->showModal = false;
    }

    public function getCabimentoOrcamental($id)
    {
        $this->rubrica_orcamento = RubricasOrcamento::where('id', $id)
            ->where('project_id', $this->issue->project_id)
            ->first();

        // dd($this->rubrica_orcamento);

        $this->orcamento_solicitado = BudgetsValues::where('customized_id', $this->issue->id)
            ->where('budget_tracker_id', $this->rubrica_orcamento['id'])
            ->first();
    }

    public function getIndicators()
    {
        $this->indicators = IndicatorFieldsValues::where('customized_id', $this->issue->id)->with('indicator_field')->get();
    }
}
