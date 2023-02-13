<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Projects;
use App\Http\Controllers\ProjectsController;

class UsoSistema extends Component
{
   public $projectsData = [];

    public function mount()
    {
        $this->loadProjects();
    }

    public function render()
    {
        return view('livewire.uso-sistema');
    }

    public function loadProjects()
    {

        $results = Projects::where('type', 'Project')->get();

        foreach ($results as $key => $item ){
            $resul =  Projects::find($item->id)->custom_field_values()->get();
        };

        $this->projectsData = $resul;

    }



}
