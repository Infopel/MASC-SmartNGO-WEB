<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AprovementPlanFlow extends Component
{
    public $tab = "resumo";

    public function render()
    {
        return view('livewire.aprovement-plan-flow');
    }

    public function toogleTab($tab)
    {
        $this->tab = $tab;
    }
}
