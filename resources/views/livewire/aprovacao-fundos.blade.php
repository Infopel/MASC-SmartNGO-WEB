<div class="row m-0 p-2">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 bg-white p-3" style="min-height: 70vh">
                <div class="mt-2 mb-2">
                        @include('errors.any')
                </div>
                <div class="d-flex mb-2">
                    <div class="flex-grow-1">
                        <h5 class="m-0 fw-600">
                            {{ __('Solicitação de Fundos - Aprovação') }}
                        </h5>
                    </div>
                    <div class="">

                    </div>
                </div>
                <hr class="mt-0 mb-3">

                <div class="row">
                    <div class="col-md-7">
                        <div class="aprovacao-nivel-1">
                            <table class="table table-sm borderless border-0">
                                <tbody>
                                    <tr>
                                        <td class="border-right border-top-0 fw-600">Tarefa</td>
                                        <td class="border-top-0">
                                            {{ $issue->subject }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-right border-top-0 fw-600">Autor:</td>
                                        <td class="border-top-0">
                                            <a href="{{ route('users.show', ['user' => $issue->author->id]) }}">
                                                {{ $issue->author->full_name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-right border-top-0 fw-600">Data:</td>
                                        <td class="border-top-0 text-muted">
                                            <i>{{ $issue->created_on }}</i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="border-top-0 text-muted">
                                            <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">
                                                Click aqui para ver detalhes da tarefa <i class="icon-arrow-right5"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <h6 class="mt-2 p-1 bg-light rounded text-left text-muted fw-500">
                                <i>Orçamento da Tarefa</i>
                            </h6>

                            <div class="table-responsive">
                                <table class="table table-sm table-hover" style="font-size: 95%">
                                    <thead class="table-actives">
                                        <th class="fw-600 border-right border-top-0" title="Rubrica">Rubrica</th>
                                        <th class="fw-600 border-right border-top-0" title="Nome da Rubrica">Rubrica - Nome</th>
                                        <th class="fw-600 border-top-0" title="orçamento por Rubrica">Orçamento</th>
                                        <th></th>
                                    </thead>

                                    <tbody>
                                        @foreach ($issue->orcamento as $item)
                                            <tr>
                                                {{-- {{ dd($item->rubrica) }} --}}
                                                <td class="p-0 pl-2 pr-2  cursor-pointer text-right fw-600">
                                                    {{ $item->rubrica->rubrica }}.
                                                </td>
                                                <td class="p-0 pl-2 pr-2 cursor-pointer">
                                                    {{ $item->rubrica->name}}
                                                </td>
                                                <td class="p-0 pl-2 pr-2 cursor-pointer text-nowrap text-right">
                                                    {{ number_format(($item->issued_value),2) }} MZN
                                                </td>
                                                <td>
                                                    <a href="#" onclick="return false" wire:click="getCabimentoOrcamental({{ $item->rubrica->id }})">
                                                        <i class="icon-coins"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="text-right border-right text-nowrap fw-600">Orçamento Total</td>
                                                <td class="p-0 pl-2 pr-2 cursor-pointer text-nowrap text-right fw-600">
                                                    {{ number_format(($issue->orcamento->sum('issued_value')),2) }} MZN
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-sm table-hover table-striped" style="font-size: 95%">
                                    <thead class="table-actives">
                                        <th class="fw-600 border-right border-top-0" title="Rubrica">
                                            Rubrica
                                        </th>
                                        <th class="fw-600 border-right border-top-0" title="Orçamento disponivel antes da aprovação">
                                            Orc. Disp Antes da aprovação
                                        </th>
                                        <th class="fw-600 border-right border-top-0" title="Orçamento disponivel depois da aprovação">
                                            Orc. Disp Depois da aprovação
                                        </th>
                                        <th class="fw-600 border-top-0" title="Percentual de excucao">%</th>
                                    </thead>

                                    <tbody>
                                        @foreach ($issue->orcamento as $item)
                                            <tr>
                                                <td class="p-0 pl-2 pr-2 border-right cursor-pointer">
                                                    {{ $item->rubrica->rubrica}} {{ $item->rubrica->name}}
                                                </td>
                                                <td class="p-0 pl-2 pr-2 border-right text-right cursor-pointer">
                                                    {{ number_format(($item->rubrica->orcamento),2) }} MZN
                                                </td>
                                                <td class="p-0 pl-2 pr-2 border-right text-right cursor-pointer">
                                                    {{ number_format(($item->issued_value),2) }} MZN
                                                </td>
                                                <td class="p-0 pl-2 pr-2 cursor-pointer text-nowrap text-right">
                                                    @if ($item->rubrica->orcamento != 0)
                                                        {{ number_format((($item->issued_value / $item->rubrica->orcamento) * 100),2) }} %
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="border-top mt-4 mb-4 pt-2">
                                <div class="mt-2">
                                    <h6 class="m-0 fw-600 text-muted alert-warning border p-2">Documentos de suporte do Orçamento Solicitado</h6>
                                    <div class="table-responsive nowrap">
                                        <table class="table table-sm table-hover border" style="font-size: 92%">
                                            <thead class="table-active border">
                                                <th>{{ __('lang.label_attachment') }}</th>
                                                <th>{{ __('lang.field_filesize') }}</th>
                                                <th>{{ __('lang.field_downloads') }}</th>
                                                <th>{{ __('lang.label_added_by') }}</th>
                                                <th>{{ __('lang.field_created_on') }}</th>
                                            </thead>

                                            <tbody>
                                                @forelse ($issue->budget_suport_attachments as $attachment)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('attachments.getDocument', ['attachment' => $attachment->id, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                                        </td>
                                                        <td>{{ $attachment->filesize }} kb</td>
                                                        <td>{{ $attachment->downloads }}</td>
                                                        <td>{{ $attachment->user->full_name }}</td>
                                                        <td>{{ $attachment->created_on }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center bg-light">
                                                            {{ 'Nenhum arquivo adicionado' }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <h5>Fluxo de Aprovação</h5>
                        </div>
                        @foreach ($issue->issue_approvement_requests as $index => $flow_step)
                            @if ($flow_step->approvement_flow->trigger !== 'Report')
                                <div class="aprovacao-nivel-{{ ++$index }}">
                                    <h6 class="mt-3 p-1 bg-light rounded text-left text-muted fw-500">
                                        <i>{{ $flow_step->approvement_flow->description }}</i>
                                    </h6>
                                    @if ($flow_step->is_approved)
                                        <div class="">
                                            <table class="table table-sm borderless border-0 w-auto" style="font-size: 90%">
                                                <tbody>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Autor:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-capitalize">
                                                            {{ $flow_step->approvedBy->full_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Categoria:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-600">
                                                            {{ $flow_step->role->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Data de Aprovação:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-muted">
                                                            <i>{{ $flow_step->approved_on }}</i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Status:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-success">
                                                            Aprovado e reportado
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @elseif(!$flow_step->is_rejected)
                                        @can('can_approve_flow', [App\Models\Issues::class, $issue, $flow_step->approvement_flow->role])
                                            <div class="mt-2">
                                                <form action="{{ route('orcamento.projecto.solicitacao.validation', [
                                                        'project_identifier' => $project['identifier'],
                                                        'issue' => $issue['id'],
                                                        'approvement' => $flow_step->id
                                                        ])
                                                    }}" method="POST">
                                                    @csrf
                                                    <div class="text-right">
                                                        <button type="button" class="btn btn-s pt-1 pb-1 btn-light border"
                                                            wire:click="showModal({{ $flow_step->id }}, '{{ $flow_step->approvement_flow->description }}')">
                                                            Reprovar
                                                        </button>
                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar">Aprovar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-center text-warning">
                                                <small>{{ 'Não tem permissão para fazer essa aprovação! - Apenas Visualização' }}</small>
                                            </div>
                                        @endcan
                                    @endif

                                    @if($flow_step->is_rejected)
                                        <div class="mt-2 mb-2">
                                            <div class="text-center text-danger border border-danger fw-600 rounded">
                                                <span>{{ 'Solicitação reporvada' }}</span>
                                            </div>

                                            <div class="mt-3 mb-3">

                                                <small class="fw-600 text-danger">Reprovações ({{ $flow_step->issue_disapprovals_flow->count() }})</small>

                                                @foreach ($flow_step->issue_disapprovals_flow as $item)
                                                    <div class="table-responsive border-bottom mb-2 pb-2">
                                                        <table class="table table-sm borderless border-0 w-auto" style="font-size: 90%">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600 text-nowrap">Reprovado Por:</td>
                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600">{{ $item->author->full_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Categoria:</td>
                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600">{{ $item->categoria }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Data de reprovação:</td>
                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-muted"><i>{{ $item->created_on }}</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Status:</td>
                                                                    <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-danger">Reprovado</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Motivo:</td>
                                                                    <td class="p-0 pl-2 pr-2 border-top-0 text-muted"><i>{!! $item->notes !!}</i></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>

                                            @can('can_request_approval', [App\Models\Issues::class, $issue])
                                                <form action="{{ route('orcamento.projecto.solicitacao.re_validation', [
                                                    'project_identifier' => $project['identifier'],
                                                    'issue' => $issue['id'],
                                                    'approvement' => $flow_step->id
                                                    ]) }}" method="POST">
                                                    @csrf
                                                    <div class="text-right mt-2">
                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-light border">
                                                            Requisição de aprovação
                                                        </button>
                                                    </div>
                                                </form>
                                            @endcan
                                        </div>
                                    @endif
                                </div>
                                @if ($flow_step->is_rejected)
                                    @break
                                @endif
                            @endif
                        @endforeach

                        @if ($issue->report_indicadores_realizado->count() > 0 || $issue->report_orcamento_realizado->count() > 0)
                            <div>
                                <hr class="mt-4">
                                <h6 class="mt-2 fw-600">Realizado das tarefas</h6>
                                <h6 class="mt-2 p-1 bg-light rounded text-left text-muted fw-500">
                                    <i> Validação Programatica do Reporte</i>
                                </h6>
                                <div class="border-0 mb-2 pb-2">
                                    <h6 class="m-0 fw-600">Indicadores</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm border table-hover" style="font-size: 90%">
                                            <thead class="table-active">
                                                <th class="fw-600">Indicador</th>
                                                <th class="fw-600 text-center">Meta</th>
                                                <th class="fw-600 text-center">Tipo de Meta</th>
                                                <th class="fw-600 text-center">Realizado</th>
                                                <th class="fw-600 text-center">Aprovado</th>
                                            </thead>
                                            <tbody class="table-bordered">
                                                @forelse ($issue->report_indicadores_realizado as $report)
                                                    <tr>
                                                        <td>{{ $report->indicador->indicator_field->name }}</td>
                                                        <td>{{ $report->indicador->indicator_field->indicator_issue_values->meta }}</td>
                                                        <td  class="text-center">
                                                            @if ($report->indicador->indicator_field->indicator_issue_values->meta_type == "decimal")
                                                                Numerica
                                                            @elseif($report->indicador->indicator_field->indicator_issue_values->meta_type == "text")
                                                                Descritiva
                                                            @elseif($report->indicador->indicator_field->indicator_issue_values->meta_type == "percent")
                                                                Percentual
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($report->indicador->indicator_field->indicator_issue_values->is_cumulative)
                                                                {{ $report->indicador->indicator_field->indicator_issue_values->sum('value') }}
                                                            @endif
                                                            @foreach ($report->indicador->indicator_field->indicator_issue_values->time_entries_values as $item)
                                                                <li>
                                                                    {{ $item->value }}
                                                                </li>
                                                            @endforeach
                                                        </td>
                                                        <td class="p-0 pl-2 pr-2 text-center cursor-pointer">
                                                            @if ($report->is_approved)
                                                                <i class="icon-checkmark-circle text-success"></i>
                                                            @else
                                                                <i class="icon-cancel-circle2 text-danger"></i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            {{ "Nenhum Indicador com realizado reportado" }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if ($issue->report_indicadores_realizado()->where('is_approved', false)->count() > 0)
                                        @can('aprovar_realizado_programatico', [App\Models\Issues::class, $issue, 3])
                                            <div class="mt-2">
                                                <form action="{{ route('time_entries.request.approve_validation', ['issue' => $issue['id'], 'report' => 'programatico']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="issue" value="{{ $issue->id }}">
                                                    <input type="hidden" name="request_id" value="{{ 1 }}">

                                                    <div class="text-right">
                                                        {{-- <button type="button" class="btn btn-s pt-1 pb-1 btn-light border">
                                                            Reprovar
                                                        </button> --}}
                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar">Aprovar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-center text-warning">
                                                <small>{{ 'Não tem permissão para fazer essa aprovação! - Apenas Visualização' }}</small>
                                            </div>
                                        @endcan
                                    @endif
                                </div>

                                <div class="border-0 mb-2 pb-2">
                                     <h6 class="mt-2 p-1 bg-light rounded text-left text-muted fw-500">
                                        <i> Validação Financeira do Reporte</i>
                                    </h6>
                                    <h6 class="m-0 fw-600">Orçamento Realizado</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm borderless border table-striped" style="font-size: 90%">
                                            <thead class="table-active">
                                                <th class="fw-600">Rubirca</th>
                                                <th class="fw-600 text-center">V. Solicitado</th>
                                                <th class="fw-600 text-center">V. Realizado</th>
                                                <th class="fw-600 text-center">Aprovado</th>
                                            </thead>
                                            <tbody>
                                                @forelse ($issue->report_orcamento_realizado as $item)
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right cursor-pointer">
                                                            <b>{{ $item->orcamento->rubrica->rubrica}}.</b> {{ $item->orcamento->rubrica->name}}
                                                        </td>
                                                        <td class="p-0 pl-2 pr-2 border-right text-right cursor-pointer text-nowrap">
                                                            {{ number_format(($item->orcamento->issued_value),2) }} MZN
                                                        </td>
                                                        <td class="p-0 pl-2 pr-2 text-right border-right cursor-pointer text-nowrap">
                                                            {{ number_format(($item->orcamento->valor_realizado),2) }} MZN
                                                        </td>
                                                        <td class="p-0 pl-2 pr-2 text-center cursor-pointer">
                                                            @if ($item->is_approved)
                                                                <i class="icon-checkmark-circle text-success"></i>
                                                            @else
                                                                <i class="icon-cancel-circle2 text-danger"></i>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            {{ "Nenhum Orçamento reportado" }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if ($issue->report_orcamento_realizado()->where('is_approved', false)->count() > 0)
                                        @can('aprovar_realizado_financeiro', [App\Models\Issues::class, $issue, 8])
                                            <div class="mt-2">
                                                <form action="{{ route('time_entries.request.approve_validation', ['issue' => $issue['id'], 'report' => 'financeiro']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="issue" value="{{ $issue->id }}">
                                                    <input type="hidden" name="request_id" value="{{ 1 }}">

                                                    <div class="text-right">
                                                        {{-- <button type="button" class="btn btn-s pt-1 pb-1 btn-light border">
                                                            Reprovar
                                                        </button> --}}
                                                        <button type="submit"
                                                            class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600"
                                                            value="aprovar">
                                                            Validar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <div class="text-center text-warning">
                                                <small>{{ 'Não tem permissão para fazer essa aprovação! - Apenas Visualização' }}</small>
                                            </div>
                                        @endcan
                                    @endif
                                </div>

                                <div class="border-top mt-4 pt-2">
                                    <div class="mt-2">
                                        <h6 class="m-0 fw-600 text-muted">Comprovativos</h6>
                                        <div class="table-responsive nowrap">
                                            <table class="table table-sm table-hover" style="font-size: 92%">
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
                                                            <td colspan="5" class="text-center bg-light">
                                                                {{ 'Nenhum comprovativo adicionado' }}
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- @if ($issue->is_aproved) --}}
                            <div class="mt-2 border border-success alert-success text-center p-2">
                                Tarefa Aprovada - <b>
                                    <a href="{{ route('reports_files.issues.export_relatorio_orcamento', ['issue' => $issue->id]) }}" target="_blank">Gerar Relatório</a>
                                </b>
                            </div>
                        {{-- @endif --}}
                    </div>

                    <div class="col-md-5 border-left">

                        @if ($rubrica_orcamento != null)
                            <div class="cabimento-orcamento mb-3">
                                <div class="p-2 bg-light rounded">
                                    <h6 class="m-0 fw-600">Cambimento Orçamental da Rubrica</h6>
                                </div>

                                <div class="">
                                    <table class="table table-sm borderless border-0" style="font-size: 90%">
                                        <tbody>
                                            <tr>
                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Rubrica:</td>
                                                <td class="p-0 pl-2 pr-2 border-top-0">
                                                    {{ $rubrica_orcamento->rubrica }}.{{ $rubrica_orcamento->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600 text-nowrap">Orç. Disponivel:</td>
                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600">
                                                    {{ number_format(($rubrica_orcamento->orcamento),2) }} MZN
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Orç. Solicitado:</td>
                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-danger">
                                                    {{ number_format(($orcamento_solicitado->issued_value),2) }} MZN
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Impacto no Orçamento:</td>
                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-danger">
                                                    @if ($rubrica_orcamento->orcamento > 0)
                                                        {{ number_format((($orcamento_solicitado->issued_value / $rubrica_orcamento->orcamento) * 100),2) }}%
                                                    @else
                                                        N/A (Orçamento = 0)
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($rubrica_orcamento->orcamento <= 0)
                                                <tr>
                                                    <td class="text-center" colspan='2'>
                                                        <span>
                                                            <i class="icon-alert text-warning"></i>. Alert! Orçamento menor ou igual a zero (0).
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($orcamento_solicitado->issued_value > $rubrica_orcamento->orcamento)
                                                <tr>
                                                    <td class="text-center text-danger" colspan='2'>
                                                        <span>
                                                            <i class="icon-alert text-danger"></i>. Alert! Orçamento solicitado maior que orçamento disponível.
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <div class="indicators">
                            <div class="p-2 bg-light rounded">
                                <h6 class="m-0 fw-600">Indicadores ({{ sizeof($indicators) }})</h6>
                            </div>
                            @foreach ($indicators as $indicator)
                                <div class="mt-1 p-2 rounded border-bottom">
                                    <h6>
                                        <span class="fw-600">Indicador:</span>
                                        <span>{{ $indicator->indicator_field->name }}</span>
                                    </h6>
                                    <h6>
                                        <span class="fw-600">Meta:</span>
                                        <span>{{ $indicator->meta }}</span>
                                    </h6>
                                    <h6>
                                        <span class="fw-600">Fonte de verificação:</span>
                                        <span>{{ $indicator->fonte_ver }}</span>
                                    </h6>
                                    <h6>
                                        <span class="fw-600">Base de referência / População:</span>
                                        <span>{{ $indicator->base_ref }}</span>
                                    </h6>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @if ($showModal)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 pl-4 pr-4 bg-danger rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            Reprovar Fase
                        </h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mt-0 pt-3">
                        <h6 class="fw-600">
                            <span class="text-muted">Fase da Reprovação:</span>
                            <span>{{ $nivel_description }}</span>
                        </h6>
                        <div class="bg-light border p-2">
                            <form action="{{ route('orcamento.projecto.solicitacao.reprovar', [
                                'project_identifier' => $project['identifier'],
                                'issue' => $issue['id'],
                                'approvement' => $approvement
                                ])}}" method="POST">
                                @csrf
                                <div class="form-group mt-2">
                                    <label for="">Motivo da Reprovação</label>
                                    <textarea name="reprovacao[notes]" id="" cols="15" rows="5" class="form-control"></textarea>
                                    <small id="emailHelp" class="form-text text-muted">Especfique o motivo da reprovação</small>
                                    @error('rubrica_name') <small class="invalid-feedback d-inline">{{ $message }}</small> @enderror
                                </div>
                                <div class="">
                                    @if($nivel_description !== null)
                                        <button type="submit"class="btn btn-danger border-top-danger-800 shadow-sm">
                                            Submeter Reprovação
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in" wire:click="closeModal"></div>
        <div class="fade modal-backdrop show" wire:click="closeModal"></div>
    @endif

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
