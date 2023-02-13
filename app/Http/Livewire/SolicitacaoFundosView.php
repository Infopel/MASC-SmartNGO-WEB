<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ApprovementFlow;
use App\Models\SolicitacaoFundos;
use App\Models\FlowSolicitacaoFundos;
use App\Http\Controllers\Features\SolicitacaoFundos\SolicitacaoFundosRepository;

class SolicitacaoFundosView extends Component
{
    protected $solicitacaoFundos;

    public $showUserApprovalRequests = false;

    public $search_solicitacao_objectivo;

    public $toApproveSolicitacaoFundos = [];
    public $requestsSolicitacaoFundos = [];

    public $years = [
        'year' => 2021
    ];

    public $filter_ano;
    public $filter_mes;
    public $filter_status;
    public $filter_flow;

    public $is_approved = false;
    public $is_rejected = false;

    public $project;
    public $approvement_flows = [];

    public function mount(SolicitacaoFundosRepository $solicitacaoFundos, $project)
    {
        $this->project = $project;
        $this->solicitacaoFundos = $solicitacaoFundos;
        $this->approvement_flows = ApprovementFlow::where('is_active', true)->get();


        $this->loadUserSolicitacaoFundosRequests();
        // dd($this->requestsSolicitacaoFundos[0]['num_requisicao']);
    }


    public function render()
    {
        return view('livewire.solicitacao-fundos-view');
    }


    public function updatedFilterStatus()
    {
        switch ($this->filter_status) {
            case 'approved':
                $this->is_approved = true;
                $this->is_rejected = false;
                break;
            case 'pending':
                $this->is_approved = false;
                $this->is_rejected = false;
                break;
            case 'rejected':
                $this->is_approved = false;
                $this->is_rejected = true;
                break;
            default:
                break;
        }

        $this->loadUserSolicitacaoFundosRequests();
    }

    public function loadUserSolicitacaoFundosRequests()
    {
        $this->solicitacaoFundos = new SolicitacaoFundosRepository();


        $this->toApproveSolicitacaoFundos = $this->solicitacaoFundos->toApproveFlow($this->project->id, [
            'mes' => $this->filter_mes,
            'is_rejected' => $this->is_rejected,
            'is_approved' => $this->is_approved,
            'ano' => $this->filter_ano,
            'flow' => $this->filter_flow
        ]);
        $this->requestsSolicitacaoFundos = $this->solicitacaoFundos->findRequestByUserID(auth()->user()->id, $this->project->id, [
            'mes' => $this->filter_mes,
            'is_rejected' => $this->is_rejected,
            'is_approved' => $this->is_approved,
            'ano' => $this->filter_ano,
            'flow' => $this->filter_flow
        ]);
    }


    public function loadUserRequestSolicitacaoFundos($solicitacaoFundos)
    {
        $this->solicitacaoFundos = new SolicitacaoFundosRepository();

        $this->requestsSolicitacaoFundos = $this->solicitacaoFundos->findRequestByUserID(auth()->user()->id, $this->project->id);
    }

    public function choseDataPoll()
    {
        return $this->showUserApprovalRequests = !$this->showUserApprovalRequests;
    }


    public $enable_delete_on = [];

    public function delete_solicitacaoFundos($idRequestFlow, string $requestNum, $isSubmit = false)
    {
        if (!$isSubmit) {
            $this->enable_delete_on = [$idRequestFlow];
            return;
        }

        try {
            $flowStep = FlowSolicitacaoFundos::where('id', $idRequestFlow)->where('num_requisicao', $requestNum)->firstOrFail();
            SolicitacaoFundos::where('id', $flowStep->solicitacao_id)->where('num_requisicao', $requestNum)->delete();
            $flowStep->delete();

            $this->loadUserRequestSolicitacaoFundos($this->solicitacaoFundos);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cancel_delete_request()
    {
        $this->enable_delete_on = [];
    }
}
