<div class="mb-4">
    <div class="col-md-12 mb-4">
        <div class="row py-4" style="min-height:80vh">
            <div class="col-md-12">
                <div class="d-flex">
                    @include('layouts._menu_reports')

                    <div class="flex-grow-1">

                        <div class="bg-white border border-bottom-0">
                            <div class="d-flex align-items-baseline p-3">

                                <div class="flex-grow-1 form-inline">
                                    <div class="">
                                        <h6 class="fw-600 m-0 text-muted">Planos Estratégicos ({{ $project_pdes->count() }})</h6>
                                        <select name="" class="border p-1" wire:model="selected_project">
                                            <option value="">Selecione um plano estratégico</option>
                                            @foreach ($project_pdes as $pde)
                                                <option value="{{ $pde['id'] }}">{{ $pde['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ml-2">
                                        <h6 class="fw-600 m-0 text-muted">Ano</h6>
                                        <select name="" class="border p-1" wire:model="year">
                                            <option value="">Ano</option>
                                            <option value="2020">2020</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="">
                                    {{-- <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                        <select name="" class="border p-1" wire:model="selected_project">
                                            <option value="">Ano</option>
                                            <option value="2020">Ano - 2020</option>
                                        </select>
                                    </div> --}}
                                </div>
                            </div>
                            <hr class="mt-0 mb-0 mr-3 ml-3">
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <div class="d-flex align-items-baseline">
                                <div class="flex-grow-1">
                                    <h5 class="fw-600">
                                        Relatório Financeiro
                                        <span class="text-black-50"> -
                                            <a href="{{ route('projects.overview', ['project_identifier' => $project['identifier'] ?? 'select_project_identifier']) }}">{{ $project['name'] }}</a>
                                        <span>
                                    </h5>
                                </div>
                                <div class="">

                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                        <a href="#" class="btn btn-sm m-0 btn-dark">
                                            <i class="icon-file-pdf"></i>
                                            PDF
                                        </a>
                                        <a href="#" class="btn btn-sm m-0 btn-dark">
                                            <i class="icon-file-excel"></i>
                                            Excel
                                        </a>
                                        <button class="btn btn-sm m-0 btn-light border">
                                            Imprimir
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grath-data">
                                <div class="graf-title">
                                    <p style="cursor: default; color:rgb(117, 117, 117) ; user-select: none;-webkit-font-smoothing: antialiased; font-size: 16px;">
                                        Gráfico de Barras - Relatório de Orçamento
                                    </p>
                                    <p ng-controller="orc_pdeController" style=" margin-top: -18px; color:rgb(189, 189, 189);; cursor: default; user-select: none;-webkit-font-smoothing: antialiased;font-size: 14px" class="ng-scope ng-binding">
                                        {{ $project['name'] ?: null }}
                                    </p>
                                </div>
                                <div class="grapth" style="min-height: 50vh">
                                    <div class="" id="relFinProjectos"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="finances table table-sm table-striped table-hover">
                                        <thead class="table-active">
                                            <th>Linha Estratégica/Projecto</th>
                                            {{-- <th>Orçamento PD</th> --}}
                                            <th>(+) Orçamento</th>
                                            <th>(-) Valor Gasto</th>
                                        </thead>

                                        <tbody>
                                            @forelse ($dataTable as $linhaEstrat)
                                                <tr>
                                                    <td class="fw-600 text-nowrap" colspan="4">
                                                        {{ $linhaEstrat['name'] }}
                                                    </td>
                                                </tr>
                                                @foreach ($linhaEstrat['childs'] as $item)
                                                    <tr class="td-int-1 child">
                                                        <td class="td-int-1 child p-0 pr-2 pl-4 child">
                                                            <a href="{{ route('projects.overview', ['project_identifier' => $item['identifier']]) }}" class="link-option">
                                                                {{ $item['name'] }}
                                                            </a>
                                                        </td>
                                                        {{-- <td class="p-1 pr-2 pl-2">{{ "0.00 MZN"}}</td> --}}
                                                        <td class="p-1 pr-2 pl-2 text-nowrap text-black">
                                                            {{ number_format(($item->orcamento->sum('orcamento_inicial')),2) }} MZN
                                                        </td>
                                                        <td class="p-1 pr-2 pl-2 text-nowrap">
                                                            {{ number_format(($item->orcamento->sum('orcamento_gasto')),2) }} MZN
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @empty
                                                <tr>
                                                    <td colspan=3 class="text-center">
                                                        {{ __('lang.label_no_data') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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

@section('scripts')
<script>

    let data = null;
    let test = null;
    data = @json($data_graph);

    const loadGrath = () => {

         var chart = c3.generate({
            bindto: '#relFinProjectos',
            data: {
                json: data,

                type: 'bar',
                keys: {
                    x: 'project',
                    value: ['orcamento_inicial', 'orcamento_gasto']
                }
            },
            axis:{
                x:{
                    type: 'category',
                    x:['key'],
                }
            },

            bar: {
                width: {
                    ratio: 0.35 // this makes bar width 50% of length between ticks
                }
            }
        });
    }

    const testFunc = () => {
        console.log('test')
        data = "my-data";
        data = @json($project);

        console.log(data)
    }

    document.addEventListener("livewire:load", function(event) {
        loadGrath();

        window.livewire.hook('beforeDomUpdate', () => {

        });
        window.livewire.hook('afterDomUpdate', () => {
            testFunc();
            // console.info(@json($project))

        });
    });


</script>
@endsection
