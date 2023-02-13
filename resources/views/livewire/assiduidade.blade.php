<div>
    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Usuarios Mais Activos no Sistema</h6>
        <div class="filtros">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <div class="form-inline">
                       {{-- <div class="form-group mr-sm-1 mb-2">
                            <select name="filter['status']" wire:model="bugType" class="custom-select custom-select-sm rounded-0">
                                <option value="requestDuplicated">Solicitação Duplicada</option>
                                <option value="flowDuplicated">Steps de Validação Duplicados</option>
                            </select>
                            </div>--}}
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
                        <th title="ID da Requição (Solicitação)">Nome</th>
                        <th title="Actions">Ultimo Log In</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($AssiduidadeData as $key => $item )
                    <tr>
                            <td class="p-1 pl-2 pr-2">
                                {{ ++$key }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->full_name}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->last_login_on}}
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

    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Usuarios Menos Activos no Sistema</h6>
        <div class="filtros">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <div class="form-inline">
                       {{-- <div class="form-group mr-sm-1 mb-2">
                            <select name="filter['status']" wire:model="bugType" class="custom-select custom-select-sm rounded-0">
                                <option value="requestDuplicated">Solicitação Duplicada</option>
                                <option value="flowDuplicated">Steps de Validação Duplicados</option>
                            </select>
                            </div>--}}
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
                        <th title="ID da Requição (Solicitação)">Nome</th>
                        <th title="Actions">Ultimo Log In</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($AssiduidadeDa as $key => $item )
                    <tr>
                            <td class="p-1 pl-2 pr-2">
                                {{ ++$key }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->full_name}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->last_login_on}}
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
