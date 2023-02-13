<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BudgetsProjects;
use Illuminate\Support\Facades\DB;

class CabimentoOrcamental extends Component
{
    public $project;
    public $project_provincias = [];
    public $provincia = null;
    public $year = null;
    public $year_script;
    public $showModal = false;

    public $updated_notes;

    public function mount($project)
    {
        $this->project = $project;
        $this->year_script = date('Y');

        $this->project_provincias = \App\Models\CustomValues::where('customized_type', 'Project')
            ->where('customized_id', $project->id)
            ->where('custom_field_id', 30)
        ->get();

        $this->ini_project_despesas();

    }

    public function render()
    {
        return view('livewire.cabimento-orcamental');
    }

    public function ini_project_despesas()
    {
        if ($this->project_provincias->count() > 0) {
            $this->provincia = $this->project_provincias[0]->value;
            $this->despesas = BudgetsProjects::where('provincia', $this->provincia)
                ->where('year', $this->year ?? date('Y'))
                ->get();
        }
    }

    public $buget_project;
    public $buget_project_value;
    public $buget_project_description;

    /**
     * Show Modal with User to add as Project Members
     */
    public function editarOrcamento($id)
    {
        $this->buget_project = BudgetsProjects::where('id', $id)->where('provincia', $this->provincia)->first();
        $this->showModal = true;
    }

    public function update($id)
    {
        $buget_project = BudgetsProjects::where('id', $id)->where('provincia', $this->provincia)->first();

        $this->validate([
            'buget_project_value' => 'required',
            'buget_project_description' => 'required|string',
        ],[
            'required' => __('lang.errors.messages.required')
        ],[
            'buget_project_value' => 'Orçamento',
            'buget_project_description' => 'Descrição'
        ]);

        try {
            $this->buget_project->updated_by = auth()->user()->id;
            $this->buget_project->value = $this->buget_project_value;
            $this->buget_project->updated_notes = $this->buget_project_description;
            $this->buget_project->updated_on = now();
            $this->buget_project->update(); // Update

            $this->closeModal();
            $this->buget_project = null;
            $this->ini_project_despesas();
            session()->flash('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('errpr', __('Encontramos um erro na atuaização de dados! RF007x0001 - Contacte o Administrador.'));
        }
    }

    /**
     * Close Modal and set $users to empty array
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->buget_project_value = null;
        $this->buget_project_description = null;
    }

    /**
     * On Select Província
     */
    public $despesas = [];
    public function updatedProvincia()
    {
        $this->despesas = BudgetsProjects::where('provincia', $this->provincia)
            ->where('year', date('Y'))
            ->get();
    }

    /**
     * On Select Year
     */
    public function updatedYear()
    {
        $this->despesas = BudgetsProjects::where('provincia', $this->provincia)
            ->where('year', $this->year)
            ->get();
    }


    public function runScript()
    {
        try {
            foreach ($this->project_provincias as $provincia) {
                $despesas = BudgetsProjects::where('provincia', $provincia->value)->where('year', $this->year_script)
                    ->get();

                if($despesas->count() == 0){
                    DB::statement("INSERT INTO budgets_projects (budget_tracker_id, project_id, value, year, provincia, created_on, updated_on) SELECT id, " . $this->project->id . ", 0, '".$this->year_script."', '" . $provincia->value . "', '" . now() . "', '" . now() . "' FROM budget_trackers WHERE deleted_at IS NULL ");
                }else{
                    $buget_trackers = \App\Models\BudgetTrackers::get();
                    foreach ($buget_trackers as $buget_tracker) {

                        $orcamento_despesa = BudgetsProjects::where('provincia', $provincia->value)
                            ->where('year', $this->year_script)
                            ->where('budget_tracker_id', $buget_tracker->id)
                            ->first();

                        if(!$orcamento_despesa){

                            DB::statement("INSERT INTO budgets_projects (budget_tracker_id, project_id, value, year, provincia, created_on, updated_on) values ('$buget_tracker->id', ".$this->project['id']." , 0, '$this->year_script', '$provincia->value', '". now()."', '". now()."' )");
                        }
                    }
                }
            }
            session()->flash('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            // throw $th;
            session()->flash('errpr', __('Encontramos um erro na atuaização de dados! RF007x0001 - Contacte o Administrador.'));
        }
    }
}
