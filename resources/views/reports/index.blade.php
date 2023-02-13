@extends('layouts.main')
@section('content')
    <div class="mb-4">
        <div class="col-md-12 mb-4">
            <div class="row py-4" style="min-height:80vh">
                <div class="col-md-12">
                    <div class="d-flex">
                        @include('layouts._menu_reports')
                        <div class="flex-grow-1 col-md m-0 p-0">
                            @switch($active)
                                @case("beneficiarios_pde")
                                    <beneficiarios-pde/>
                                    @break
                                @case("beneficiarios_project")
                                    <beneficiarios-project/>
                                    @break
                                @case("actividades_provincia")
                                    <atividade-provincia
                                        :issues="{{ $issues }}"
                                    />
                                    @break
                                @case("actividades_pde")
                                    <actividades-pde
                                        :projects="{{ $projects }}"
                                    />
                                    @break
                                @case("actividades_project")
                                    <actividades-project
                                        :projects_pde="{{ $projectsPDE }}"
                                    />
                                    @break
                                @case('RFIssueApprovement')
                                    <actividade-approvements :projects_pde="{{ $projects }}"/>
                                    @break;
                                @case('dataOrcamentoPDE')
                                    <data-orcamento-pde :projects="{{ $projects }}"/>
                                    @break;
                                @case('dataOrcamentoProjects')
                                    <data-orcamento-projects :programs="{{ $programs }}"/>
                                    @break;
                                @case('dataExecucaoOrcamental')
                                    <execucao-orcamental :report-data="{{ $reportData }}"/>
                                    @break;
                                @case('dataPrevOrcamental')
                                    <previsao-orcamental :report-data="{{ $reportData }}"/>
                                    @break;
                                @case('generalIssuesReport')
                                    <general-issues-report :report-data="{{ $reportData }}" :projects="{{ $projects }}"/>
                                    @break;
                                @case('generalIssuesReportProject')
                                    <general-issues-report-project :report-data="{{ $reportData }}" :projects="{{ $projects }}"/>
                                    @break;
                                @case('generalIndicatorsReport')
                                    <general-indicators-report :report-data="{{ $reportData }}" :projects="{{ $projects }}"/>
                                    @break;
                                @case('IssueApprovement')
                                    <solicitacao-fundos :projects_pde="{{ $projects }}"/>
                                    @break
                                @default
                                    <report-orcamento-pde
                                        :projects="{{ $projects }}"/>
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
