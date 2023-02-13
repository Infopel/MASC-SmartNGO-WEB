<div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 bg-white p-3" style="min-height: 70vh">
                    <div class="d-flex mb-2">
                        <div class="flex-grow-1">
                            <h5 class="m-0 fw-600">
                                {{ __('Solicitação de Fundos') }}
                            </h5>
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
                                    {{-- <div class="form-group mb-2 w-25">
                                        <div class="input-group input-group-sm mr-sm-1">
                                            <div class="input-group-prepend bg-white">
                                                <div class="input-group-text bg-white rounded-0 border-right-0">
                                                    <i wire:loading.class="d-none" wire:target="search_issue" class="icon-search4 mr-1" style="font-size: 96%"></i>
                                                    <i wire:loading wire:target="search_issue" class="icon-spinner2 spinner mr-1" style="font-size: 96%"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="search[issue]" wire:model="search_issue" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar tarefa">
                                        </div>
                                    </div> --}}
                                    <div class="form-inline">
                                        <div class="form-group ml-sm-1 mr-sm-1 mb-2">
                                            <select name="filter['status']" wire:model="approvement_flow_id" class="custom-select custom-select-sm rounded-0">
                                                <option value="null" selected>Tipo de Aprovação</option>
                                                @foreach ($approvement_flows as $approvement_flow)
                                                    <option value="{{ $approvement_flow->id }}">{{ $approvement_flow->description }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group ml-sm-1 mr-sm-1 mb-2">
                                            <select name="filter['status']" wire:model="status" class="custom-select custom-select-sm rounded-0">
                                                <option value="approved">Aprovado</option>
                                                <option value="pending">Aprovação Pendente</option>
                                                <option value="rejected">Reprovado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <div class="form-group ml-sm-0 mr-sm-0 mb-2">
                                        <select name="search[ano]" wire:model="provincia" class="custom-select custom-select-sm rounded-0">
                                            <option value="null" selected>Províncias</option>
                                            @foreach ($project_provincias as $provincia)
                                                <option value="{{ $provincia['value'] }}">{{ $provincia['value'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                                <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
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
                                    <th class="text-nowrap fw-600">Aprovação</th>
                                    <th class="text-nowrap fw-600">Requição em</th>
                                    <th class="fw-600">Tarefa</th>
                                    <th class="text-nowrap fw-600">Orcamento</th>
                                    <th class="text-nowrap fw-600">Província</th>
                                    <th class="text-nowrap fw-600">Aprovado por</th>
                                    <th class="text-nowrap fw-600">Papel</th>
                                    <th class="fw-600">Aprovado em</th>
                                    <th class="text-nowrap text-center fw-600">Estado</th>
                                </thead>

                                <tbody>
                                    @forelse ($userApprovalRequests as $index => $item)
                                        <tr>
                                            <td>
                                                {{ $item->approvement_flow->description }}
                                            </td>
                                            <td>
                                                {{ $item->created_on }}
                                            </td>
                                            <td>
                                                <a href="{{ route('orcamento.projecto.solicitacao-fundos.show',[
                                                        'project_identifier' => $item->issue->project->identifier,
                                                        'issue' => $item->issue->id
                                                        ])
                                                    }}">
                                                    {{ $item->issue->subject }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ number_format(($item->issue->orcamento->sum('issued_value')),2) }} MZN
                                            </td>
                                            <td>
                                                {{ 'N/A' }}
                                            </td>
                                            <td>
                                                {{ $item->is_approved ? $item->approvedBy->full_name : null }}
                                            </td>
                                            <td>
                                                {{ $item->role->name ?? null }}
                                            </td>
                                            <td>
                                                {{ $item->is_approved ? $item->approved_on : null }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-center">
                                                @if (!$item->is_approved)
                                                    <span class="badge rounded-0 p-1 badge-danger">Pendente</span>
                                                @else
                                                    <span class="badge rounded-0 p-1 badge-success">Aprovado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9"  class="text-center">
                                                {{ __('lang.label_no_data') }} - <span class="text-success fw-600">Aprovação: </span>
                                                <b>{{ $selected_approval->description ?? 'Selecione o Tipo de Aprovação' }}</b>
                                                --- <span class="text-danger fw-600">Estado:</span> <b>{{ $statusTitle }}</b>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <table class="table table-sm table-hover table-striped" style="font-size: 90%">
                                <thead class="table-active">
                                    <th>-</th>
                                    <th class="fw-600" style="width: 450px">Tarefa</th>
                                    <th class="text-nowrap fw-600">Requição em</th>
                                    <th class="text-nowrap fw-600">Orcamento</th>
                                    <th class="text-nowrap fw-600">Província</th>
                                    <th class="text-nowrap fw-600">Aprovado por</th>
                                    <th class="text-nowrap fw-600">Papel</th>
                                    <th class="fw-600">Data</th>
                                    <th class="text-nowrap text-center fw-600">Aprovação</th>
                                </thead>
                                <tbody class="border-bottom">
                                    @forelse ($approvement_requests as $index => $item)
                                    {{-- {{ dd($item) }} --}}
                                        <tr>
                                            <td>{{ ++$index }} </td>
                                            <td>
                                                <a href="{{ route('orcamento.projecto.solicitacao-fundos.show',[
                                                        'project_identifier' => $item->aprovement->issue->project->identifier,
                                                        'issue' => $item->aprovement->issue->id
                                                        ])
                                                    }}">

                                                    {{ $item->aprovement->issue->subject }}
                                                </a>
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $item->aprovement->created_on }}
                                            </td>
                                            <td class="fw-600 text-nowrap">
                                                {{ number_format(($item->aprovement->issue->orcamento->sum('issued_value')),2) }} MZN
                                            </td>
                                            <td class="fw-600 text-nowrap">
                                                {{ $item->aprovement->issue->provincia->value ?? 'N/A' }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $item->aprovement->approvedBy ? $item->aprovement->approvedBy->full_name : null }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $item->aprovement->approvedBy ? $item->aprovement->role->name : null }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $item->aprovement->approved_on }}
                                            </td>
                                            <td class="text-center">
                                                @if (!$item->aprovement->is_approved)
                                                    <span class="badge rounded-0 p-1 badge-danger">Pendente</span>
                                                @else
                                                    <span class="badge rounded-0 p-1 badge-success">Aprovado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9"  class="text-center">
                                                {{ __('lang.label_no_data') }} - <span class="text-success fw-600">Aprovação: </span>
                                                <b>{{ $selected_approval->description ?? 'Selecione o Tipo de Aprovação' }}</b>
                                                --- <span class="text-danger fw-600">Estado:</span> <b>{{ $statusTitle }}</b>
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
