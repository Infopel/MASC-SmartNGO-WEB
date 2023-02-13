<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Relatorios extends Component
{
    public $dataTable = [];
    public $projectPDE = null;

    public $dataGrath = [];

    public $project_pdes = [];
    public $project = null;
    public $selected_project = null;

    public $data_graph = null;

    public $year;

    public $active = 'RFPDE';

    public function mount()
    {
        $this->project_pdes = \App\Models\Projects::where('type', "PDE")->get();
        $this->selected_project = $this->project_pdes[0]->id;
        $this->project = \App\Models\Projects::where('id', $this->project_pdes[0]->id)->first();
        $this->dataTable = \App\Models\Projects::where('parent_id', $this->project_pdes[0]->id)->with('orcamento')->get();
        $this->dataTable->filter(function ($project) {
            return $project['childs'] = $project->childs;
        });

        $this->process_data_to_graph($this->dataTable);

        // dd($this->data_graph);
    }

    public function render()
    {
        return view('livewire.relatorios');
    }

    /**
     * On Select project pde
     */

    public function updatedSelectedProject()
    {
        $this->project = \App\Models\Projects::where('id', $this->selected_project)->first();
        $this->dataTable = \App\Models\Projects::where('parent_id', $this->selected_project)->with('orcamento')->get();
        $this->dataTable->filter(function ($project) {
            return $project['childs'] = $project->childs;
        });

        $this->process_data_to_graph($this->dataTable);
    }

    /**
     * Whe user select a year
     */
    public function updatedYear()
    {
        // run action;
        dd('User has checed the year');
    }

    /**
     * Process data to grath
     */
    public function process_data_to_graph($data)
    {
        $array = [];
        foreach ($data as $key => $value) {
            if(isset($value->childs)){
                foreach ($value->childs as $child) {
                    $array[] = array(
                        'project' => $child->name,
                        'orcamento_inicial' => $child->orcamento->sum('orcamento_inicial'),
                        'orcamento_gasto' => $child->orcamento->sum('orcamento_gasto')
                    );
                }
            }
        }

        return $this->data_graph = $array;
    }

    /**
     * Recursive data process
     */
    public function recursive_data_process($data)
    {
        return false;
    }
}
