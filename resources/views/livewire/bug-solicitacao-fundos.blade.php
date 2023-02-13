<div>
    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Tipo de Bug</h6>
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
                            <select name="filter['status']" wire:model="bugType" class="custom-select custom-select-sm rounded-0">
                                <option value="requestDuplicated">Solicitação Duplicada</option>
                                <option value="flowDuplicated">Steps de Validação Duplicados</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-0 mt-1">
        <div class="table-responsive">
            <table class="table table-sm table-hover" style="font-size: 80%">
                <thead class="table-active">
                    <tr>
                        <th>#</th>
                        <th title="ID da Requição (Solicitação)">SolID</th>
                        <th title="Referência da requisição">Referência</th>
                        <th title="Numero de passos da requisição">Num Steps</th>
                        <th title="Numero de passos da esperados" calss="text-success">Num Steps Experados</th>
                        <th title="Numero de Passos ja aprovados">Steps Aprovados</th>
                        <th title="Actions" class="text-danger">Error Type</th>
                        <th title="Actions">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($solicitacaoData as $key => $item)
                        <tr>
                            <td class="p-1 pl-2 pr-2">
                                {{ ++$key }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ $item->id }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ $item->num_requisicao }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ $item->approvements->count() }}
                            </td>
                            <td class="p-1 pl-2 pr-2 text-success">
                                10/11
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ $item->approvements()->where('is_approved', true)->count() }}
                            </td>
                            <td class="p-1 pl-2 pr-2 text-danger">
                                Processos Duplicados (Erro Ref)
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                <a href="#" onclick="return false" class="text-dark"><i class="icon-close2"></i> Remover Duplicados</a><br>
                                <a href="#" onclick="return false" class="text-danger"><i class="icon-trash"></i> Remover todos</a><br>
                                <a href="#" onclick="return false" class="text-success"><i class="icon-pencil5"></i> Atualizar Referência</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                Parabens nao encontramos nenhum BUG, Isso e tudo que nos sabemos. from HunterX
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
