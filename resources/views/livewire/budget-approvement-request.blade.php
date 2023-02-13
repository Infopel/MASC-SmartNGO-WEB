<div class="row m-0 p-2">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 bg-white p-3" style="min-height: 70vh">
                <div class="mt-2 mb-2">
                    @include('errors.any')
                </div>
                <div class="d-flex mb-2">
                    <div class="flex-grow-1">
                        @if ($tipoSolicitacao)
                            <h5 class="mb-1 fw-600">
                                {{$tipoSolicitacao->title}}{{ __(' - Fluxo de Aprovação') }}
                            </h5>

                        @else
                            <h5 class="mb-1 fw-600">
                                {{ __('Solicitação de Fundos - Fluxo de Aprovação') }}
                            </h5>
                        @endif

                        <h6>
                            Num Requição {{ $solicitacaoFundos->num_requisicao }}
                        </h6>
                        <h6>
                            Projecto: <a href="{{ $solicitacaoFundos->project->route }}">{{ $solicitacaoFundos->project->name }}</a>
                        </h6>
                        <small class="text-danger">Estamos em atulização. Por favor pedimos que notifique caso a solicitação esteja num projecto errado para uniformizar os dados</small>
                    </div>
                </div>
                <hr class="mt-0 mb-3">

                <nav>
                  <div class="nav nav-tabs pb-0 mb-1" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link link-option active" id="fluxo-aprovacao" data-toggle="tab" href="#nav-fluxo-aprovacao" role="tab" aria-controls="nav-Aprovadas" aria-selected="true">Fluxo de aprovação</a>

                     <a class="nav-item nav-link link-option" id="nav-Solic-Reporvadas" data-toggle="tab" href="#nav-report-realizado" role="tab" aria-controls="nav-Reporvadas" aria-selected="true">Report Realizado</a>

                     <a class="nav-item nav-link link-option" id="nav-Solic-Reporvadas" data-toggle="tab" href="#nav-resumo-aprovacao" role="tab" aria-controls="aprovacao-resumo" aria-selected="true">Resumo de Usuarios envolvidos</a>
                  </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-fluxo-aprovacao" role="tabpanel" aria-labelledby="fluxo-aprovacao">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="aprovacao-nivel-1">
                                    <table class="table table-sm borderless border-0">
                                        <tbody>
                                            <tr>
                                                <td class="border-right text-nowrap border-top-0 fw-600">Num Requição</td>
                                                <td class="border-top-0">
                                                    <b>{{ $solicitacaoFundos->num_requisicao }}</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600">Objectivo</td>
                                                <td class="border-top-0" colspan="6">
                                                   {{ $solicitacaoFundos->objectivo }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600">Activiade</td>
                                                <td class="border-top-0 mb-2 border-bottom" colspan="6">
                                                    @if ($solicitacaoFundos->issue)
                                                        <a href="{{ $solicitacaoFundos->issue->route }}">
                                                            {{ $solicitacaoFundos->issue->subject }}
                                                        </a>
                                                    @else
                                                        <span class="text-warning">
                                                            <small>Não encontramos uma actividade associada a este processo.</small>
                                                            <button class="btn btn-sm link-option btn-light" wire:click="editTaskLink">
                                                                <i class="icon icon-link"></i> Associar Actividade
                                                            </button>

                                                        </span>

                                                        @if ($isEditTaskLink)
                                                            <div class="form-group mb-2 bg-light border rounded p-2 shadow mt-2" wire:transition.slide.down>
                                                                <label for="searchIssue" class="mb-0">Associar Activiade</label>
                                                                <small class="form-text text-muted mt-0 mb-1">Pesquise e selecione a activiade que pretende associar o orçamento solicitado.</small>
                                                                <div class="input-group w-auto">
                                                                    <input
                                                                        type="search"
                                                                        placeholder="Pesquisar e selecionar Actividade"
                                                                        class="my_input pl-2 pr-2 w-75"
                                                                        wire:model="searchIssue"
                                                                        autocomplete="off"
                                                                    />
                                                                    @if ($isSearchIssue)
                                                                        <div class="position-fixed" style="top:0; left:0; right:0; bottom:0" wire:click="reset_search"></div>
                                                                        <div class="bg-white border shadow-sm w-75 search-result p-1" style="max-width: 100% !important" wire:transition.slide.down>
                                                                            <ul class="list-unstyled m-0" style="max-height: 300px; overflow-y:auto; font-size: 94%">
                                                                                @if ($search_IssueRequest_result->count() > 0)
                                                                                @foreach ($search_IssueRequest_result as $issue)
                                                                                    <li class="dropdown-item cursor-pointer pl-3 rounded text-truncate" wire:click="selectIssue({{ $issue->id }}, '{{  $issue->subject }}')">
                                                                                        <span class="link-option">{{ $issue->id }}</span> - {{ $issue->subject }}
                                                                                    </li>
                                                                                @endforeach
                                                                                @else
                                                                                    <h6 class="dropdown-header pl-2 m-0">{{ __('lang.label_no_data') }}</h6>
                                                                                @endif
                                                                            </ul>
                                                                            <div class="align-content-center bg-light border-top d-flex justify-content-end pb-1 pl-2 pr-2 pt-1">
                                                                                <small class>({{ $search_IssueRequest_result->count() }}) - Resultados encontrados</small>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                @if ($selectedIssue['id'])
                                                                    <div class="pl-4 mt-2 mb-2 row row-cols-1 mr-3 w-75" wire:transition.slide.down>
                                                                        <span class="link-option">
                                                                            <span class="text-grey-800 font-weight-normal">
                                                                                Actividade:
                                                                            </span>
                                                                            <span>
                                                                            {{ $selectedIssue['subject'] }}
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                    <button class="mt-1 btn btn-sm btn-success w-auto" wire:click='storeTaskLinkUpdate({{ $selectedIssue['id'] }})'>
                                                                        Actualizar e Salvar
                                                                    </button>
                                                                @endif
                                                                <button class="mt-1 btn btn-sm btn-light border w-auto" wire:click="cancelTaskLink">
                                                                    Cancelar
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600">Local</td>
                                                <td class="border-top-0 text-muted">
                                                    {{ $solicitacaoFundos->local }}
                                                </td>
                                                <td class="border-right border-top-0 fw-600 text-nowrap">N Participantes:</td>
                                                <td class="border-top-0 border-right text-muted text-nowrap">
                                                    {{ $solicitacaoFundos->num_participantes }}
                                                </td>
                                                <td class="border-right border-top-0 fw-600 text-nowrap">N Dias:</td>
                                                <td class="border-top-0 border-right text-muted text-nowrap">
                                                    {{ $solicitacaoFundos->num_dias }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600">Autor:</td>
                                                <td class="border-top-0">
                                                    <a href="{{ route('users.show', ['user' => $solicitacaoFundos->requestBy->id]) }}">
                                                        {{ $solicitacaoFundos->requestBy->full_name }}
                                                    </a>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600">Data p/ execução:</td>
                                                <td class="border-top-0 text-muted">
                                                    {{ $solicitacaoFundos->data }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600">Requição em:</td>
                                                <td class="border-top-0 text-muted">
                                                    {{ $solicitacaoFundos->created_on}} -
                                                    {{ \Carbon\Carbon::parse($solicitacaoFundos->created_on)->diffForHumans() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>


                                    <div class="mt-3 mb-3 p-2" style="font-size: 95%">
                                        <div class="mb-2">
                                            <h6 class="fw-600">Areas</h6>
                                            @foreach ($solicitacaoFundos->areas as $item)
                                                <li>{{ $item->enumeration->name }}</li>
                                            @endforeach
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="fw-600">Actividades</h6>
                                            @foreach ($solicitacaoFundos->actividades as $item)
                                                <li>{{ $item->enumeration->name }}</li>
                                            @endforeach
                                        </div>
                                        <div class="mb-2">
                                            <h6 class="fw-600">Necessidades</h6>
                                            @foreach ($solicitacaoFundos->necessidades as $item)
                                                <li>{{ $item->enumeration->name }}</li>
                                            @endforeach
                                        </div>
                                    </div>

                                    <h6 class="mt-2 p-1 bg-light rounded text-left text-muted fw-500">
                                        <i>Orçamento da Tarefa</i>
                                    </h6>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-striped" style="font-size: 95%">
                                            <thead class="table-actives">
                                                <th class="fw-600 border-right border-top-0" title="Rubrica">
                                                    Rubrica
                                                </th>
                                                <th class="fw-600 border-top-0" title="Nome da Rubrica">Rubrica - Nome</th>
                                            </thead>

                                            <tbody>
                                                @forelse ($solicitacaoFundos->rubricas as $item)
                                                    <tr>
                                                        <td class="text-right text-nowrap">{{ $item->rubrica->rubrica }}</td>
                                                        <td>{{ $item->rubrica->name }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                       <td colspan="2" class="text-center"> Nenhum rubrica indicada... verifique os Documentos de suporte do Orçamento Solicitado</td>
                                                    </tr>
                                                @endforelse


                                            </tbody>
                                        </table>
                                        <table class="table table-sm table-striped mt-2" style="font-size: 95%">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-600 text-right text-nowrap"></td>
                                                    <td class="fw-600 text-nowrap text-right">Valor Solicitado: {{ number_format(($solicitacaoFundos->valor_estimado),2) }} MZN</td>
                                                </tr>
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
                                                        <th>{{ __('lang.field_description') }}</th>
                                                        <th>{{ __('lang.field_downloads') }}</th>
                                                        <th>{{ __('lang.label_added_by') }}</th>
                                                        <th>{{ __('lang.field_created_on') }}</th>
                                                    </thead>

                                                    <tbody>
                                                        @forelse ($solicitacaoFundos->documents as $attachment)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ route('attachments.getDocument', ['attachment' => $attachment->id, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                                                </td>
                                                                <td>{{ $attachment->filesize }} kb</td>
                                                                <td>{{ $attachment->description }}</td>
                                                                <td>{{ $attachment->downloads }}</td>
                                                                <td>{{ $attachment->user->full_name }}</td>
                                                                <td>{{ $attachment->created_on }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">
                                                                    Nenhum documento anexado....
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
                                    @foreach($flowSolicitacaoFundos as $index => $flow_step)
                                        <div class="aprovacao-nivel-{{ ++$index }}">
                                            <h6 class="mt-3 p-1 bg-light rounded text-left text-muted fw-500">
                                                <i>{{ $flow_step->flow->description }}</i>
                                                @if (!$flow_step->is_approved)
                                                    --
                                                    <small class="fw-600 text-primary">User a validar ({{ $flow_step->user->full_name }})</small>
                                                @endif
                                                --
                                                <small class="fw-600 text-muted small">({{ $flow_step->unapprovals_flow->count() }}) Reprovações</small>

                                            </h6>

                                            @if ($flow_step->is_approved)
                                                <div class="">
                                                    <table class="table table-sm borderless border-0 w-auto" style="font-size: 90%">
                                                        <tbody>
                                                            <tr>
                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Aprovado por:</td>
                                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600 text-capitalize">
                                                                    {{ $flow_step->approvedBy->full_name ?? null }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Categoria:</td>
                                                                <td class="p-0 pl-2 pr-2 border-top-0 fw-600">
                                                                    {{ $flow_step->flow->role->name }}
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

                                                    @can('can_approve_flow', [App\Models\FlowSolicitacaoFundos::class, $flow_step, $project, $flow_step->flow->role])
                                                        <div class="mt-2">
                                                            <form action="{{ route('orcamento.projecto.solicitacao_fundos.validation', [
                                                                'project_identifier' => $project['identifier'],
                                                                'requestNum' => $flow_step->num_requisicao,
                                                                'approvementFlow' => $flow_step->id
                                                                ]) }}" method="POST">
                                                                @csrf
                                                                <div class="text-right">
                                                                    @if ($isSubmit)
                                                                        <label class="text-danger">{{ __('lang.text_are_you_sure') }}</label>
                                                                        <button type="button" class="btn btn-s pt-1 pb-1 btn-light border"
                                                                            wire:click="cancel_action">
                                                                            Cancler
                                                                        </button>

                                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar">
                                                                            Sim Aprovar
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-s pt-1 pb-1 btn-light border"
                                                                            wire:click="request_reprovar({{ $flow_step->id }}, '{{ $flow_step->num_requisicao }}', '{{ $flow_step->flow->description }}')"
                                                                            >
                                                                            Reprovar
                                                                        </button>

                                                                        <button type="button"
                                                                            class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600 d-none" value="aprovar"
                                                                            wire:click="interceptApprovalRequestEvent()">
                                                                            Aprovar
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar"
                                                                            wire:click="interceptApprovalRequestEvent('{{ $flow_step->route_validation }}', {{ $flow_step->id }}, '{{ $flow_step->num_requisicao }}', '{{ $flow_step->flow->description }}')">
                                                                            Aprovar
                                                                        </button>
                                                                    @endif
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
                                                    </div>

                                                     <div class="mt-3 mb-3">

                                                        @foreach ($flow_step->unapprovals_flow as $item)
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

                                                    @if ($flow_step->solicitacao->requestBy->id == auth()->user()->id)
                                                        <div class="d-flex justify-content-end">
                                                            <div class="text-right mt-2 mr-2">
                                                                <a href="{{ route('orcamento.projecto.form_edit_solicitacao_fundos', [
                                                                    'project_identifier' => $project['identifier'],
                                                                    'requestNum' => $flow_step->num_requisicao
                                                                    ]) }}" class="btn btn-outline-primary pb-1 pt-1">
                                                                    Editar Requisição
                                                                </a>
                                                            </div>
                                                            <div class="">
                                                                <form action="{{ route('orcamento.projecto.solicitacao_fundos.requestApprovalAgain', [
                                                                    'project_identifier' => $project['identifier'],
                                                                    'requestNum' => $flow_step->num_requisicao,
                                                                    'approvementFlow' => $flow_step->id
                                                                ]) }}" method="POST">
                                                                    @csrf
                                                                    <div class="text-right mt-2">
                                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-light border">
                                                                            Requisição de aprovação
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-center text-warning">
                                                            <small>{{ 'Não tem permissão para fazer requisição de aprovação - apenas autor da requisição.' }}</small>
                                                        </div>
                                                    @endif
                                                @endif
                                        </div>
                                    @endforeach
                                </div>

                                 <div class="mt-2 mb-2">
                                    @include('errors.any')
                                </div>


                                @if ($solicitacaoFundos->latestAprovement->flow->is_flow_end)
                                    <div class="mt-2 border border-success alert-success text-center p-2">
                                            <a href="{{ route('orcamento.projecto.outputs', [
                                                'project_identifier' => $solicitacaoFundos->project->identifier,
                                                'requestNum' => $solicitacaoFundos->num_requisicao,
                                                'requestID' => $solicitacaoFundos->id
                                                ]) }}" target="_blank">
                                                Ver Outputs do processo
                                            </a>
                                        </b>
                                    </div>
                                @else
                                    <div class="mt-2 border border-warning alert-warning text-center p-2">
                                        <small>Os relatórios não estão disponíveis. O processo de solicitação de fundos não foi concluido.</small>
                                    </div>
                                @endif
                            </div>
                             <div class="col-md-5 border-left">
                                 {{-- <div class="p-2 bg-light rounded">
                                    <h6 class="m-0 fw-600">Objectivo da requisição de fundos</h6>
                                </div>
                                <div class="p-1 mt-2 ">
                                    {{ $solicitacaoFundos->objectivo }}
                                </div>
                                <hr class=""> --}}
                                <div class="mt-3 mb-2">
                                    <div class="p-2 bg-light rounded">
                                        <h6 class="m-0 fw-600">Detalhes do processemento de Pagamento</h6>
                                    </div>
                                    <div class="p-1" style="font-size: 90%">
                                        <table class="table table-index table-hover">
                                            <thead class="table-active">
                                                <th class="fw-600 p-0 pl-2 pr-2">Descrição dos campos</th>
                                                <th class="text-right p-2 pl-2 pr-2"></th>
                                            </thead>
                                            <tbody>
                                                <tr class="cursor-default">
                                                    <td class="cursor-default fw-600 p-0 pl-2 pr-2">Doador:</td>
                                                    <td class="cursor-default text-right p-2 pl-2 pr-2">{{ $solicitacaoFundos->processoPagamento->doador_name ?? null }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cursor-default fw-600 p-0 pl-2 pr-2">Tipo de Pagamento:</td>
                                                    <td class="cursor-default text-right p-2 pl-2 pr-2">{{ $solicitacaoFundos->processoPagamento->paymentType ?? null }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cursor-default fw-600 p-0 pl-2 pr-2">Nome do Banco:</td>
                                                    <td class="cursor-default text-right p-2 pl-2 pr-2">{{ $solicitacaoFundos->processoPagamento->nome_banco ?? null }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cursor-default fw-600 p-0 pl-2 pr-2">Número de Conta:</td>
                                                    <td class="cursor-default text-right p-2 pl-2 pr-2">{{ $solicitacaoFundos->processoPagamento->num_banco ?? null }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cursor-default fw-600 p-0 pl-2 pr-2">NIB:</td>
                                                    <td class="cursor-default text-right p-2 pl-2 pr-2">{{ $solicitacaoFundos->processoPagamento->nib_banco ?? null }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="cursor-default fw-600 p-0 pl-2 pr-2">Valor Solicitado:</td>
                                                    <td class="cursor-default text-right p-2 pl-2 pr-2">{{ number_format(($solicitacaoFundos->processoPagamento->valor ?? 0), 2).' MZN' }}</td>
                                                </tr>
                                                <tr>
                                                    <td  class="text-right p-0 pl-2 pr-2"></td>
                                                    <td  class="text-right p-0 pl-2 pr-2"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="nav-report-realizado" role="tabpanel" aria-labelledby="nav-report-realizado">
                        <div class="row m-0">
                            <div class="p-2">
                                <h5 class="mb-1 fw-500 text-slate-700">
                                    Fluxo de aprovação do report de realização
                                </h5>
                                <small class=''>Note: under development</small>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show active" id="nav-resumo-aprovacao" role="tabpanel" aria-labelledby="aprovacao-resumo">

                    </div>

                </div>

            </div>
        </div>
    </div>

    @if ($hasManyUsersToApproveModal)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 pl-4 pr-4 bg-success rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            Notificação Importante
                        </h5>
                        <button type="button" class="close text-white" wire:click="closeModal" style="padding: 0.5rem 1rem;margin: -0.3rem -1rem -1rem auto;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mt-0 pt-3">
                        <h6 class="fw-600">
                            <span class="text-muted">Proxima fase de aprovação:</span>
                            <span>{{ $nivel_description }}</span>
                        </h6>

                        <fieldset class="box bg-light p-2 mt-2 text-capitalize border mb-2">
                            <legend class="text-capitalize w-auto pt-0 pb-0 pl-1 pr-2 mb-0"><span class="text-muted">Categoria: </span> {{ $role_need }}</legend>
                            <div class="roles-selection pl-2 pr-2">
                                @foreach ($usersToApprove as $user)
                                    <label class="floating">
                                        <input type="radio" name="usersToApprove" value="{{ $user['id'] }}" wire:model="userTo">
                                        {{ $user['firstname'] }} {{ $user['lastname'] }}
                                    </label>
                                @endforeach
                            </div>
                         </fieldset>

                        <div class="alert alert-light bg-light p-2" style="font-size: 92%">
                            Encontramos 2 (ou mais) usuários que ocupam o mesmo papel <b>({{ $role_need }})</b> necessário para a proxima aprovação nesse projecto. Para prosseguir com a sua validação por favor selecione para que usuário deve se notificar a proxima aprovação.
                        </div>

                        <div class="mt-2 mb-2">
                            @include('errors.any')
                        </div>

                        <div class="">
                            @if ($userTo !== null)
                                <form action="{{ $_redirect_to }}" method="POST">
                                    @csrf
                                    <button type="submit"class="btn btn-success border-bottom-green-800 shadow-sm">
                                        Continuar
                                    </button>
                                </form>
                            @else
                                <button type="submit"class="btn btn-success border-bottom-green-800 shadow-sm" wire:click="dispatchRequest">
                                    Continuar
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in" wire:click="closeModal"></div>
        <div class="fade modal-backdrop show" wire:click="closeModal"></div>
    @endif

    @if ($showModal)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 pl-4 pr-4 bg-danger rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            Reprovar Fase
                        </h5>
                        <button type="button" class="close" wire:click="closeModal" style="padding: 0.5rem 1rem;margin: -0.3rem -1rem -1rem auto;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mt-0 pt-3">
                        <h6 class="fw-600">
                            <span class="text-muted">Fase da Reprovação:</span>
                            <span>{{ $nivel_description }}</span>
                        </h6>
                        <div class="bg-light border p-2">
                            <form action="{{ route('orcamento.projecto.solicitacao_fundos.reprovarStep', [
                                'project_identifier' => $project['identifier'],
                                'requestNum' => $requestNum,
                                'approvementFlow' => $approvementFlow
                            ]) }}" method="POST">
                                @csrf
                                <div class="form-group mt-2">
                                    <label for="">Motivo da Reprovação</label>
                                    <textarea name="reprovacao[notes]" id="" cols="15" rows="5" class="form-control"></textarea>
                                    <small id="emailHelp" class="form-text text-muted">Especfique o motivo da reprovação</small>
                                    @error('rubrica_name') <small class="invalid-feedback d-inline">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group mt-2">
                                    <label for="reprovado_por">Reprovado por</label>
                                    <input type="text" name="reprovado_por" class="form-control" disabled value="{{ auth()->user()->firstname . " " . auth()->user()->lastname }}">
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
