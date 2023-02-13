<div>
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 col-lg-12 bg-white p-3">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5 class="m-0 fw-600">
                                {{ __('Orçamento do Projecto') }} -

                            </h5>
                        </div>
                    </div>
                    <div class="" style="min-height:65vh">
                        <div class="mt-3">
                            <nav>
                                <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link link-option {{ $tab == 'LP' ? 'show active' : null }}" id="nav-LP" data-toggle="tab" href="#nav-LP" role="tab" aria-controls="nav-LP" aria-selected="true" wire:click="toogleTab('LP')">
                                        Lider de Programas
                                    </a>
                                    <a class="nav-item nav-link link-option {{ $tab == 'DAF' ? 'show active' : null }}" id="nav-DAF" data-toggle="tab" href="#nav-DAF" role="tab" aria-controls="nav-DAF" aria-selected="true" wire:click="toogleTab('DAF')">
                                        Directora Financeira
                                    </a>

                                    <a class="nav-item nav-link link-option {{ $tab == 'DExec' ? 'show active' : null }}" id="nav-DExec" data-toggle="tab" href="#nav-DExec" role="tab" aria-controls="nav-DExec" aria-selected="true" wire:click="toogleTab('DExec')">
                                        Directora Exectutiva
                                    </a>

                                </div>
                            </nav>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            @include('aprovement_plan._lider_Pilar')
                            @include('aprovement_plan._Daf')
                            @include('aprovement_plan._DExec')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading id="loading-indicator" wire:target="showModal, store_rubrica, filterYear">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
