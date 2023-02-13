<div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 bg-white p-3" style="min-height: 70vh">
                    <div class="d-flex mb-2">
                        <div class="flex-grow-1">
                            <h5 class="m-0 fw-600">
                                {{ __('Solicitação de Fundos') }}
                            </h5>
                            <a href="{{ route('orcamento.projecto.form_solicitacao_fundos', ['project_identifier' => $project['identifier']]) }}" class="btn btn-sm m-0 btn-success mt-2 border">Nova Solicitação</a>
                        </div>
                        <div class="">
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <a href="#" class="btn btn-sm m-0 border {{ !$showUserApprovalRequests ? 'btn-dark fw-600' : '' }}"
                                    wire:click="choseDataPoll('ToApprove')"
                                >
                                    Por Aprovar
                                </a>
                                <button class="btn btn-sm m-0 border {{ $showUserApprovalRequests ? 'btn-dark fw-600' : '' }}"
                                    wire:click="choseDataPoll('UserApprovalRequest')"
                                >
                                    Minha Solicitação
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="p-0">
                        <h6 class="fw-600 text-muted mt-2">Filtros</h6>
                        <div class="filtros">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="form-inline">
                                        {{-- <div class="form-group ml-sm-1 mr-sm-1 mb-2">
                                            <select name="filter['status']" wire:model="filter_flow" class="custom-select custom-select-sm rounded-0">
                                                <option value="null" selected>Tipo de Aprovação</option>
                                                @foreach ($approvement_flows as $approvement_flow)
                                                    <option value="{{ $approvement_flow->id }}">{{ $approvement_flow->description }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        <div class="form-group mr-sm-1 mb-2">
                                            <select name="filter['status']" wire:model="filter_status" class="custom-select custom-select-sm rounded-0">
                                                <option value="pending">Aprovação Pendente</option>
                                                <option value="approved">Aprovado</option>
                                                <option value="rejected">Reprovado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <div class="form-group ml-sm-1 mr-sm-2 mb-2">
                                        <select name="search[mes]" wire:model="filter_mes" class="custom-select custom-select-sm rounded-0">
                                            <option value="null" selected>Selecione o Mes...</option>
                                            <option value="01">Janeiro</option>
                                            <option value="02">Fevereiro</option>
                                            <option value="03">Marco</option>
                                            <option value="04">Abril</option>
                                            <option value="05">Maio</option>
                                            <option value="06">Junho</option>
                                            <option value="07">Julho</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Setembro</option>
                                            <option value="10">Outubro</option>
                                            <option value="11">Novembro</option>
                                            <option value="12">Dezembro</option>
                                        </select>
                                    </div>
                                    <div class="form-group ml-sm-0 mr-sm-0 mb-2">
                                        <select name="search[ano]" wire:model="filter_ano" class="custom-select custom-select-sm rounded-0">
                                            <option value="all" selected>Todos Anos</option>
                                            @foreach ($years as $item)
                                                <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mt-0">
                        @if ($showUserApprovalRequests)
                            <table class="table table-sm table-hover table-striped" style="font-size: 90%">
                                <thead class="table-active">
                                    <th class="text-nowrap fw-600">Num Requição</th>
                                    <th class="text-nowrap fw-600">Requisição</th>
                                    <th class="text-nowrap fw-600">Requisição em</th>
                                    <th class="text-nowrap fw-600">Orçamento</th>
                                    <th class="text-nowrap fw-600">Local de Exec.</th>
                                    <th class="text-nowrap fw-600">Aprovado por</th>
                                    <th class="text-nowrap fw-600">Papel</th>
                                    <th class="fw-600">Aprovado em</th>
                                    <th class="text-nowrap text-center fw-600">Estado</th>
                                    <th class="text-nowrap text-center fw-600">Acção</th>
                                </thead>

                                <tbody>
                                    @forelse ($requestsSolicitacaoFundos as $index => $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('orcamento.projecto.details-solicitacao_fundos', [
                                                    'project_identifier' => $project['identifier'],
                                                    'requestNum' => $item['num_requisicao']
                                                    ]) }}">{{ $item['num_requisicao'] }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('orcamento.projecto.details-solicitacao_fundos', [
                                                    'project_identifier' => $project['identifier'],
                                                    'requestNum' => $item['num_requisicao']
                                                    ]) }}">{{ $item['flow']['description'] }}</a>
                                            </td>
                                            <td>{{ $item['created_on'] }}</td>
                                            <td>{{ number_format(($item['solicitacao']['valor_estimado']),2) }} MZN</td>
                                            <td>{{ $item['solicitacao']['local'] }}</td>
                                            <td>{{ $item['approvedBy']['firstname'] ?? null }}</td>
                                            <td>{{ $item['validator_category'] }}</td>

                                            @if (in_array($item['id'], $enable_delete_on))
                                                <td class="" colspan="4">
                                                    <div class="form-inline">
                                                        <span class="ml-2">
                                                            <span class="text-danger">
                                                                {{ __('lang.text_are_you_sure') }}
                                                            </span>
                                                            <button class="btn btn-sm btn-danger ml-1 border-top-success-800 shadow-sm"
                                                                wire:click="delete_solicitacaoFundos({{ $item['id'] }}, '{{ $item['num_requisicao'] }}', {{ true }})">
                                                                Sim Remover
                                                            </button>

                                                            <button class="btn btn-sm btn-light border ml-1 shadow-sm"
                                                                wire:click="cancel_delete_request()">
                                                                Cancelar
                                                            </button>
                                                        </span>
                                                    </div>
                                                </td>
                                            @else

                                                <td>{{ $item['approved_on'] }}</td>
                                                <td class="p-0 pl-2 pr-2 text-center">
                                                    @if (!$item['is_approved'] && $item['is_rejected'] == false)
                                                        <span class="badge rounded-0 p-1 bg-warning border-0 text-black-50">Pendente</span>
                                                    @elseif ($item['is_rejected'] && !$item['is_approved'])
                                                        <span class="badge rounded-0 p-1 badge-danger">Reprovado</span>
                                                    @else
                                                        <span class="badge rounded-0 p-1 badge-success">Aprovado</span>
                                                    @endif
                                                </td>
                                                <td class="p-0 pl-2 pr-2 text-center text-danger">
                                                    <a href="#" onclick="return false;" wire:click="delete_solicitacaoFundos({{ $item['id'] }}, '{{ $item['num_requisicao'] }}')">
                                                        <i class="icon icon-trash"></i>
                                                        Remover
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10"  class="text-center">
                                                {{ __('lang.label_no_data') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <table class="table table-sm table-hover table-striped" style="font-size: 90%">
                                <thead class="table-active">
                                    <th class="text-nowrap fw-600">Num Requisiição</th>
                                    <th class="text-nowrap fw-600">Requisição</th>
                                    <th class="text-nowrap fw-600">Orçamento</th>
                                    <th class="text-nowrap fw-600">Solicitado Por</th>
                                    <th class="fw-600">Solicitado em</th>
                                    <th class="fw-600">Aprovado em</th>
                                    <th class="text-nowrap text-center fw-600">Estado</th>
                                </thead>

                                <tbody class="border-bottom">
                                    @forelse ($toApproveSolicitacaoFundos as $index => $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('orcamento.projecto.details-solicitacao_fundos', [
                                                    'project_identifier' => $project['identifier'],
                                                    'requestNum' => $item['num_requisicao']
                                                    ]) }}">{{ $item['num_requisicao'] }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('orcamento.projecto.details-solicitacao_fundos', [
                                                    'project_identifier' => $project['identifier'],
                                                    'requestNum' => $item['num_requisicao']
                                                    ]) }}">{{ $item['flow']['description'] }}</a>
                                            </td>
                                            <td>{{ number_format(($item['solicitacao']['valor_estimado'] ?? 0),2) }} MZN</td>
                                            <td>{{ $item['request_by']['firstname']. ' ' .$item['request_by']['lastname'] }}</td>
                                            <td>{{ $item['created_on'] }}</td>
                                            <td>{{ $item['approved_on'] }}</td>
                                            <td class="p-0 pl-2 pr-2 text-center">
                                                @if (!$item['is_approved'] && !$item['is_rejected'])
                                                    <span class="badge rounded-0 p-1 bg-warning border-0 text-black-50">Pendente</span>
                                                @elseif ($item['is_rejected'] && !$item['is_approved'])
                                                    <span class="badge rounded-0 p-1 badge-danger">Reprovado</span>
                                                @else
                                                    <span class="badge rounded-0 p-1 badge-success">Aprovado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9"  class="text-center">
                                                {{ __('lang.label_no_data') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading id="loading-indicator" wire:target="issues_status, filter_ano, filter_mes, provincia, choseDataPoll">
            <i class="icon-spinner spinner"></i>
            <span>Carregando dados...</span>
        </div>
    </div>
