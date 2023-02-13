<?php

namespace App\Http\Livewire;

use App\Models\Issues;
use Livewire\Component;

class RelatorioActividadesProvincia extends Component
{
    public $active = 'actividades_provincia';
    public $issues;

    public function mount()
    {
        $this->load_data();
    }

    public function render()
    {
        return view('livewire.reports.actividades-provincia');
    }


    public function load_data()
    {
        $this->issues = Issues::with('provincia', 'indicators', 'project')->whereHas('provincia')->whereHas('project')->get();
        // dd($issues->toArray());
    }
}
