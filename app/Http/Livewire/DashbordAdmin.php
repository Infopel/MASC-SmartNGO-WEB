<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SolicitacaoFundos;

class DashbordAdmin extends Component
{

    public $bugType;

    public $solicitacaoData = [];

    public function mount()
    {
        $this->loadSolData();
    }

    public function render()
    {
        return view('livewire.uso-sistema');
    }


    public function loadSolData()
    {
        $results = SolicitacaoFundos::whereIn('num_requisicao', function ($query) {
            $query->select('num_requisicao')->from('solicitacao_fundos')->groupBy('num_requisicao')->havingRaw('count(*) > 1');
        })->orderby('num_requisicao')->get();

        $this->solicitacaoData = $results;
    }
}
