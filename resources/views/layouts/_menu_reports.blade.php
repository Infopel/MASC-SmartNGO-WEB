<div class="menu_reports">
    <ul class="list-unstyled -sidebar bg-white border h-100 mr-3 p-2 pt-3">
        <li class="link-menu mb-1">
            <a
                href="{{ route('reports.orcamento_pde') }}"
                class="pl-2 pr-2 {{ $active == 'RFPDE' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-stats-bars2 text-muted mr-2" style="font-size: 95%"></i>
                Orçamento PDE
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.orcamento_project') }}"
                class="pl-2 pr-2 {{ $active == 'RFP' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-stats-bars2 text-muted mr-2" style="font-size: 95%"></i>
                Orçamento de Projectos
            </a>
        </li>
        {{-- <li class="link-menu mb-1">
            <a href="{{ route('reports.beneficiarios_pde') }}"
                class="pl-2 pr-2 {{ $active == 'beneficiarios_pde' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-stats-bars2 text-muted mr-2" style="font-size: 95%"></i>
                Beneficiários PDE
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.beneficiarios_project') }}"
                class="pl-2 pr-2 {{ $active == 'beneficiarios_project' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-stats-dots text-muted mr-2" style="font-size: 95%"></i>
                Beneficiários Projectos
            </a>
        </li> --}}
        <li class="link-menu mb-1">
            <a href="{{ route('reports.atividades_approvement_flow') }}"
                class="pl-2 pr-2 {{ $active == 'RFIssueApprovement' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-chart text-muted mr-2" style="font-size: 95%"></i>
                Actividades vs Sol.Fundos
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.atividades_provincia') }}"
                class="pl-2 pr-2 {{ $active == 'actividades_provincia' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Actividades Por Província
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.atividades_pde') }}"
                class="pl-2 pr-2 {{ $active == 'actividades_pde' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Actividades PDE
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.actividades_project') }}"
                class="pl-2 pr-2 {{ $active == 'actividades_project' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Actividades Por Projecto
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.data_orcamento_pde') }}"
                class="pl-2 pr-2 {{ $active == 'dataOrcamentoPDE' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Rel. Orçamento PDE
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.data_orcamento_project') }}"
                class="pl-2 pr-2 {{ $active == 'dataOrcamentoProjects' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Rel. Orçamento Projectos
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.execucao_orcamental') }}"
                class="pl-2 pr-2 {{ $active == 'dataExecucaoOrcamental' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Rel. Execução Orçamental
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.prev_orcamental') }}"
                class="pl-2 pr-2 {{ $active == 'dataPrevOrcamental' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Rel. Previsão Orçamental
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.general_issues_report') }}"
                class="pl-2 pr-2 {{ $active == 'generalIssuesReport' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Balanço de realização
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.general_issues_report_project') }}"
                class="pl-2 pr-2 {{ $active == 'generalIssuesReportProject' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Balanço de realização Por Projecto
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.general_indicators_report') }}"
                class="pl-2 pr-2 {{ $active == 'generalIndicatorsReport' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-file-presentation text-muted mr-2" style="font-size: 95%"></i>
                Balanço de realização de Indicadores
            </a>
        </li>
        <li class="link-menu mb-1">
            <a href="{{ route('reports.atividades_solicitacao') }}"
                class="pl-2 pr-2 {{ $active == 'IssueApprovement' ? 'active-option ' : null }} dropdown-item rounded">
                <i class="icon-chart text-muted mr-2" style="font-size: 95%"></i>
                Relatorio de Sol.Fundos
            </a>
        </li>
    </ul>
</div>
