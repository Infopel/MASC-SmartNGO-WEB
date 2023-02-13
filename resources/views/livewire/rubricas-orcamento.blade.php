<div>
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 col-lg-12 bg-white p-3">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5 class="m-0 fw-600">
                                {{ __('Orçamento do Projecto') }} -
                                <span class="text-muted">{{ $project->name }}</span>
                            </h5>
                        </div>
                    </div>
                    <div class="" style="min-height:65vh">
                        <div class="mt-3">
                            <nav>
                                <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link link-option {{ $tab == 'resumo' ? 'show active' : null }}" id="nav-info-proejct" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true" wire:click="toogleTab('resumo')">
                                        Resumo
                                    </a>
                                    <a class="nav-item nav-link link-option {{ $tab == 'rubricas' ? 'show active' : null }}" id="nav-rubricas-orcamento" data-toggle="tab" href="#nav-rubricas" role="tab" aria-controls="nav-rubricas" aria-selected="true" wire:click="toogleTab('rubricas')">
                                        Rubricas de Orçamento
                                    </a>

                                    <a class="nav-item nav-link link-option {{ $tab == 'requestOrcamento' ? 'show active' : null }}" id="nav-request-orcamento" data-toggle="tab" href="#nav-requestOrcamento" role="tab" aria-controls="nav-requestOrcamento" aria-selected="true" wire:click="toogleTab('rubricas')">
                                        Requisições de Orçamento
                                    </a>

                                    @if ($is_associar_despesas)
                                        <a class="nav-item nav-link link-option {{ $tab == 'associar_despesas' ? 'show active' : null }}" id="nav-associar_despesas" data-toggle="tab" href="#nav-despesas" role="tab" aria-controls="nav-despesas" aria-selected="true" wire:click="toogleTab('rubricas')">
                                            Despesas Associadas
                                        </a>
                                    @endif

                                </div>
                            </nav>
                        </div>
                        <div class="tab-content" id="nav-tabContent">
                            @include('projects.orcamento._resumo')
                            @include('projects.orcamento._rubricas')
                            @include('projects.orcamento._associar_despesas')
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
