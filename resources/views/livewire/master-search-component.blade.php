<div class="form-inline">

    @if (!$isSearchModal)
        <div class="form-inline">
            {{-- <label class="my-1 mr-2" for="inlineFormCustomSelectPref">{{ __('lang.label_search') }}:</label> --}}
            <input type="text" placeholder="Pesquisar Projecto ou actividades..." class="inp-proj form-control my-1 mr-sm-2" name="nomeProj" wire:click="toogelSearchModal">
        </div>
    @endif

    @if ($isSearchModal)
        <div class="">
            <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
                <div class="modal-dialog modal-lg modal-dialog-centered border-0" role="document">
                    <div class="modal-content bg-transparent border-0 shadow-none" style="min-height: 90vh;">
                        <div class="mb-3 bg-transparent rounded-0 d-flex justify-content-end">
                            <div class="d-flex align-center">
                                <button type="button" class="bg-transparent border-0 pl-2 pr-2 text-white" wire:click="toogelSearchModal" style="font-size: 24px">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="body-modal">
                            <div class="form-groups mb-2">
                                <div class="input-group input-group-sm mr-sm-1">
                                    <div class="input-group-prepend bg-white">
                                        <div class="input-group-text bg-white rounded-0 border-right-0">
                                            <i wire:loading.class="d-none" wire:target="search" class="icon-search4 mr-0 pt-1" style="font-size: 96%"></i>
                                            <i wire:loading wire:target="search" class="icon-spinner2 spinner mr-0 pt-1" style="font-size: 96%"></i>
                                        </div>
                                    </div>
                                    <input type="search" name="search[issue]" wire:model="search" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar projectos ou actividades..." autocomplete="off">
                                </div>
                            </div>

                            <div class="p-2 mt-2" style="font-size: 95%">
                                <div class="pb-2 pt-2 text-muted border-gray">
                                    Meus favoritos - <small>baseado no número de visitas</small>
                                </div>
                                <div class="row d-none -d-flex pl-2 pr-2">
                                    <div class="col-md-4 p-0">
                                        <div class="p-2 mr-2">
                                            <h6>
                                                <a href="#">
                                                    Project casa nova Project casa nova Project casa nova
                                                </a>
                                            </h6>
                                            <div class="small text-muted d-flex">
                                                <span class="mr-3">Visitou em: {{ date('Y') }}</span>
                                                <span class="mr-3">Actividades ({{2 }})</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 p-0">
                                        <div class="p-2 mr-2">
                                            <h6>
                                                <a href="#">
                                                    Project casa nova Project casa nova Project casa nova
                                                </a>
                                            </h6>
                                            <div class="small text-muted d-flex">
                                                <span class="mr-3">Visitou em: {{ date('Y') }}</span>
                                                <span class="mr-3">Actividades ({{2 }})</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 p-0">
                                        <div class="p-2 mr-2">
                                            <h6>
                                                <a href="#">
                                                    Project casa nova Project casa nova Project casa nova
                                                </a>
                                            </h6>
                                            <div class="small text-muted d-flex">
                                                <span class="mr-3">Visitou em: {{ date('Y') }}</span>
                                                <span class="mr-3">Actividades ({{2 }})</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top mt-2 mb-2 pb-2 pt-2 text-muted border-gray">
                                    Resultado da Pesquisa
                                </div>
                                @foreach ($search_ProjectsResults as $item)
                                    <div class="p-2">
                                        <small>Categoria: Projecto</small>
                                        <h6>
                                            <a href="{{ $item->route }}">
                                                {{ $item->name ?? null }}
                                            </a>
                                        </h6>
                                        <div class="small text-muted d-flex">
                                            <span class="mr-3">Visitou em: {{ date('Y') }}</span>
                                            <span class="mr-3">Actividades ({{ $item->issues->count() }})</span>
                                            <span class="mr-3">Membros ({{ $item->members->count() }})</span>
                                        </div>
                                    </div>
                                @endforeach

                                @foreach ($search_IssuesResults as $item)
                                    <div class="p-2">
                                        <small>Categoria: Actividade</small>
                                        <h6>
                                            <a href="#">
                                                {{ $item->subject ?? null }}
                                            </a>
                                        </h6>
                                        <span>Visitou em: {{ date('Y') }}</span>
                                    </div>
                                @endforeach


                                @if (sizeof($search_IssuesResults) == 0 || sizeof($search_ProjectsResults) == 0 )
                                    <div class="p-2 text-center text-muted small">
                                        <em>
                                            Digite no campo de pesquisa para procurar projectos e actividades ou selecione no recetemente visitados
                                        </em>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade in" wire:click="closeModal" style="opacity: 0.70;"></div>
            <div class="fade modal-backdrop show" wire:click="closeModal" style="opacity: 0.70;"></div>
        </div>
    @endif
</div>
