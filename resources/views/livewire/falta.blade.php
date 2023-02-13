<div>
    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Dados em falta nos projectos</h6>
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
                        <th title="Projecto">Projecto</th>
                        <th title="Duracao">Duracao</th>
                        <th title="Local de Implementacao">Local de Imple</th>
                        <th title="Objectivo Geral" calss="text-success">Obj Geral</th>
                        <th title="Objectivos Especificos">Obj Especificos</th>
                        <th title="Objectivos do Plano Estrategico">Obj Plano Estrategico</th>
                        <th title="Orcamento do Projecto">Orcamento</th>
                        <th title="Inicio do ano Financeiro" calss="text-success">Ano Financeiro</th>
                       {{-- <th title="Resultado Final">Resul Final</th>
                        <th title="Resultado Intermedio">Resul Intermedio</th>
                        <th title="Resultado Imediato">Resul Imediato</th>--}}
                    </tr>
                </thead>
                <tbody>

                    @forelse ($projectsData as $key => $item )
                    <tr>
                            <td class="p-1 pl-2 pr-2">
                                {{ ++$key }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->name}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->duracao->value ? $item->duracao->value : 'Nao possui Duracao'}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->pronvincia ? $item->pronvincia->value : 'Nao possui Local de Implementacao'}}
                            </td>
                            <td class="p-1 pl-2 pr-2 ">
                                {{$item->objectivo_geral->value ? $item->objectivo_geral->value : 'Nao possui Objectivo Geral'}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->objectivo_especi->value ? $item->objectivo_especi->value : 'Nao possui Objectivos Especificos'}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->objectivo_plano ? $item->objectivo_plano->value : 'Nao possui Objectivo de Plano Estrategico'}}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{$item->orcamento_inicial}}
                            </td>
                            <td class="p-1 pl-2 pr-2 text-success">
                                {{$item->inicio_ano->value ? $item->inicio_ano->value : 'Nao possui Inicio do Ano Financeiro'}}
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

