<div class="tab-pane fade {{ $tab == 'resumo' ? 'show active' : null }}" id="nav-info" role="tabpanel" aria-labelledby="nav-info-proejct">
    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Filtros</h6>
        <div class="filtros">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <div class="form-group mb-2 w-25">
                        <div class="input-group input-group-sm mr-sm-1">
                            <div class="input-group-prepend bg-white">
                                <div class="input-group-text bg-white rounded-0 border-right-0">
                                    <i wire:loading.class="d-none" wire:target="search_rubrica" class="icon-search4 mr-1" style="font-size: 96%"></i>
                                    <i wire:loading wire:target="search_rubrica" class="icon-spinner2 spinner mr-1" style="font-size: 96%"></i>
                                </div>
                            </div>
                            <input type="search" name="search[rubrica]" wire:model="search_rubrica" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar Rubrica">
                        </div>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="form-group ml-sm-0 mr-sm-2 mb-2">
                        {{-- <label for="">Pronícias ({{ $project_provincias->count() ?? 0 }})</label> --}}
                        <select name="" class="border p-1" wire:model="provincia">
                            <option value="" selected>Selecione a Provincia</option>
                            @foreach ($project_provincias as $project_provincia)
                                <option value="{{ $project_provincia['value'] }}">{{ $project_provincia['value'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-sm-0 mr-sm-0 mb-2">
                        <select name="search[ano]" wire:model="filterYear" class="custom-select custom-select-sm rounded-0">
                            <option value="all-years">Todos Anos</option>
                            @foreach ($years as $item)
                                <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive mb-4">
        <table class="table table-sm table-hover table-striped table-bordered mb-4" style="font-size:92%">
            <thead class="table-active">
                <th class="fw-600">Rubrica</th>
                <th class="fw-600">Descrição</th>
                <th class="fw-600">Orçamento</th>
                <th class="fw-600 text-center">Realizado {{ $filterYear }}</th>
                <th class="text-center text-nowrap fw-600">Jan</th>
                <th class="text-center text-nowrap fw-600">Fev</th>
                <th class="text-center text-nowrap fw-600">Mar</th>
                <th class="text-center text-nowrap fw-600">Abr</th>
                <th class="text-center text-nowrap fw-600">Mai</th>
                <th class="text-center text-nowrap fw-600">Jun</th>
                <th class="text-center text-nowrap fw-600">Jul</th>
                <th class="text-center text-nowrap fw-600">Ago</th>
                <th class="text-center text-nowrap fw-600">Set</th>
                <th class="text-center text-nowrap fw-600">Out</th>
                <th class="text-center text-nowrap fw-600">Nov</th>
                <th class="text-center text-nowrap fw-600">Dez</th>
                <th class="text-center text-nowrap fw-600">Saldo</th>
                <th class="text-center text-nowrap fw-600">Execução</th>
            </thead>

            <tbody>
                @foreach ($rubricas as $rubrica)
                    <tr class="cursor-default {{ ($rubrica->orcamento_inicial() < $rubrica->valor_gasto_tarefas(null, '2020')) ? 'alert-danger' : '' }}" {{ ($rubrica->orcamento_inicial() < $rubrica->valor_gasto_tarefas(null, '2020')) ? "style=background:#f9d6d5" : '' }}>
                        <td class="p-0 pl-2 pr-2">
                            {{ $rubrica['rubrica'] }}
                        </td>
                        <td class="text-nowrap p-0 pl-2 pr-2 text-truncate cursor-pointer" style="max-width: 360px" title="{{ $rubrica['name']}}">
                            {{ $rubrica['name'] }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap" title="Orçamento inicial da rubrica">
                            {{ number_format(($rubrica->orcamento_inicial()),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                             {{  number_format(($rubrica->valor_gasto_tarefas(null, '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('1', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('2', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('3', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('4', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('5', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('6', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('7', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('8', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('9', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('10', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('11', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{  number_format(($rubrica->valor_gasto_tarefas('12', '2020')),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{ number_format((
                                $rubrica->orcamento_inicial() - $rubrica->valor_gasto_tarefas(null, '2020')
                                ),2) }}
                        </td>
                        <td class="text-center fw-600 p-0 pl-2 pr-2 text-nowrap">
                            @if ($rubrica->orcamento_inicial() != 0)
                                {{ number_format((
                                   ( $rubrica->valor_gasto_tarefas(null, '2020') / $rubrica->orcamento_inicial()) * 100
                                    ),2) }}%
                            @else
                                0.00%
                            @endif
                        </td>
                    </tr>

                    @isset($rubrica['child'])
                        @include('projects.orcamento._child_rubricas_resumo', ['childs' => $rubrica['child']])
                    @endisset
                @endforeach

                @if (sizeof($rubricas) <= 0)
                    <tr>
                        <td class="text-center" colspan="18">
                            {{ __('lang.label_no_data') }}
                        </td>
                    </tr>
                @else
                    <tr class="table-active">
                        <td colspan="2" class="text-right fw-600">Total</td>
                        <td class="text-nowrap fw-600 text-nowrap">
                            {{ number_format(($rubricas->sum("orcamento_inicial")),2) }}
                        </td>
                        <td class="fw-600 text-nowrap">0.00</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_jan']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_feb']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_mar']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_apr']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_may']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_jun']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_jul']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_aug']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_sep']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_oct']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_nov']),2) }}</td>
                        <td class="fw-600 text-nowrap">{{ number_format(($_totalMensal['_dec']),2) }}</td>
                        <td class="fw-600 text-nowrap">
                            {{ number_format(($rubricas->sum("orcamento_inicial") - $_totalMensal['_anual_total']),2) }}
                        </td>
                        <td class="text-center fw-600 text-nowrap">
                            {{ number_format(
                                (
                                    ($_totalMensal['_anual_total'] / $rubricas->sum("orcamento_inicial")) * 100
                                )
                                ,2) }}%
                        </td>
                    </tr>
                    <tr class="bg-light cursor-default">
                        <td colspan="4" class="small text-black-50 text-right">Descrição dos tatais</td>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Jan</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Fev</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Mar</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Abr</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Mai</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Jun</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Jul</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Ago</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Set</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Out</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Nov</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Dez</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Saldo</th>
                        <th class="text-center text-nowrap fw-600 p-1 small text-black-50">Execução</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
