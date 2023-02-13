<?php

namespace App\Http\Controllers;

use App\Macro\AppBoot;
use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\SolicitacaoFundos;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\FlowSolicitacaoFundos;

class ExportReportController extends Controller
{
    /**
     * Relatorio PDF
     * Orcamento da Tarefa
     */
    public function relatorio_orcamento(Issues $issue)
    {
        // if(!$issue->is_aproved){
        //     abort(401);
        // }
        $filename = 'Relatorio de Orçamento - ' . $issue->subject . ' --- ' . date('Y-m-d');
        $data = [
            'application' => AppBoot::application(),
            'issue' => $issue
        ];
        $pdf = PDF::loadView('report_files.issues.folha_de_abono', $data);
        return $pdf->stream($filename . '.pdf');
    }

    /**
     * Relatorio de Orçamento Mensal
     * FOLHA MENSAL DE SOLICITAÇÃO DE FUNDOS
     */
    public function relatorio_soliciracao_fundos_mensal(Projects $project_identifier)
    {
        return $project_identifier;

        $year = request('year') ?? date('Y');

        $approvementRequests = ApprovementFlowModels::select('customized_id', DB::raw('year(created_on) as created_on'))
            ->whereMonth('created_on', $year)
            ->get()
            ->groupBy('customized_id');

        // fo
    }

    /**
     * Export Resumo de Solicitação de Fundos
     *
     */
    public function export_resumo_SolicitacaoFundos(Projects $project_identifier, string $requestNum, int $requestID)
    {
        try {
            $solicitacaoFundos = SolicitacaoFundos::where('id', $requestID)->where('num_requisicao', $requestNum)->where('is_rejected', false)->firstOrFail();
        } catch (\Throwable $th) {
            return back()->with('Desculpe ocorreu um error!!! <br>Não foi possível encontrar o processo. Num: ' . $requestNum);
        }

        $filename = 'Resumo de Solicitação de Fundos - ' . $requestNum . ' --- ' . date('Y-m-d');

        $areas = \App\Models\Enumerations::where('type', 'IssueArea')->get();
        $actividades = \App\Models\Enumerations::where('type', 'IssueActividade')->get();
        $necessidades = \App\Models\Enumerations::where('type', 'IssueNecessidade')->get();

        $selected_areas = $solicitacaoFundos->areas()->get('enumeration_id')->pluck('enumeration_id')->toArray() ?? [];
        $selected_actividades = $solicitacaoFundos->actividades()->get('enumeration_id')->pluck('enumeration_id')->toArray() ?? [];
        $selected_necessidades = $solicitacaoFundos->necessidades()->get('enumeration_id')->pluck('enumeration_id')->toArray() ?? [];

        $data = \collect(
            [
                'settings' => AppBoot::application(),
                'solicitacao' => $solicitacaoFundos,
                'approvations' => [
                    '_programtica' => FlowSolicitacaoFundos::where('flow_id', 28)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_financeira' => FlowSolicitacaoFundos::where('flow_id', 22)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_contabilidade' => FlowSolicitacaoFundos::where('flow_id', 24)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_dirExec' => FlowSolicitacaoFundos::where('flow_id', 23)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first(),
                    '_lliderDaf' => FlowSolicitacaoFundos::where('flow_id', 22)->where('num_requisicao',  $solicitacaoFundos->num_requisicao)
                        ->where('solicitacao_id', $solicitacaoFundos->id)->first()
                ],
                'selected_areas' => $selected_areas,
                'selected_actividades' => $selected_actividades,
                'selected_necessidades' => $selected_necessidades
            ]
        );

        $pdf = PDF::setOptions([
            //'tempDir' => '/Users/kurozetsu/Documents/Development/PHP/cache_files',
            //'logOutputFile' => '/Users/kurozetsu/Documents/Development/PHP/cache_files/logs'
        ]);


        switch (request()->type ?? 'error') {
            case 'resumoSolicitacao':
                $pdf->loadView('solicitacaoFundos.exports.resumo', compact(
                    'data',
                    'areas',
                    'actividades',
                    'necessidades'
                ));

                return $pdf->stream($filename . '.pdf');
                break;
            case 'modeloPagamento':
                $pdf->loadView('solicitacaoFundos.exports.pagamento', compact(
                    'data',
                    'areas',
                    'actividades',
                    'necessidades'
                ));

                $filename = "Modelo-de-Pagamento-{$requestNum}-" . date('Y-m-d') . '.pdf';

                return $pdf->stream($filename);
                break;
            default:
                abort(403, 'Unknown report type to be downloaded');
                break;
        }
    }

    /**
     * Export file resumo de pagamento solicitação de fundos
     *
     */
    public function export_pagamentos_SolicitacaoFundos(Projects $project_identifier, string $requestNum, int $requestID)
    {
    }
}
