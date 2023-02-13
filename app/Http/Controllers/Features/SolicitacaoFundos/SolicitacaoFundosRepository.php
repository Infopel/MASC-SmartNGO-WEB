<?php

namespace App\Http\Controllers\Features\SolicitacaoFundos;

use App\Models\SolicitacaoFundos;
use App\Http\Controllers\Controller;
use App\Models\FlowSolicitacaoFundos;

class SolicitacaoFundosRepository extends Controller
{

    public function saveSolicatacaoFundos(array $requestData)
    {
        dd($requestData);
    }


    protected function formatResponse($solicitacaoFundos)
    {
        return [
            "id" => $solicitacaoFundos->id,
            "issue" => $solicitacaoFundos->issue,
            "created_on" => $solicitacaoFundos->created_on,
            "updated_on" => $solicitacaoFundos->updated_on,
            "time" => $solicitacaoFundos->created_on->diffForHumans()
        ];
    }

    /**
     * Returna todas SolicitacaoFundos
     */
    public function all()
    {
        $solicitacaoFundos = SolicitacaoFundos::get();
        return $solicitacaoFundos;
    }

    /**
     * Retorna todos os requests solicitação de fundos de um project
     *
     * @param int userID
     * @param int project_id
     * @param array filters
     * @return Collection
     */
    public function findRequestByUserID(int $userID, int $project_id, array $filters = [], int $hasLimitOf = null)
    {

        if ($filters == []) {
            $solicitacao_requestNums = FlowSolicitacaoFundos::where('request_by', $userID)
                ->whereHas('solicitacao', function ($query) use ($project_id) {
                    // $query->where('project_id', $project_id);
                })->limit($hasLimitOf)->distinct('flow_solicitacao_fundos.num_requisicao')->pluck('num_requisicao');

            $response = [];
            foreach ($solicitacao_requestNums as $requestNum) {
                $response[] = \collect(
                    FlowSolicitacaoFundos::where('num_requisicao', $requestNum)
                        ->with('flow')
                        ->latest('created_on')
                        ->first()
                );
            }
        } else {
            $solicitacao_requestNums = FlowSolicitacaoFundos::where('request_by', $userID)
                ->whereHas('solicitacao', function ($query) use ($project_id) {
                    // $query->where('project_id', $project_id);
                })
                ->where('is_approved', $filters['is_approved'] ?? false)
                ->where('is_rejected', $filters['is_rejected'] ?? false)
                ->limit($hasLimitOf)
                ->distinct('flow_solicitacao_fundos.num_requisicao')->pluck('num_requisicao');
            $response = [];
            foreach ($solicitacao_requestNums as $requestNum) {
                $response[] = \collect(
                    FlowSolicitacaoFundos::where('num_requisicao', $requestNum)
                        ->with('flow')
                        ->where('is_approved', $filters['is_approved'] ?? false)
                        ->where('is_rejected', $filters['is_rejected'] ?? false)
                        ->latest('created_on')
                        ->first()
                );
            }
        }

        return $response;
    }

    /**
     * Retorna todos os requests solicitação de fundos de uma project
     *
     * @param int issue_id
     * @return Collection
     */
    public function findByProjectID(int $project_id)
    {
    }

    /**
     * Retorna todos os requests solicitação de fundos de um user
     *
     * @param int requestBy_id
     * @return Collection
     */
    public function findByUserRequestID(int $requestBy_id)
    {
    }

    public function toApproveFlow(int $project_id, array $filters = [])
    {
        if ($filters == []) {
            $solicitacao_requestNums = FlowSolicitacaoFundos::where('user_id_to', auth()->user()->id)
                ->whereHas('solicitacao', function ($query) use ($project_id) {
                    $query->where('project_id', $project_id);
                })
                ->distinct('flow_solicitacao_fundos.num_requisicao')->pluck('num_requisicao');
            $response = [];
            foreach ($solicitacao_requestNums as $requestNum) {
                $response[] = \collect(
                    FlowSolicitacaoFundos::where('num_requisicao', $requestNum)
                        ->with('flow')
                        ->with('flow.role')
                        ->whereHas('solicitacao')
                        ->with('requestBy')
                        ->with('approvedBy')
                        ->latest('created_on')
                        ->first()
                );
            }
        } else {
            $solicitacao_requestNums = FlowSolicitacaoFundos::where('user_id_to', auth()->user()->id)
                ->with('solicitacao')
                ->whereHas('solicitacao', function ($query) use ($project_id) {
                    // $query->where('project_id', $project_id);
                })
                ->where('is_approved', $filters['is_approved'] ?? false)
                ->where('is_rejected', $filters['is_rejected'] ?? false)
                ->distinct('flow_solicitacao_fundos.num_requisicao')->pluck('num_requisicao');

            $response = [];
            foreach ($solicitacao_requestNums as $requestNum) {
                $response[] = \collect(
                    FlowSolicitacaoFundos::where('num_requisicao', $requestNum)
                        ->with('flow')
                        ->with('flow.role')
                        ->whereHas('solicitacao.project')
                        ->whereHas('solicitacao')
                        ->with('requestBy')
                        ->with('approvedBy')
                        ->where('is_approved', $filters['is_approved'] ?? false)
                        ->where('is_rejected', $filters['is_rejected'] ?? false)
                        ->latest('created_on')
                        ->first()
                );
            }
        }
        return $response;
    }
}
