<?php

namespace App\Http\Controllers\Helpers\Reports;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Macro\AppBoot;
use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Exports\ExportReports;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

trait ReportBudgetPDEHelper
{


    public function report_financeiro_pde_api(Projects $project, Request $request)
    {
        if (!$request->has('type')) {
            return [];
        }

        $this->dataTable = \App\Models\Projects::where('parent_id', $project->id)->get();


        $years = [];

        $yearsPeriod = new DatePeriod(
            new DateTime($project->start_date),
            new DateInterval('P1Y'),
            new DateTime($project->due_date)
        );

        foreach ($yearsPeriod as $key => $value) {
            $years[] = $value->format('Y');
        }

        // get query params to display data by type
        if ($request->type == 'linha-estrategica') {
            foreach ($this->dataTable as $linha_estrategica) {
                $dataGraph[] = array(
                    'Projeto' => $linha_estrategica->name,
                    'Orçamento LE' => 0,
                    'Orçamento de Projectos' => $linha_estrategica->orcamento_inicial_sub_project,
                    'Orçamento de Gasto de Projectos' => $linha_estrategica->orcamento_gasto_sub_project,
                );
            }
            return response()->json([
                'dataTable' => $this->dataTable,
                'years' => $years,
                'dataGraph' => [
                    'data' => $dataGraph ?? [],
                    'dataGraph_x' => 'Projeto',
                    'dataGraph_x_value' => [
                        'Orçamento LE',
                        'Orçamento de Projectos',
                        'Orçamento de Gasto de Projectos'
                    ]
                ],
            ]);
        }

        if ($request->type == 'projects') {

            $this->dataTable->filter(function ($project) {
                return $project['childs'] = $project->childs->filter(function ($child) {
                    $child['orcamento_inicial'] = number_format(($child->orcamento()->get()->sum("orcamento_inicial")), 2);
                    $child['orcamento_gasto'] = number_format(($child->orcamento()->get()->sum("orcamento_gasto")), 2);
                    return $child;
                });
            });

            return response()->json([
                'dataTable' => $this->dataTable,
                'dataGraph' => [
                    'data' => $this->process_data_to_graph($this->dataTable),
                    'dataGraph_x' => 'Projeto',
                    'dataGraph_x_value' => [
                        'Orçamento Inicial',
                        'Valor Gasto',
                    ]
                ]
            ]);
        }
    }

    /**
     * Process data to grath
     */
    public function process_data_to_graph($data)
    {
        $array = [];
        foreach ($data as $key => $value) {
            if (isset($value->childs)) {
                foreach ($value->childs as $child) {
                    $array[] = array(
                        'Projeto' => $child->name,
                        'Orçamento Inicial' => $child->orcamento()->get()->sum('orcamento_inicial'),
                        'Valor Gasto' => $child->orcamento()->get()->sum('orcamento_gasto')
                    );
                }
            }
        }

        return $this->data_graph = $array;
    }

    /**
     * Exportar Relatorio
     */
    public function exportOrcamentoPDEToExcel(Projects $project, Request $request)
    {

        $dataType = "undefined";
        if ($request->type == "linha-estrategica") {
            $dataType = "Linha Estratégica";

            $title = "Relatorio de Orçamento de Projetos";
            $application =  AppBoot::application();
            $reportData = $this->report_financeiro_pde_api($project, $request);
            $reportData = $reportData->original['dataGraph']['data'];

            $export = new ExportReports($title, $application, $reportData, $dataType);
            $file_name = time() . "Relatorio-Orcamento";
            return Excel::download($export, $file_name . '.xlsx');
        } else {
            $dataType = "Projectos";
            return back();
        }


        // return Excel::download($export, 'relatorio_orcamento_plano_estrategico.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        // return view('report_files.exports.export_orcamento_pde', compact('title', 'application', 'reportData', 'dataType'));
    }



    /**
     * Report Actividade
     *
     * return api data
     */
    public function report_atividades_pde_api(Projects $project_identifier)
    {

        $project = $project_identifier;




        $reportsData = DB::select('SELECT issues.id, issues.subject, objectivo_epecifico.subject as objectivo_epecifico, indicador_values.*,
            indicador.name as indicador FROM issues
            inner join trackers on issues.tracker_id = trackers.id
            -- left join issues as estrategia on (issues.parent_id = estrategia.id and estrategia.tracker_id = 8 )
            left join issues as objectivo_epecifico on (issues.parent_id = objectivo_epecifico.id and objectivo_epecifico.tracker_id = 8 )
            left join indicator_values as indicador_values on (issues.id = indicador_values.customized_id and indicator_type = "Issue")
            left join indicator_fields as indicador on (indicador.id = indicador_values.indicator_field_id)
            WHERE issues.tracker_id = 14 and issues.project_id = ' . $project->id . '');

        // return $reportsData;

        // $reportsData = Issues::where('project_id', $project->id)
        //     ->with('tracker')
        //     ->with('childs')
        //     ->with('custom_values')
        //     ->with('custom_values.custom_field')
        //     ->where('issues.tracker_id', 3)
        //     ->get();


        $data = array();

        foreach ($reportsData as $report) {
            $data[] = array(
                'objectivo_epecifico' => $report->objectivo_epecifico,
                'estrategica' => null, //$report->subject,
                'actividade' => $report->subject,
                'project_rel' => null, //$report->subject,
                'indicador' => $report->indicador,
                'meta' => $report->meta,
                'meta_type' => $report->meta_type,
                'realizado' => $report->subject,
                'percent' => 0,
                'fonte_ver' => $report->fonte_ver,
            );
        }



        return $data;
        return $reportsData;



        return response()->json([
            'objectivo_epecifico' => 19,
            'estrategica' => 19,
            'actividade' => 19,
            'project_rel' => 19,
            'indicador' => 19,
            'meta' => 19,
            'realizado' => 19,
            'percent' => 19,
            'fonte_ver' => 19,
        ]);
    }
}
