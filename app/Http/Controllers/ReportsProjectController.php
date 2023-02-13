<?php

namespace App\Http\Controllers;

use App\Models\Issues;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Http\Controllers\Helpers\Reports\ReportBudgetPDEHelper;
use App\Http\Controllers\Helpers\Reports\ReportsIssueApprovement;
use App\Http\Controllers\Helpers\Reports\ReportAtividadeProvincia;
use App\Http\Controllers\Helpers\Reports\ReportOrcamentoProjectos;
use App\Http\Controllers\Helpers\Reports\ReportGeneralIssues;

class ReportsProjectController extends Controller
{

    use ReportAtividadeProvincia, ReportBudgetPDEHelper, ReportsIssueApprovement, ReportOrcamentoProjectos,ReportGeneralIssues;

    public $dataTable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = 'dataOrcamentoProjects';
        $programs = Projects::where('type', 'Program')->where('status', 1)->get();
        return view('reports.index', compact('active', 'programs'));
    }


    /**
     * Return View Orçamento de project
     */
    public function report_financeiro_project()
    {
        $active = 'RFP';
        $projects = \App\Models\Projects::where('type', "Project")->where('status', 1)->orderBy('name', 'asc')->get();
        return view('reports.budget_project', compact('active', 'projects'));
    }


    /**
     * Return View - Atividaes por Provincias
     */
    public function report_actividades_provincia()
    {
        $active = "actividades_provincia";
        $issues = Issues::with('provincia', 'indicators', 'project')->whereHas('provincia')->whereHas('project')->get();

        // dd($issues);
        return view('reports.index', compact('issues', 'active'));
    }

    /**
     * Return View - Atividaes por Provincias
     */
    public function report_beneficiarios_pde()
    {
        $active = "beneficiarios_pde";
        return view('reports.index', compact('active'));
    }

    /**
     * Return View - Atividaes por Provincias
     */
    public function report_beneficiarios_project()
    {
        $active = "beneficiarios_project";
        return view('reports.index', compact('active'));
    }

    /**
     * Return View - Atividaes por Provincias
     */
    public function report_atividades_pde()
    {
        $projects = \App\Models\Projects::where('type', "PDE")->where('status', 1)->orderBy('name', 'asc')->get();
        $active = "actividades_pde";
        return view('reports.index', compact('active', 'projects'));
    }

    /**
     * Return View - Atividaes por Provincias
     */
    public function report_atividades_project()
    {
        $projects = \App\Models\Projects::where('type', "Project")->where('status', 1)->orderBy('name', 'asc')->get();
        $active = "actividades_project";
        return view('reports.index', compact('active', 'projects'));
    }

    /**
     * Return View relatorio Financeiro PDE
     */
    public function report_financeiro_pde()
    {
        $active = 'RFPDE';
        // $route_api = route('endpoint_reports');

        $projects = \App\Models\Projects::where('type', "PDE")->where('status', 1)->orderBy('name', 'asc')->get();

        return view('reports.index', compact('active', 'projects'));
    }

    /**
     * Return view - Actividades ApprovementFlow
     */
    public function report_atividades_approvement_flow()
    {
        $active = 'RFIssueApprovement';
        $projects = \App\Models\Projects::where('type', "Program")->where('status', 1)->orderBy('name', 'asc')->get();
        return view('reports.index', compact('active', 'projects'));
    }

     /**
     * Return view - Actividades Solicitacao de Fundos
     */
    public function report_atividades_solicitacao()
    {
        $active = 'IssueApprovement';
        $projects = \App\Models\Projects::where('type', "Program")->where('status', 1)->orderBy('name', 'asc')->get();
        return view('reports.index', compact('active', 'projects'));
    }

    /**
     * Rerurn view Data Report Orcamento PDE
     */
    public function report_data_orcamento_pde()
    {
        $active = "dataOrcamentoPDE";
        $projects = Projects::where('type', 'PDE')->get();
        return view('reports.index', compact('active', 'projects'));
    }

    /**
     * Return View Data Report Orcamento Projecto
     */
    public function report_data_orcamento_projects()
    {
        $active = "dataOrcamentoProjects";
        return view('reports.index', compact('active'));
    }


    public function report_execucao_orcamental()
    {
        $active = "dataExecucaoOrcamental";

        $projects = \App\Models\Projects::select('id', 'name', 'identifier', 'type', 'start_date', 'due_date')->where('type', "Project")->where('status', 1)->orderBy('name', 'asc')->get();

        $reportData = \collect([
            'projects' => $projects,
            'total_orcamento_inicial' => $projects->sum('orcamento_inicial'),
            'total_orcamento_gasto' => $projects->sum('orcamento_gasto'),
        ]);


        return view('reports.index', compact('active', 'reportData'));
    }

    public function report_previsao_orcamental()
    {
        $active = "dataPrevOrcamental";

        $projects = Projects::where('status', 1)->where('parent_id', '!=', null)->where('type', "Project")->get();
        $planosEstrategicos = Projects::where('status', 1)->where('parent_id', null)->where('type', "PDE")->get();


        foreach ($projects as $project) {
            $project->issues_valor_prev = $project->orcamento_prev_tarefa(2021);
        }

        $reportData = \collect([
            "projects" => $projects,
            "planosEstrategicos" => $planosEstrategicos,
            'total_orcamento_inicial' => $projects->sum('orcamento_inicial'),

        ]);

        return view('reports.index', compact('active', 'reportData'));
    }


    /**
     * Show general report
     */
    public function general_issues_report()
    {
        $active = "generalIssuesReport";
        $reportData = \collect([]);
        $projects = Projects::where('status', 1)->where('parent_id', null)->where('type', "PDE")->get();
        return view('reports.index', compact('active', 'reportData', 'projects'));
    }

    /**
     * Show general report project
     */
    public function general_issues_report_project()
    {
        $active = "generalIssuesReportProject";
        $reportData = \collect([]);
        $projects = Projects::where('status', 1)->where('parent_id', null)->where('type', "PDE")->get();
        return view('reports.index', compact('active', 'reportData', 'projects'));
    }

    /**
     * Show general report project
     */
    public function general_indicators_report()
    {
        $active = "generalIndicatorsReport";
        $reportData = \collect([]);
        $projects = Projects::where('status', 1)->where('parent_id', null)->where('type', "PDE")->get();
        return view('reports.index', compact('active', 'reportData', 'projects'));
    }


    public function report_budget_project_api($project_identifier)
    {
        return $this->report_financeiro_project_api($project_identifier);
    }



    public function apiGeneralReportProject(Projects $project, Request $request)
    {

        $repsonse = \collect([]);
        //dd($project);

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
        return $repsonse;
    }

    public function apiGeneralReportIndicators(Projects $project, Request $request)
    {

        $repsonse = \collect([]);
        //dd($project);

        foreach ($project->issues()->where('tracker_id', 14)->whereHas('indicators')->with('assignedTo')->get() as $key => $issue) {

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
        return $repsonse;
    }

    public function apiGeneralReports(Projects $project, Request $request)
    {

        $repsonse = \collect([]);
        //dd($project);

        foreach ($project->childs as $childProject) {
            //dd($childProject);

            foreach ($childProject->issues()->where('tracker_id', 14)->get() as $key => $issue) {

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
        }
        return $repsonse;
    }

    public function apiGeneralReportsProject($project)
    {

        $data = Projects::where('identifier', $project)->first();
        $programs = Projects::where('parent_id', $data->id)->get();
        return $programs;
    }
}
