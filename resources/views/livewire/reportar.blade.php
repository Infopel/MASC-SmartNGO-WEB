<div>
    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Actividades nao Reportadas</h6>
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
                        <th title="Projecto">Actividades</th>
                        <th title="Duracao">Data de Realizacao</th>
                        <th title="Local de Implementacao">Nome</th>
                        <th title="Objectivo Geral" calss="text-success">Conctacto</th>

                    </tr>
                </thead>
                <tbody>

                    @forelse ($IssuesData as $key => $item )
                    <tr>
                            <td class="p-1 pl-2 pr-2">
                                {{ ++$key }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->subject}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->due_date}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->firstname.' '.$item->lastname}}
                            </td>
                            <td class="p-1 pl-2 pr-2 text-success">
                                {{$item->login}}
                            </td>
                            <td class="p-1 pl-2 pr-2">

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
