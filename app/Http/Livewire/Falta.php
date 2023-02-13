<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Projects;
use App\Http\Controllers\ProjectsController;

class Falta extends Component
{
    public function render()
    {
        return view('livewire.falta');
    }

    public $projectsData = [];

    public function mount()
    {
        $this->loadProjects();
    }

    public function loadProjects()
    {

        $results = Projects::where('type','Project')->with('custom_fields')->get(['id','name']);

        $this->projectsData = $results;

    }

}
