<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RelatorioBeneficiarios extends Component
{
    public $active = 'relatorio_beneficiarios';
    public $project;

    public function render()
    {
        return view('livewire.relatorio-beneficiarios');
    }
}
