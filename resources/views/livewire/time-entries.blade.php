<div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pl-3 pt-2 pr-3 pr-3 pb-2 rounded" style="min-height:70vh">
                    <div class="mt-0 mb-2">
                        @if (session()->has('success'))
                            <div class="alert alert-success p-2 mb-0">
                                {!! session('success') !!}
                            </div>
                        @elseif(session()->has('warning'))
                            <div class="alert alert-warning p-2 mb-0">
                                {!! session('warning') !!}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger p-2 mb-0">
                                {!! session('error') !!}
                            </div>
                        @endif
                    </div>

                    <div class="header border-bottom">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>
                                    <a href="#">{{ __("lang.label_spent_time") }}</a>
                                    » <span>Relatórios</span>
                                </h5>
                                <h5 class="text-wrap">
                                    Atividade: <a href="{{ $issue['route'] }}">{{ $issue->subject }}</a>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs pb-0 mb-1" id="nav-tab" role="tablist">

                                        <a class="nav-item nav-link link-option active" id="fluxo-aprovacao" data-toggle="tab" href="#nav-fluxo-aprovacao" role="tab" aria-controls="nav-Aprovadas" aria-selected="true">Reporte de Actividade</a>

                                        <a class="nav-item nav-link link-option" id="nav-resumoReportado" data-toggle="tab" href="#resumoReportado" role="tab" aria-controls="resumoReportado" aria-selected="true">Reporte Financeiro</a>

                                    </div>
                                </nav>

                                <div class="tab-content" id="nav-tabContent bg-white">
                                    <div class="tab-pane fade" id="resumoReportado" role="tabpanel" aria-labelledby="nav-resumoReportado">
                                        <div class="pl-2 pr-2 bg-white">

                                            <div class="mb-2 border-bottom pb-2">
                                                
                                                @if (!$issue->time_entries_budgets)
                                                    <a
                                                        class="btn btn-sm btn-light border"
                                                        href="{{ route('time_entries.issues.new', [
                                                            'issue' => $issue->id,
                                                            'reportType' => 'financeiro'
                                                            ]) }}"
                                                        title="Reportar uma nova realização ou o alcancado de um indicador"
                                                    >
                                                        <i class="icon-coins"></i>
                                                        Reportar
                                                    </a>
                                                @elseif($issue->time_entries_report == [])
                                                    @if(!$issue->time_entries_report[0]->is_reported && $issue->time_entries_report[0]->approvements()->count() <= 0)
                                                        <form action="{{ route('time_entries.request.approve', [
                                                            'issue' => $issue['id'],
                                                            'time_entrie' => $issue->time_entries_report
                                                            ]) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-sm btn-success border-bottom rounded-0 shadow-sm">Solicitar aprovação</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>

                                            <div class="row m-0">
                                                <div class="col-md-8">
                                                    <div class="d-flex justify-content-end mb-2">
                                                       {{-- @if($issue->time_entries_budgets && !$issue->time_entries_budgets->is_reported && $issue->time_entries_budgets->approvements()->count() <= 0)
                                                            <div class="mr-2">
                                                                <form action="{{ route('time_entries.request.approve', [
                                                                    'issue' => $issue['id'],
                                                                    'time_entrie' => $issue->time_entries_report,
                                                                    'reportType' => 'budgetReport'
                                                                    ]) }}" method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-sm btn-success rounded my-shadow fw-500">Solicitar aprovação</button>
                                                                </form>
                                                            </div>
                                                        @endif--}}
                                                        @if ($issue->time_entries_budgets && $issue->time_entries_budgets['is_reported'] == 0)
                                                            <div class="">
                                                                <a href="{{ route('time_entries.issues.edit', [
                                                                    'issue' => $issue,
                                                                    'time_entrie' => $issue->time_entries_report->id,
                                                                ]) }}" class="p-1 border btn-light pl-3 pr-3 my-shadow mb-2 link-option rounded">
                                                                    <i class="icon icon-pencil5"></i>
                                                                    Editar
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if ($issue->time_entries_budgets)
                                                        <div class="p-3 bg-light rounded">
                                                            <h5>Resumo / Comentario</h5>
                                                            <p>
                                                                {{ $issue->time_entries_budgets->comments}}
                                                            </p>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Reportado por
                                                                            </div>
                                                                            <div class="">
                                                                                {{ $issue->time_entries_budgets->user->full_name }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Status
                                                                            </div>
                                                                            <div>
                                                                                @if ($issue->time_entries_budgets->is_approved)
                                                                                    <span class="text-blue-800">
                                                                                        Aprovação completa
                                                                                    </span>
                                                                                @else
                                                                                    <span class="text-danger">
                                                                                        Aprovação pendente
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Ultima atulização
                                                                            </div>
                                                                            <div class="">
                                                                                {{ $issue->time_entries_budgets->updated_on }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning p-1 small">
                                                            <i>Nenhum indicador reportado</i>
                                                        </div>
                                                    @endif

                                                    <div class="p-3 pb-4 pt-2">
                                                        <h6 class="fw-600 text-muted">Relatório de despesas realizadas</h6>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-striped table-hover" style="font-size: 90%">
                                                                <thead class="bg-slate">
                                                                    <th class="fw-600">Orçamento</th>
                                                                    <th class="text-nowrap fw-600" title="Valor Total Solicitado">V.T Solicitado</th>
                                                                    <th class="text-nowrap fw-600" title="Valor Total Gasto">V.T Gasto</th>
                                                                    <th>{{ __('lang.field_updated_on') }}</th>
                                                                    <th class="text-center fw-600">%</th>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($issue->time_entries_budgets)
                                                                        @forelse ($issue->time_entries_budgets->time_entries_values as $timeEntriebudget)
                                                                            <tr>
                                                                                <td class="">
                                                                                    {{ $timeEntriebudget->rubrica->rubrica->name }}
                                                                                </td>
                                                                                <td class="text-nowrap">
                                                                                    {{ number_format(($timeEntriebudget->rubrica->issued_value),2) }} MZN
                                                                                </td>
                                                                                <td class="text-nowrap">
                                                                                    {{ number_format(($timeEntriebudget->rubrica->valor_realizado),2) }} MZN
                                                                                </td>
                                                                                <td class="text-nowrap">
                                                                                    {{ \Carbon\Carbon::parse($timeEntriebudget['created_on'])->diffForHumans() }}
                                                                                </td>
                                                                                <td class="text-nowrap">
                                                                                    @if ($timeEntriebudget->rubrica->issued_value > 0)
                                                                                        {{
                                                                                        number_format(($timeEntriebudget->rubrica->valor_realizado / $timeEntriebudget->rubrica->issued_value * 100),2)
                                                                                        }} %
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="6" class="text-center">
                                                                                    {{ __('lang.label_no_data') }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforelse
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">
                                                                                {{ __('lang.label_no_data') }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="p-3 pb-4 border-top mt-4 pt-2">
                                                        <div class="mt-2">
                                                            <h6 class="m-0 fw-600 text-muted mb-2">Comprovativos</h6>
                                                            <div class="table-responsive nowrap">
                                                                <table class="table table-sm table-hover table-striped" style="font-size: 90%">
                                                                    <thead class="table-active">
                                                                        <th>{{ __('lang.label_attachment') }}</th>
                                                                        <th>{{ __('lang.field_filesize') }}</th>
                                                                        <th>{{ __('Report') }}</th>
                                                                        <th>{{ __('lang.label_added_by') }}</th>
                                                                        <th>{{ __('lang.field_created_on') }}</th>
                                                                    </thead>

                                                                    <tbody>
                                                                        @forelse ($issue->attachments_report_orcamento as $attachment)
                                                                            <tr>
                                                                                <td>
                                                                                    <a href="{{ route('attachments.getDocument', ['attachment' => $attachment->id, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                                                                </td>
                                                                                <td>{{ $attachment->filesize }} kb</td>
                                                                                <td>{{ $attachment->container_type == 'IssueReportBudget' ? 'Orçamento' : 'Indicador' }}</td>
                                                                                <td>{{ $attachment->user->full_name }}</td>
                                                                                <td>{{ $attachment->created_on }}</td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="6" class="text-center">
                                                                                    {{ __('lang.label_no_data') }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 border-left">
                                                    <div class="fw-600">
                                                        FLUXO DE APROVAÇÃO
                                                    </div>
                                                    <div class="">
                                                        <div class="aprovacao-nivel-1">
                                                            @if ($issue->time_entries_report == [])
                                                            @foreach ($issue->time_entries_report[0]->approvements()->get() as $itemReport)
                                                                <h6 class="mt-3 p-1 bg-light rounded text-left text-muted fw-500">
                                                                    <i>{{ $itemReport->flow->description }}</i>
                                                                </h6>
                                                                <div class="mb-2 pb-3">
                                                                    <table class="table table-sm borderless border-0 w-auto" style="font-size: 90%;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Aprovado por:</td> <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-capitalize">
                                                                                    {{ $itemReport->approvedBy->full_name ?? null }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Categoria:</td>
                                                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600">
                                                                                    {{ $itemReport->validator_category }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">
                                                                                    Data de Aprovação:
                                                                                </td>
                                                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-muted">
                                                                                    <i>
                                                                                        {{ $itemReport->approved_on }}
                                                                                    </i>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">
                                                                                    Status:
                                                                                </td>
                                                                                @if ($itemReport->is_approved)
                                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-success">
                                                                                        Aprovado e reportado
                                                                                    </td>
                                                                                @else
                                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-danger">
                                                                                       Aprovação pendente
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="">
                                                                        @if ($itemReport->is_approved == false && $itemReport->is_rejected == false && $itemReport->assigned_to == auth()->user()->id)
                                                                            <form action="{{ route('time_entries.request.approve_validation', [
                                                                                'issue' => $issue['id'],
                                                                                'time_entrie' => $issue->time_entries_report,
                                                                                'flowReportTask' => $itemReport->id,
                                                                                ]) }}" method="POST"
                                                                            >
                                                                                @csrf
                                                                                <button type="submit" class="fw-500 mt-3 w-100 btn btn-sm btn-success">
                                                                                    Approvar
                                                                                </button>
                                                                            </form>
                                                                        @elseif($itemReport->is_approved == false)
                                                                            <div class="mt-3 allert alert-warning p-1 pl-2 pr-2 small rounded">
                                                                                Você não tem permissões para aprovar.
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade show active" id="nav-fluxo-aprovacao" role="tabpanel" aria-labelledby="fluxo-aprovacao">
                                        <div class="p-3 bg-white" style="min-height: 62vh">
                                            <div class="mb-2 flex border-bottom pb-2">
                                                {{--@if (!$issue->time_entries_report)--}}
                                                <div class="row">
                                                    <div class="col-sm-0 border-top-0 fw-600">
                                                        <a
                                                            class="btn btn-sm btn-primary "
                                                            href="{{ route('time_entries.issues.new', ['issue' => $issue->id]) }}"
                                                            title="Reportar uma nova realização ou o alcancado de um indicador"
                                                        >
                                                            <i class="icon-add-to-list"></i>
                                                            Reportar
                                                        </a>
                                                    </div>
                                                    <div class="col-sm-2 border-top-0 fw-600">
                                                        @if(sizeof($issue->time_entries_report))
                                                            @if(!$issue->time_entries_report[0]->is_reported && $issue->time_entries_report[0]->approvements()->count() <= 0)
                                                                <form action="{{ route('time_entries.request.approve', [
                                                                    'issue' => $issue['id'],
                                                                    'time_entrie' => $issue->time_entries_report[0],
                                                                    'time_entries' => $issue->time_entries_report
                                                                    ]) }}" method="POST">
                                                                    @csrf
                                                                    <button class="btn btn-sm btn-success border-bottom shadow-sm">Solicitar aprovação</button>
                                                                </form>
                                                            @endif
                                                            
                                                        @endif

                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row m-0">
                                                <div class="col-md-8 pl-1">
                                                    @if($issue->time_entries_report == [])
                                                        @if ($issue->time_entries_report  && $issue->time_entries_report[0]->approvements()->count() < 0)
                                                            <div class="d-flex justify-content-end">
                                                                <a href="{{ route('time_entries.issues.edit', [
                                                                    'issue' => $issue,
                                                                    'time_entrie' => $issue->time_entries_report[0]->id,
                                                                ]) }}" class="p-1 border btn-light pl-3 pr-3 my-shadow mb-2 link-option rounded">
                                                                    <i class="icon icon-pencil5"></i>
                                                                    Editar
                                                                </a>
                                                            </div>
                                                        @endif
                                                        
                                                    @endif
                                                         
                                                    @if (sizeof($issue->time_entries_report))
                                                        <div class="p-3 bg-light rounded">
                                                            <h5>Resumo / Comentario</h5>
                                                            <div class="row">
                                                                <div class="col-sm-10 border-top-0 fw-600">Actividade  :  {{ $issue->subject }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-5 border-top-0 fw-600">Data de Inicio  :  {{ $issue->start_date }}</div>
                                                                <div class="col-sm-5 border-top-0 fw-600">Data de Fim  :  {{ $issue->due_date }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-5 border-top-0 fw-600"> Pronvicia  :  {{ $issue->custom_fields }}</div>
                                                                <div class="col-sm-5 border-top-0 fw-600">Distrito  :  {{ $issue->custom_fields }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-10 border-top-0 fw-600">Estado  :  {{ $issue->is_reported }}</div>
                                                            </div>
                                                            
                                                            {{--<div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Autor
                                                                            </div>
                                                                            <div class="">
                                                                                {{ $issue->time_entries_report->full_name }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Status
                                                                            </div>
                                                                            <div>
                                                                                @if ($issue->time_entries_report->is_approved)
                                                                                    <span class="text-blue-800">
                                                                                        Aprovação completa
                                                                                    </span>
                                                                                @else
                                                                                    <span class="text-danger">
                                                                                        Aprovação pendente
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Ultima atulização
                                                                            </div>
                                                                            <div class="">
                                                                                {{ $issue->time_entries_report->updated_on }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>--}}
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning p-1 small">
                                                            <i>Nenhum indicador reportado</i>
                                                        </div>
                                                    @endif

                                                    @isset($issue->time_entries_report)

                                                        @foreach ( $issue->time_entries_report as $time_entrie)
                                                            <div style="margin: 10px 0">
                                                                <div class="card-header accordion " data-toggle="collapse" data-target="#time{{ $time_entrie->id }}" aria-expanded="false" aria-controls="time{{ $time_entrie->id }}">
                                                                    <i class="fa fa-bars"></i>
                                                                    <i class="icon-list"></i>
                                                                    <a class="btn collapsed" data-bs-toggle="collapse" >
                                                                        
                                                                        {{ $time_entrie->comments }}
                                                                    </a>
                                                                </div>
                                                                <div class="collapse" id="time{{ $time_entrie->id }}" wire:ignore.self>
                                                                    <div class="row">
                                                                        <div class="col-sm-5 ml-2 border-top-0 fw-600">Data de Inicio  :  {{ $time_entrie->start_date }}</div>
                                                                        <div class="col-sm-5 border-top-0 fw-600">Data de Fim  :  {{ $time_entrie->due_date }}</div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-5 ml-2  border-top-0 fw-600">Contribuicoes para MASC  :  {{ $time_entrie->masc_contribuition }}</div>
                                                                        <div class="col-sm-5   border-top-0 fw-600">Descricao da Reunia  :  {{ $time_entrie->metting_descrption }}</div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-5 ml-2  border-top-0 fw-600">Horas Gastas  :  {{ $time_entrie->hours }}</div>
                                                                        
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-sm-5 ml-2  border-top-0 fw-600">Licooes Aprendidas : {{ $time_entrie->challenge_lessons }}</div>
                                                                        
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        @endforeach
                                                       
                                                    @endisset
                                                    
                                                    <div class="">
                                                        @forelse ($issue->indicators()->get() as $indicator)
                                                            <div class="report-container mb-2 border-bottom pb-4 pt-2">
                                                                <div class="mb-2">
                                                                    <div class="fw-500 mb-0 small text-grey" style="margin-bottom: -4px !important;">Nome do Indidcador</div>
                                                                    <div class="">
                                                                        <a href="#">{{ $indicator->indicator_field->name }}</a>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-1">
                                                                    <div class="fw-500 mb-0 small text-grey" style="margin-bottom: -4px !important;">
                                                                        Resultado alcançado
                                                                    </div>
                                                                    <div class="ml-1 mr-1">
                                                                        @if ($issue->time_entries_report)
                                                                            {{
                                                                                $issue->time_entries_report->time_entries_values()->where('customized_id', $indicator->id)->first()->value ?? "Nenhum reportado"
                                                                            }}
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="row m-0 mt-2">
                                                                    <div class="col-md-6 ml-0 pl-0">
                                                                        <div class="mb-1">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Tipo de Meta
                                                                            </div>
                                                                            <div class="">
                                                                                @if ($indicator->indicator_field->indicator_issue_values->meta_type == "decimal")
                                                                                    Numerica
                                                                                @elseif($indicator->indicator_field->indicator_issue_values->meta_type == "text")
                                                                                    Descritiva
                                                                                @elseif($indicator->indicator_field->indicator_issue_values->meta_type == "percent")
                                                                                    Percentual
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="">
                                                                            <div
                                                                                class="fw-500 mb-0 small text-grey"
                                                                                style="margin-bottom: -4px !important;"
                                                                            >
                                                                                Meta
                                                                            </div>
                                                                            <div class="">
                                                                                {{ $indicator->indicator_field->indicator_issue_values->meta }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            {{-- "Nenhum Indicador cadastrado" --}}
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <div class="col-md-4 border-left">
                                                    <div class="fw-600">
                                                        FLUXO DE APROVAÇÃO
                                                    </div>
                                                    <div class="">
                                                        <div class="aprovacao-nivel-1">
                                                            @if ($issue->time_entries_report == [])
                                                            @foreach ($issue->time_entries_report[0]->approvements()->get() as $itemReport)
                                                                <h6 class="mt-3 p-1 bg-light rounded text-left text-muted fw-500">
                                                                    <i>{{ $itemReport->flow->description }}</i>
                                                                </h6>
                                                                <div class="mb-2 pb-3">
                                                                    <table class="table table-sm borderless border-0 w-auto" style="font-size: 90%;">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Aprovado por:</td> <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-capitalize">
                                                                                    {{ $itemReport->approvedBy->full_name ?? null }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Categoria:</td>
                                                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600">
                                                                                    {{ $itemReport->validator_category }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">
                                                                                    Data de Aprovação:
                                                                                </td>
                                                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-muted">
                                                                                    <i>
                                                                                        {{ $itemReport->approved_on }}
                                                                                    </i>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">
                                                                                    Status:
                                                                                </td>
                                                                                @if ($itemReport->is_approved)
                                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-success">
                                                                                        Aprovado e reportado
                                                                                    </td>
                                                                                @else
                                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-danger">
                                                                                       Aprovação pendente
                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    {{--&& $itemReport->assigned_to == auth()->user()->id)--}}
                                                                    <div class="">
                                                                        @if ($issue->time_entries_report == [])
                                                                            @if ($itemReport->is_approved == false && $itemReport->is_rejected == false && $itemReport->assigned_to == auth()->user()->id) 
                                                                                <form action="{{ route('time_entries.request.approve_validation', [
                                                                                    'issue' => $issue['id'],
                                                                                    'time_entrie' => $issue->time_entries_report[0],
                                                                                    'flowReportTask' => $itemReport->id,
                                                                                    ]) }}" method="POST"
                                                                                >
                                                                                    @csrf
                                                                                    <button type="submit" class="fw-500 mt-3 w-100 btn btn-sm btn-success">
                                                                                        Approvar
                                                                                    </button>
                                                                                </form>
                                                                            @elseif($itemReport->is_approved == false)
                                                                                <div class="mt-3 allert alert-warning p-1 pl-2 pr-2 small rounded">
                                                                                    Você não tem permissões para aprovar.
                                                                                </div>
                                                                            @endif
                                                                            
                                                                        @endif
                                                                        
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
