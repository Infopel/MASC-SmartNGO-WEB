<div>

    @if ($showQuick)
        <div id="quick-wrapper" class="bg-white" wire:transition.slide.fade>
            <div class="quick-painel _1kydm _h9ior _iw3lm bg-white" style="width:400px;">
                <div class="main-container">
                    <div class="inner-content">
                        <div class="header">
                            <div class="bg-slate-700">
                                <div class="d-flex">
                                    <div class="">
                                        <div wire:click="closeQuick()" class="border-left border-secondary cursor-pointer" style="padding: 16px;">
                                            <i class="icon-menu7"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 text-center">
                                        <h6 class="m-0 p-3">
                                            Quick - Pesquisa Rapida
                                        </h6>
                                    </div>
                                    <div class="">
                                        <div wire:click="closeQuick()" class="border-left border-secondary cursor-pointer" style="padding: 16px;">
                                            <i class="icon-x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-1 shadow-sm border-0">
                                <div class="input-group flex-nowrap border-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-0 pr-0" id="addon-wrapping">
                                            <i wire:loading.class="d-none" class="icon-search4 mr-1"></i>
                                            <i wire:loading wire:target="search" class="icon-spinner2 spinner mr-1"></i>
                                        </span>
                                    </div>
                                    <input type="search" class="form-control border-0 fw-500" placeholder="{{ $search_title }}" aria-label="pesquisa" aria-describedby="addon-wrapping" style="font-size: 16px;" wire:model="search">
                                </div>
                            </div>

                        </div>

                        <div class="body mt-1">
                            <div class="p-4 bg-light align-items-center">
                                <div class="d-flex flex-row">
                                    <div class="col-md-4 text-center">
                                        <div wire:click="search_on('projects')"
                                            class="mb-2 cursor-pointer {{ $search_projects ? 'shadow bg-slate-400' : ' bg-white' }} p-3 rounded text-center">
                                            <i class="icon-stack3"></i>
                                        </div>
                                        <span class="text-muted small text-center">
                                            Projectos
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div wire:click="search_on('issues')"
                                            class="mb-2 cursor-pointer {{ $search_issues ? 'shadow bg-slate-400' : ' bg-white' }} p-3 rounded text-center">
                                            <i class="icon-stack3"></i>
                                        </div>
                                        <span class="text-muted small">
                                            Tarefas
                                        </span>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div wire:click="search_on('partners')"
                                            class="mb-2 cursor-pointer {{ $search_partners ? 'shadow bg-slate-400' : ' bg-white' }} p-3 rounded text-center">
                                            <i class="icon-stack3"></i>
                                        </div>
                                         <span class="text-muted small text-center">
                                            Parceiros
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="fw-600 text-muted">
                                    <span style="font-size: 90%" class="text-black-50">
                                        Encontramos ({{ sizeof($search_results) }}) resultados.
                                    </span>
                                </div>

                                <div class="mt-2 list overflow-auto custom-scrollbar-css" style="height:250px">
                                    @foreach ($search_results as $item)
                                        @if ($search_projects)
                                            <div class="proj-title">
                                                    <a href="{{ route('projects.overview', ['project_identifier' => $item['identifier']]) }}">
                                                    {{ $item['name'] ?? $item['subject'] }}
                                                </a>
                                            </div>

                                            <div class="proj-desc pl-3 text-muted" style="max-height: 60px">
                                                {!! $item['description'] !!}
                                            </div>

                                        @elseif($search_issues)
                                            <div class="proj-title">
                                                <a href="{{ route('issues.show', ['issue' => $item['id']]) }}">
                                                    {{ $item['subject'] }}
                                                </a>
                                            </div>

                                            <div class="proj-desc pl-3 text-muted" style="max-height: 60px">
                                                {!! $item['description'] !!}
                                            </div>
                                        @elseif($search_partners)
                                            <div class="proj-title">
                                                <a href="{{ route('partners.show', ['partner' => $item['id']]) }}">
                                                    {{ $item['name'] }}
                                                </a>
                                            </div>
                                        @endif
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="quick-bubble {{ $bt_quick ? 'show' : null }}" wire:transition.fade >
        <div class="quick-bubble-button" wire:click="showQuick()">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="help-bubble-question-icon" style="color: #62666b !important"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </div>
    </div>

</div>
