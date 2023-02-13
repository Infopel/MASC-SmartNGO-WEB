<div class="mb-4">
    <div class="col-md-12 mb-4">
        <div class="row py-4" style="min-height:80vh">
            <div class="col-md-12">
                <div class="d-flex">
                    @include('layouts._menu_reports', ['active' => $active])
                    <div class="flex-grow-1">
                        <div class="bg-white border mb-3">
                            <div class="d-flex align-items-baseline p-3">

                                <div class="flex-grow-1">
                                    <h5 class="fw-600">Planos Estratégicos ({{ $project_pdes->count() }})</h5>
                                    <select name="" class="border p-1" wire:model="selected_project">
                                        <option value="">Selecione um plano estratégico</option>
                                        @foreach ($project_pdes as $pde)
                                            <option value="{{ $pde['id'] }}">{{ $pde['name'] }}</option>
                                        @endforeach
                                    </select>

                                    @if ($selected_project != null)
                                        <select name="" class="border p-1" wire:model="selected_linhaEstrategica">
                                            <option value="">Selecione a linha estratégica</option>
                                            @foreach ($project_linhasEstr as $pde)
                                                <option value="{{ $pde['id'] }}">{{ $pde['name'] }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                </div>
                                <div class="">
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border p-3">
                            <div class="d-flex align-items-baseline">
                                <div class="flex-grow-1">
                                    <h5 class="fw-600">
                                        Relatório Financeiro
                                        <span class="text-black-50"> -
                                            <a href="{{ route('projects.overview', ['project_identifier' => $project['identifier'] ?? 'p']) }}">{{ $project['name'] }}</a>
                                        <span>
                                    </h5>
                                </div>
                                <div class="">

                                    <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                        <a href="#" class="btn btn-sm m-0 btn-secondary">
                                            <i class="icon-file-pdf"></i>
                                            PDF
                                        </a>
                                        <a href="#" class="btn btn-sm m-0 btn-secondary">
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
                                        Plano Estratégico 2017-2020
                                    </p>
                                </div>
                                <div class="grapth" style="min-height: 50vh">
                                    <div class="" id="relFinProjectos"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="finances table table-sm table-striped table-hover">
                                        <thead class="table-active">
                                            <th>Projecto</th>
                                            <th>(+) Orçamento</th>
                                            <th>(-) Valor Gasto</th>
                                        </thead>

                                        <tbody>
                                            @foreach ($projects as $project)
                                                <tr>
                                                    <td>{{ $project->name }}</td>
                                                    <td>
                                                        {{-- {{ number_format(( $project->custom_field_values->where('custom_field_id', 42)->first()['value'] ?? 0),2) }} --}}
                                                        {{ $project->custom_field_values->where('custom_field_id', 42)->first()['value'] ?? 0 }}
                                                        MZN
                                                    </td>
                                                    <td>
                                                        {{ number_format((0),2) }} MZN
                                                    </td>
                                                </tr>
                                            @endforeach
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

     var loadGrath = function(){

        console.log('loaded');
         var chart = c3.generate({
            bindto: '#relFinProjectos',
            data: {
                columns: [
                    ['Data 1', 30, 200, 100, 400, 150, 250],
                    ['Data 2', 130, 100, 140, 200, 150, 50]
                ],
                type: 'bar'
            },
            bar: {
                width: {
                    ratio: 0.5 // this makes bar width 50% of length between ticks
                }
            }
        });
    }

    document.addEventListener("livewire:load", function(event) {
        loadGrath();

        window.livewire.hook('beforeDomUpdate', () => {
        });
        window.livewire.hook('afterDomUpdate', () => {

            loadGrath();
        });
    });


</script>
@endsection
