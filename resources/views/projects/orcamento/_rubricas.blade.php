<div class="tab-pane fade {{ $tab == 'rubricas' ? 'show active' : null }}" id="nav-rubricas" role="tabpanel" aria-labelledby="nav-rubricas-orcamento">
    <div class="d-flex align-items-center">
        <div class="flex-grow-1">
            <h5 class="fw-600 text-muted">Rubricas e Orcamento </h5>
        </div>
        @can('cadastrar_rubricas_projecto', App\Models\Budgets::class)
            <div class="">
                <div class="text-lowercase mb-2">
                    <a href="#" onclick="return false;" wire:click="showImportModel()" class="btn btn-dark btn-sm border shadow-sm">
                        <i class="icon-file-excel"></i>
                        <span>{{ __('Importar Rubricas') }}</span>
                    </a>
                    <a href="#" onclick="return false;" wire:click="showModal()" class="text-success btn btn-light btn-sm border shadow-sm">
                        <i class="icon-plus2"></i>
                        <span>{{ __('Nova Rubrica') }}</span>
                    </a>
                </div>
            </div>
        @endcan
    </div>
    <div class="mt-2 mb-2">
        @if (session()->has('success'))
            <div class="alert alert-success p-2 mb-0">
                {!! session('success') !!}
            </div>
        @elseif(session()->has('warning'))
            <div class="alert alert-warning p-2 mb-0">
                {!! session('warning') !!}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger p-2 mb-0">
                {!! session('error') !!}
            </div>
        @elseif(session()->has('removeRubrica'))
            <div class="alert alert-danger p-2 mb-0">
                {{ __('lang.text_are_you_sure') }}
                <h6>{{ __('lang.button_delete').' '.__('Rubrica') }}: <b>{{ $remove_rubrica['name'] }}</b><h6>
                <div class="text-left">
                    <button type="submit" class="btn btn-sm btn-danger" wire:click="removeRubrica('{{ $remove_rubrica['id'] }}', 1)">SIM TENHO</button>
                </div>
            </div>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-sm table-hover- table-striped table-bordered" style="font-size: 90%">
            <thead class="table-active">
                <th class="fw-600">Rubrica</th>
                <th class="fw-600">Descrição</th>
                <th class="fw-600">Orçamento</th>
                <th class="fw-600">Criado em</th>
                <th class="fw-600">Criado por</th>
                <th></th>
            </thead>
            <tbody class="table-bordereds">
                @foreach ($rubricas as $rubrica)
                    <tr wire:transition.slide.down>
                        <td class="p-0 pl-2 pr-2" style="width:80px">
                            {{ $rubrica['rubrica'] }}.
                        </td>
                        <td class="p-0 pl-2 pr-2">
                            <a href="#" onclick="return false" wire:click="select_rubrica({{ $rubrica['id'] }})">
                                {{ $rubrica['name'] }}
                            </a>
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{ number_format(($rubrica['orcamento']),2) }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{ $rubrica['created_on'] }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-nowrap">
                            {{ $rubrica['author']['firstname'] }}
                        </td>
                        <td class="p-0 pl-2 pr-2 text-center text-nowrap">

                            @can('atualizar_rubricas_projecto', \App\Models\Budgets::class)
                                <a href="#" onclick="return;" title="Editar" wire:click="editRubrica('{{ $rubrica['id'] }}')">
                                    <i class="icon-pencil5"></i>
                                </a>
                            @endcan
                            @can('excluir_rubricas_projecto', \App\Models\Budgets::class)
                                <a href="#" onclick="return;" class="text-danger ml-2" wire:click="removeRubrica('{{ $rubrica['id'] }}', 0)" title="Remover">
                                    <i class="icon-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @isset($rubrica['child'])
                        @include('livewire.child_rubricas',['childs' => $rubrica['child']])
                    @endisset
                @endforeach

                @if (sizeof($rubricas) <= 0)
                    <tr>
                        <td class="text-center" colspan="6">
                            {{ __('lang.label_no_data') }}
                        </td>
                    </tr>
                @else
                    <tr class="table-active">
                        <td colspan="2" class="text-right fw-600">
                            Total</td>
                        <td colspan="4" class="text-nowrap fw-600 pl-2">
                            {{ number_format(($rubricas->sum("orcamento_inicial")),2) }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4 bg-slate-700 rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            {{ __('Nova Rubrica - Orçamento') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body mt-0 pt-3">
                        <h6 class="fw-600">
                            <span class="text-muted">Nova Rubrica</span>
                        </h6>

                        <div class="bg-light border p-2">

                            <div class="form-group mt-2 mb-1">
                                <div class="form-row align-items-center">
                                    <div class="col-12 my-1">
                                        <div class="dropdown w-100">
                                            <button class="btn btn-secondary dropdown-toggle btn-light border shadow-none fw-600" type="button" id="dropdown_coins" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" wire:click="rubrica_pai_is_clicked">
                                                Rubrica Pai
                                            </button>

                                            {{ ' - '.$selected_rubrica_parent_name }}

                                            @if ($rubrica_pai_is_clicked ?? false)
                                                <div id="menu" class="dropdown-menu w-100 d-block" aria-labelledby="dropdown_coins" style="position: absolute; transform: translate3d(0px, 37px, 0px); top:0px; left: 0px; will-change: transform;" wire:transition.fade>
                                                    <form class="px-4 py-2">
                                                        <input type="search" class="form-control" placeholder="Pesquisar (nome/rubrica)" autofocus="autofocus" wire:model="rubrica_parent" >
                                                    </form>
                                                    <div id="menuItems" style="max-height:250px; overflow-y:auto">
                                                        <li class="dropdown-item cursor-pointer"
                                                            wire:click="selected_rubrica_parent()">
                                                            Sem Pai
                                                        </li>
                                                        @foreach ($rubricas_search_result as $rubrica)
                                                            <li class="dropdown-item cursor-pointer"
                                                                wire:click="selected_rubrica_parent({{ $rubrica->id }},{{ $rubrica->rubrica }}, '{{ $rubrica->name }}')">
                                                                {{ $rubrica->rubrica.'.'.$rubrica->name }}
                                                            </li>
                                                        @endforeach
                                                    </div>
                                                    @if (sizeof($rubricas_search_result) <= 0)
                                                        <div id="empty" class="dropdown-header"  wire:transition.slide.down>
                                                            {{ __('lang.label_no_data') }}
                                                        </div>
                                                    @endif
                                                </div>

                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-auto my-1">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text fw-600">
                                                    {{ $selected_rubrica_parent ?  $selected_rubrica_parent.'.' : "N/A" }}
                                                </div>
                                            </div>
                                             <input type="text" class="form-control" wire:model="rubrica_slef" size='8' placeholder="Rubrica (1.1)" input_type="float">
                                        </div>
                                    </div>
                                    <div class="col-auto my-1">
                                        <input type="text" class="form-control" wire:model="rubrica_year" placeholder="Ano: {{ date('Y') }}">
                                    </div>
                                </div>
                                <small id="emailHelp" class="form-text text-muted">1- Rubrica Pai: <b>1</b> >> 2 - Sub Rubrica <b>1.2</b></small>
                                @error('rubrica_parent') <small class="invalid-feedback d-inline">{{ $message }}</small> @enderror
                                @error('rubrica_slef') <small class="invalid-feedback d-inline">{{ $message }} ||</small> @enderror
                                @error('rubrica_year') <small class="invalid-feedback d-inline">{{ $message }} ||</small> @enderror
                            </div>
                            <div class="form-group mt-2">
                                <label for="rubrica_name_id">Descrição da Rubrica</label>
                                <input type="text" name="rubrica_name_input" class="form-control" wire:model="rubrica_name" id="rubrica_name_id" placeholder="Desenvolvimento de materiais e instrumentos">
                                @error('rubrica_name') <small class="invalid-feedback d-inline">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label for="rubrica_value_id">Orçamento</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">MZN</div>
                                    </div>
                                    <input type="text" class="form-control"  wire:model="rubrica_value" id="rubrica_value_id" placeholder="0.00" input_type="float">
                                </div>
                                <small id="emailHelp" class="form-text text-muted">Orçamento atual: <b>{{ number_format(($edit_rubrica ? $edit_rubrica->orcamento : 0),2) }} MZN</b>.</small>
                                @error('rubrica_value') <small class="invalid-feedback d-inline">{{ $message }}</small> @enderror
                            </div>

                            <div class="">
                                @if ($edit_rubrica)
                                    <button class="btn btn-success border-top-success-800 shadow-sm" wire:click="update_rubbrica()">
                                        {{ __('lang.button_update')}} Rubrica
                                    </button>
                                @else
                                    <button class="btn btn-primary border-top-primary-800 shadow-sm" wire:click="store_rubrica()">
                                        {{ __('lang.button_create')}} Rubrica
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in" wire:click="closeModal"></div>
        <div class="fade modal-backdrop show" wire:click="closeModal"></div>
    @endif


    @if ($importModel)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 pl-4 pr-4 bg-slate-700 rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            {{ __('Importar Rubricas - Orçamento') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body mt-0 pt-3">
                        <form action="{{ route('orcamento.projecto.import-rubricas-orcamento', ['project_identifier' => $project->identifier]) }}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <div class="custom-file">
                                <input type="file" class="custom-file" name="file" required>
                                <small class="text-muted">Selecione um ficheiro valido (csv ou excel files)</small>

                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">Validar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-backdrop fade in" wire:click="closeModal"></div>
        <div class="fade modal-backdrop show" wire:click="closeModal"></div>
    @endif
</div>
