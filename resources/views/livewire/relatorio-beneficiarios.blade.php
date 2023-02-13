<div class="mb-0">
    <div class="col-md-12">
        <div class="row py-3" style="min-height:80vh">
            <div class="col-md-12">
                <div class="d-flex">
                    @include('layouts._menu_reports', ['active' => $active])
                    <div class="flex-grow-1">
                        <div class="mb-3 d-none">
                            <div class="d-flex align-items-baseline p-3">
                                <div class="flex-grow-1">
                                    <h5 class="fw-600">Planos Estratégicos</h5>
                                </div>
                                <div class="">
                                </div>
                            </div>
                        </div>
                        <div class="bg-white border p-3">
                            <div class="d-flex h-100">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-baseline">
                                        <div class="flex-grow-1">
                                            <h5 class="fw-500 mb-0">
                                                Beneficiários - <span class="text-black-50">Por Genero</span>
                                                <span class="text-black-50">
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
                                            <p style="cursor: default; color:rgb(117, 117, 117) ; user-select: none;-webkit-font-smoothing: antialiased; font-size: 12px;">
                                                Gráfico de Barras - Relatório de Beneficiários
                                            </p>
                                            <p ng-controller="orc_pdeController" style=" margin-top: -18px; color:rgb(189, 189, 189);; cursor: default; user-select: none;-webkit-font-smoothing: antialiased;font-size: 14px" class="ng-scope ng-binding">
                                                Plano Estratégico 2017-2020
                                            </p>
                                        </div>
                                        <div class="grapth" style="min-height: 50vh">
                                            <div class="" id="relFinProjectos"></div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="finances border table table-sm table-striped table-hover">
                                                <thead class="table-active">
                                                    <th class="fw-600">PDE/Projecto</th>
                                                    <th class="fw-600">Homens</th>
                                                    <th class="fw-600">Mulheres</th>
                                                    <th class="fw-600">Total</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="4" class="text-center">
                                                            {{ __('lang.label_no_data') }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-left pl-2 ml-3" style="width:250px">
                                    <h5 class="border-bottom btn w-100 text-left fw-600 pl-1"><i class="icon-arrow-up5"></i>FILTROS</h5>
                                    <div class="_filters">
                                        <div class="border-bottom w-100">
                                            <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="flex-grow-1 text-muted">Periodo:</div>
                                                <div class="">
                                                    {{ "Mensal" }}
                                                    <i class="icon-arrow-down12"></i>
                                                </div>
                                            </div>
                                            <div class="dropdown-menu border my-shadow" aria-labelledby="dropdownNotidications">
                                                <ul class="list-unstyled pb-0 mb-0" style="max-height: 300px; overflow-y:auto">
                                                    <li class="dropdown-item cursor-pointer">Mensal</li>
                                                    <li class="dropdown-item cursor-pointer">Semestral</li>
                                                    <li class="dropdown-item cursor-pointer">Anual</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="border-bottom w-100">
                                            <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="flex-grow-1 text-muted">Ano:</div>
                                                <div class="">
                                                    {{ date('Y') }}
                                                    <i class="icon-arrow-down12"></i>
                                                </div>
                                            </div>
                                            <div class="dropdown-menu border my-shadow" aria-labelledby="dropdownNotidications">
                                                <ul class="list-unstyled pb-0 mb-0" style="max-height: 300px; overflow-y:auto">
                                                    <li class="dropdown-item cursor-pointer">{{ date('Y') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="border-bottom w-100">
                                            <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="flex-grow-1 text-muted">Data Inicial:</div>
                                                <div class="">
                                                    {{ "mm/dd/yyyy" }}
                                                    <i class="icon-arrow-down12"></i>
                                                </div>
                                            </div>
                                            <div class="dropdown-menu border my-shadow p-2" aria-labelledby="dropdownNotidications">
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="border-bottom w-100">
                                            <div class="w-100 d-flex pl-1 btn rounded-0 btn-white text-left cursor-pointer" id="dropdownNotidications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <div class="flex-grow-1 text-muted">Data Final:</div>
                                                <div class="">
                                                    {{ "mm/dd/yyyy" }}
                                                    <i class="icon-arrow-down12"></i>
                                                </div>
                                            </div>
                                            <div class="dropdown-menu border my-shadow p-2" aria-labelledby="dropdownNotidications">
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-3"></div>
                                    <h5 class="border-bottom btn w-100 text-left fw-600 pl-1"><i class="icon-arrow-up5"></i>FILTROS AVANCADOS</h5>
                                    <div class="_advanced_filters">
                                        <label for="show_genero" class="form-check-inline pl-1 mb-0 pb-0">
                                            <input type="radio" name="get_data_type" id="show_genero" value="1" checked="checked">
                                            <span class="pl-1">Mostrar dados por genero</span>
                                        </label>
                                         <label for="show_faixa_etaria" class="form-check-inline pl-1 mb-0 pb-0">
                                            <input type="radio" name="get_data_type" id="show_faixa_etaria">
                                            <span class="pl-1">Mostrar dados por faixa etaria</span>
                                        </label>
                                    </div>
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

    // Faixa Etaria
    /**
        1- Criancas
        2- 0 aos 5
        2- 6 aos 10
        2- 11 aos 15
        x- +de 50
        n- Idosos
    **/
     var loadGrath = function(){

        console.log('loaded');
         var chart = c3.generate({
            bindto: '#relFinProjectos',
            data: {
                columns: [
                    ['Homens', 30, 200, 100, 400, 150, 250],
                    ['Mulhere', 130, 100, 140, 200, 150, 50]
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
