<?php

namespace App\Http\Controllers\Helpers\Orcamento;

trait ResumoOrcamentoHelper
{

    public $year;
    /**
     * On Select Província
     */
    public $despesas = [];
    public function updatedProvincia()
    {
        // $this->despesas = BudgetsProjects::where('provincia', $this->provincia)
        //     ->where('year', date('Y'))
        //     ->get();
    }

    /**
     * On Select Year
     */
    public function updatedYear()
    {
        // $this->despesas = BudgetsProjects::where('provincia', $this->provincia)
        //     ->where('year', $this->year)
        //     ->get();
    }
}
