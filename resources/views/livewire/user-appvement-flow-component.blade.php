<div>
    <div class="row m-0 p-2">
        <div class="col-lg-12 col-md-12 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    <div class="d-flex align-items-baseline border-bottom pb-1 mb-1">
                        <div class="flex-grow-1">
                            <h5>{{ __('Requição de Aprovação') }}</h5>
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

                    <div class="p-0">
                        <h6 class="fw-600 text-muted mt-1">Filtros</h6>
                        <div class="filtros">
                            <div class="d-flex">
                                {{-- <div class="flex-grow-1">
                                    <div class="form-group mb-2 w-50">
                                        <div class="input-group input-group-sm mr-sm-1">
                                            <div class="input-group-prepend bg-white">
                                                <div class="input-group-text bg-white rounded-0 border-right-0">
                                                    <i wire:loading.class="d-none" wire:target="search" class="icon-search4 mr-0 pt-1" style="font-size: 96%"></i>
                                                    <i wire:loading wire:target="search" class="icon-spinner2 spinner mr-0 pt-1" style="font-size: 96%"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="search[issue]" wire:model="search" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar">
                                        </div>
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
                        </div>
                    </div>

                    <div class="table-responsive">

                        @if ($showUserApprovalRequests)
                            <table class="table table-sm table-hover table-striped" style="font-size: 93%">
                                <thead class="table-active">
                                    <th class="text-nowrap fw-600">Aprovação</th>
                                    <th class="fw-600" style="max-width: 450px">Projecto</th>
                                    <th class="fw-600" style="max-width: 450px">Tarefa</th>
                                    <th class="text-nowrap fw-600">Orcamento</th>
                                    <th class="text-nowrap fw-600">Requição em</th>
                                    <th class="text-nowrap fw-600">Aprovado Por</th>
                                    <th class="text-nowrap fw-600">Aprovado em</th>
                                    <th class="text-nowrap text-center fw-600">Estado</th>
                                </thead>

                                <tbody>
                                    @forelse ($userApprovalRequests as $item)
                                        <tr>
                                            <td>
                                                {{ $item->approvement_flow->description }}
                                            </td>
                                            <td>
                                                <a href="{{ $item->issue->project->route }}">
                                                    {{ $item->issue->project->name }}
                                                </a>
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
                                                {{ $item->created_on }}
                                            </td>
                                            <td>
                                                {{ $item->is_approved ? $item->approvedBy->full_name : null }}
                                            </td>
                                            <td>
                                                {{ $item->is_approved ? $item->approved_on : null }}
                                            </td>
                                             <td class="p-0 pl-2 pr-2 text-center">
                                                @if (!$item->is_approved)
                                                    {{-- <div class="progress rounded-0" style="width:80px; height: 12px;">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                            role="progressbar"
                                                            aria-valuenow="80"
                                                            aria-valuemin="0"
                                                            aria-valuemax="100"
                                                            style="width: 80%; height: 12px;">
                                                        </div>
                                                    </div> --}}
                                                    <span class="badge rounded-0 p-1 badge-danger">Pendente</span>
                                                @else
                                                    <span class="badge rounded-0 p-1 badge-success">Aprovado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8"  class="text-center">
                                                {{ __('lang.label_no_data') }} - <span class="text-success fw-600">Aprovação: </span>
                                                <b>{{ $selected_approval->description ?? 'Selecione o Tipo de Aprovação' }}</b>
                                                --- <span class="text-danger fw-600">Estado:</span> <b>{{ $statusTitle }}</b>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <table class="table table-sm table-hover table-striped" style="font-size: 93%">
                                <thead class="table-active">
                                    <th class="text-nowrap fw-600">Aprovação</th>
                                    <th class="fw-600" style="max-width: 450px">Projecto</th>
                                    <th class="fw-600" style="max-width: 450px">Tarefa</th>
                                    <th class="text-nowrap fw-600">Orcamento</th>
                                    <th class="text-nowrap fw-600">Requição em</th>
                                    {{-- <th class="text-nowrap fw-600">Ultima Aprovação</th> --}}
                                    {{-- <th class="text-nowrap fw-600">Aprovado</th> --}}
                                    <th class="text-nowrap text-center fw-600">Minha Aprovação</th>
                                </thead>

                                <tbody>
                                    @forelse ($resources as $item)
                                        <tr>
                                            <td class="p-0 pl-2 pr-2">
                                                {{ $item->aprovement->approvement_flow->description}}
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                <a href="{{ $item->aprovement->issue->project->route }}">
                                                    {{ $item->aprovement->issue->project->name }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                {{-- <a href="{{ $item->aprovement->issue->route }}">
                                                    {{ $item->aprovement->issue->subject }}
                                                </a> --}}
                                                <a href="{{ route('orcamento.projecto.solicitacao-fundos.show',[
                                                        'project_identifier' => $item->aprovement->issue->project->identifier,
                                                        'issue' => $item->aprovement->issue->id
                                                        ])
                                                    }}">

                                                    {{ $item->aprovement->issue->subject }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                {{ number_format(($item->aprovement->issue->orcamento->sum('issued_value')),2) }} MZN
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                {{ $item->created_on }}
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
                                            <td colspan="6"  class="text-center">
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
    </div>
    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
