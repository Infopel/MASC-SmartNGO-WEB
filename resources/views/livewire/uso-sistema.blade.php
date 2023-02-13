<div>
    <div class="p-0">
        <h6 class="fw-600 text-muted mt-2">Nivel de Uso do Sistema</h6>
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
        <div class="grath-data">
            <div class="graf-title">
                <p
                    style="cursor: default; color:rgb(117, 117, 117) ; user-select: none;-webkit-font-smoothing: antialiased; font-size: 12px;"
                >
                    Gráfico de Barras - Nivel de Uso do Sistema
                </p>
                <p
                    ng-controller="orc_pdeController"
                    style=" margin-top: -18px; color:rgb(189, 189, 189);; cursor: default; user-select: none;-webkit-font-smoothing: antialiased;font-size: 14px"
                    class="ng-scope ng-binding"
                >

                </p>
            </div>
            <div class="grapth" style="min-height: 50vh">
                <vue-c3 :handler="relFinProject"></vue-c3>

                <div class="mt-3 mb-2">
                    <div class="d-flex">
                        <div
                            class="flex-grow-1 text-center p-2"
                            title="Nivel de Uso do Sistema"
                        >
                            <div
                                class="m-2 w-25 mr-auto ml-auto"
                                style="border-top: 3px solid #3366cc"
                            ></div>
                            <div
                                class="c3-legend-item text-black-50 fw-500"
                            >
                                Nivel de Uso do Sistema
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
