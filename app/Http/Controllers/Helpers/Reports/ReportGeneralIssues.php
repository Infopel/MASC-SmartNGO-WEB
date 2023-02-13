<?php

namespace App\Http\Controllers\Helpers\Reports;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Macro\AppBoot;
use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Exports\ExportGeneral;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

trait ReportGeneralIssues
{



    public function apiGeneralRep(Projects $project, Request $request)
    {

        $repsonse = \collect([]);

        foreach ($project->childs as $childProject) {

            foreach ($childProject->issues()->where('tracker_id', 14)->get() as $key => $issue) {

                $dataGraph[] = \collect([
                    "num_ordem" => ++$key,
                    "result" => $issue->parent,
                    "issue_id" => $issue->id,
                    "issue" => $issue,
                    "issue_type" => $issue->tracker->name,
                    "indicadores" =>  $issue->indicators,
                    "meta_anual" => 0,
                    "meta_trim" => [
                        "_I" => 0,
                        "_II" => 0,
                        "_III" => 0,
                        "_IV" => 0,
                    ],
                    "meta_realizada" => 0,
                    "grao_realizacao" => 0,
                    "local_realizacao" => $issue->provincia()->first()->value ?? 'undefined',
                    "beneficiarios" => [
                        "_homens" => [
                            'meta' => $issue->beneficiarios()->where('type', 'homens')->sum('meta'),
                            'realizado' => $issue->beneficiarios()->where('type', 'homens')->sum('realizado'),
                        ],
                        "_mulheres" =>  [
                            'meta' => $issue->beneficiarios()->where('type', 'mulheres')->sum('meta'),
                            'realizado' => $issue->beneficiarios()->where('type', 'mulheres')->sum('realizado'),
                        ],
                        "_total" => [
                            "meta" => $issue->beneficiarios()->sum('meta'),
                            "realizado" => $issue->beneficiarios()->sum('realizado'),
                        ]
                    ],
                    "orcamento" => 0,
                    "orcamento_exec" => 0,
                    "project" => $issue->project
                ]);
            }
        }


        return response()->json([
            'dataTable' => $this->dataTable,
            //'years' => $years,
            'dataGraph' => [
                'data' => $dataGraph ?? [],
                'dataGraph_x' => 'Actividade',
                'dataGraph_x_value' => [
                    'indicadores',
                    'Meta Anual',
                    '1 Trimestre',
                    '2 Trimestre',
                    '3 Trimestre',
                    '4 Trimestre',
                    'Meta Realizada',
                    'Local de Realizacao'
                ]
            ],
        ]);

      return $repsonse;
    }

    public function apiGeneralRepProject(Projects $project, Request $request)
    {

        $repsonse = \collect([]);

        foreach ($project->issues()->where('tracker_id', 14)->get() as $key => $issue) {

            $repsonse[] = \collect([
                "num_ordem" => ++$key,
                "result" => $issue->parent,
                "issue_id" => $issue->id,
                "issue" => $issue,
                "issue_type" => $issue->tracker->name,
                "indicadores" =>  $issue->indicators,
                "meta_anual" => 0,
                "meta_trim" => [
                    "_I" => 0,
                    "_II" => 0,
                    "_III" => 0,
                    "_IV" => 0,
                ],
                "meta_realizada" => 0,
                "grao_realizacao" => 0,
                "local_realizacao" => $issue->provincia()->first()->value ?? 'undefined',
                "beneficiarios" => [
                    "_homens" => [
                        'meta' => $issue->beneficiarios()->where('type', 'homens')->sum('meta'),
                        'realizado' => $issue->beneficiarios()->where('type', 'homens')->sum('realizado'),
                    ],
                    "_mulheres" =>  [
                        'meta' => $issue->beneficiarios()->where('type', 'mulheres')->sum('meta'),
                        'realizado' => $issue->beneficiarios()->where('type', 'mulheres')->sum('realizado'),
                    ],
                    "_total" => [
                        "meta" => $issue->beneficiarios()->sum('meta'),
                        "realizado" => $issue->beneficiarios()->sum('realizado'),
                    ]
                ],
                "orcamento" => 0,
                "orcamento_exec" => 0,
                "project" => $issue->project
            ]);
        }


        return response()->json([
            'dataTable' => $this->dataTable,
            //'years' => $years,
            'dataGraph' => [
                'data' => $dataGraph ?? [],
                'dataGraph_x' => 'Actividade',
                'dataGraph_x_value' => [
                    'indicadores',
                    'Meta Anual',
                    '1 Trimestre',
                    '2 Trimestre',
                    '3 Trimestre',
                    '4 Trimestre',
                    'Meta Realizada',
                    'Local de Realizacao'
                ]
            ],
        ]);

      return $repsonse;
    }

    public function exportGeneralIssuesReportExcel(Projects $project, Request $request)
    {

        $dataType = "Linha Estratégica";

        $title = "Relatorio de Orçamento de Projetos";
        $application =  AppBoot::application();
        $reportData = $this->apiGeneralRep($project, $request);
        $reportData = $reportData->original['dataGraph']['data'];
        $export = new ExportGeneral($title, $application,$reportData , $dataType);
        $file_name = time() . "Balanco de Realizacao";
        return Excel::download($export, $file_name . '.xlsx');

    }

    public function exportGeneralIssuesReportProjectExcel(Projects $project, Request $request)
    {

        $dataType = "Linha Estratégica";

        $title = "Relatorio de Orçamento de Projetos";
        $application =  AppBoot::application();
        $reportData = $this->apiGeneralRepProject($project, $request);
        $reportData = $reportData->original['dataGraph']['data'];
        $export = new ExportGeneral($title, $application,$reportData , $dataType);
        $file_name = time() . "Balanco de Realizacao";
        return Excel::download($export, $file_name . '.xlsx');

    }

}
