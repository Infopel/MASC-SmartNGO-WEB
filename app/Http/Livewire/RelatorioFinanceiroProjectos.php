<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RelatorioFinanceiroProjectos extends Component
{
    public $dataTable = [];
    public $project = null;

    public $dataGrath = [];

    public $project_pdes = [];
    public $project_linhasEstr = [];
    public $projects = [];
    public $selected_project = null;

    public $selected_linhaEstrategica = null;

    public $active = 'RFP';

    public function mount()
    {
        $this->project_pdes = \App\Models\Projects::where('type', "PDE")->get();
    }

    public function render()
    {
        return view('livewire.relatorio-financeiro-projectos');
    }

    public function updatedSelectedProject()
    {
        $this->project = null;
        $this->project_linhasEstr = \App\Models\Projects::where('type', "Program")->get();
    }

    public function updatedSelectedLinhaEstrategica()
    {
        $this->project = \App\Models\Projects::where('id', $this->selected_linhaEstrategica)->first();
        $this->projects = \App\Models\Projects::where('parent_id', $this->selected_linhaEstrategica)->get();
    }
}
