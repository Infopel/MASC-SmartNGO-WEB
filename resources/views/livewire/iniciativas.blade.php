<div class="row m-0 p-2">
    <div class="col-lg-12 col-md-12 admin-container">
        <div class="row h-100 rounded">
            <div class="card-block p-3 rounded">

                {{-- Actions Notifications --}}
                @include('errors.any')
                {{-- /Actions Notifications --}}

                <div class="d-flex border-bottom pb-1 mb-1">
                    <div class="flex-grow-1">
                        <h5>{{ __('Iniciativas') }}</h5>
                    </div>
                </div>
                <div class="p-0">
                    <h6 class="fw-600 text-muted mt-1">Filtros</h6>
                    <div class="filtros">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <div class="form-group mb-2 w-50">
                                    <div class="input-group input-group-sm mr-sm-1">
                                        <div class="input-group-prepend bg-white">
                                            <div class="input-group-text bg-white rounded-0 border-right-0">
                                                <i wire:loading.class="d-none" wire:target="search" class="icon-search4 mr-0 pt-1" style="font-size: 96%"></i>
                                                <i wire:loading wire:target="search" class="icon-spinner2 spinner mr-0 pt-1" style="font-size: 96%"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="search[issue]" wire:model="search" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-2">
                    <table class="table table-sm table-hover table-striped mb-3" style="font-size: 93%">
                        <thead class="table-active">
                            <th>Nome</th>
                            <th>Tipo de Iniciativa</th>
                            <th>Bairro</th>
                            <th>Mobilizador</th>
                            <th>Data de Constituicao</th>
                            <th>Accao</th>

                        </thead>
                        <tbody>
                            @forelse ($iniciativas as $item)
                                <tr class="{{ $item->deleted_at !== null ? 'text-danger' : null}}">
                                    <td class="p-1 pl-2 pr-2 text-nowrap">
                                        {{ $item->nome }}
                                    </td>
                                    <td class="p-1 pl-2 pr-2 text-nowrap">
                                        {{ $item->tipoIniciativa}}
                                    </td>
                                    <td class="p-1 pl-2 pr-2">
                                            {{ $item->bairro}}
                                    </td>
                                    <td class="p-1 pl-2 pr-2 text-nowrap">
                                        {{ $item->idMobilizador}}
                                    </td>

                                    <td class="p-1 pl-2 pr-2 text-nowrap">
                                        {{ $item->dataConstituicao}}
                                    </td>

                                    @if($item->deleted_at !== null)
                                        <td></td>
                                    @else
                                        <td class="p-0 pl-2 pr-2 text-nowrap">
                                            <a href="#" onclick="return" wire:click='edit({{ $item->id }})'
                                                title="Editar"
                                                class="mr-2">
                                                <i class="icon-pencil5"></i>
                                            </a>
                                            <a href="#" onclick="return" wire:click='delete({{ $item->id }}, {{ false }})'
                                                title="Remover"
                                                class="mr-2 text-danger">
                                                <i class="icon-trash"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">
                                        {{ __('lang.label_no_data') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Modal - Adicionar Novo Intem do Fluxo --}}
        @if ($show_form_modal)
            <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content p-3">

                        <div class="modal-header p-2 pl-4 pr-4">
                            <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                                <span class="text-muted">
                                    Formulario - Editar Iniciativas
                                </span>
                            </h5>
                            <button type="button" class="close" wire:click="closeModal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>


                            <form wire:submit.prevent="updateIniciativas" method="POST">

                                <div class="modal-body mt-3 pt-0">
                                    <div class="bg-light border p-2">
                                        <div class="tabular">

                                            <p class="">
                                                <label for="my_input">Nome<span class="text-danger"></span></label>
                                                <input size="100" class="my_input" type="text"
                                                    name="flow[nome]"
                                                    wire:model="nome"
                                                    placeholder="Nome">
                                                @error('nome')
                                                    <br>
                                                    <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </p>

                                            <p class="">
                                                <label for="my_input">Tipo de Iniciativa<span class="text-danger"></span></label>
                                                <input size="100" class="my_input" type="text"
                                                    name="flow[tipoIniciativa]"
                                                    wire:model="tipoIniciativa"
                                                    placeholder="Tipo de Iniciativa">
                                                @error('tipoIniciativa')
                                                    <br>
                                                    <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </p>

                                            <p>
                                                <label class="">
                                                    {{ __('Localizacao') }}<span class="text-danger"></span>
                                                </label>
                                                <select name="" id="" class="my_input p-1" wire:model="idLocalizacao">
                                                    <option value="">Localizacao</option>
                                                    @foreach ($iniciativas as $item)
                                                        <option value="{{$item->id}}">{{ $item->idLocalizacao}}</option>
                                                    @endforeach
                                                </select>
                                                @error('idLocalizacao')
                                                    <br>
                                                    <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </p>

                                            <p class="">
                                                <label for="my_input">Bairro<span class="text-danger"></span></label>
                                                <input size="100" class="my_input" type="text"
                                                    name="flow[bairro]"
                                                    wire:model="bairro"
                                                    placeholder="bairro">
                                                @error('bairro')
                                                    <br>
                                                    <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </p>

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer p-1">
                                            <button type="submit" class="border btn-sm btn-success">{{ __('lang.button_update') }}</button>
                                    <button type="button" class="border btn-sm btn-light" wire:click="closeModal">{{ __('lang.button_cancel') }}</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop fade in"></div>
            <div class="fade modal-backdrop show"></div>
        @endif

        <div wire:loading wire:target="closeNewModal, updateIniciativas, " id="loading-indicator">
            <i class="icon-spinner spinner"></i>
            <span>Carregando...</span>
        </div>
    </div>

</div>
