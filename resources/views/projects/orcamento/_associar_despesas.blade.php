<div class="tab-pane fade {{ $tab == 'associar_despesas' ? 'show active' : null }}" id="nav-despeas" role="tabpanel" aria-labelledby="nav-associar_despesas">
    <div class="d-flex mt-2">
        <div class="flex-grow-1">
            <h5 class="text-wrap">
                <span class="text-muted">Rubrica:</span>
                {{ $_rubrica !== null ? $_rubrica['rubrica'].'.'.$_rubrica['name'] : null }}
            </h5>
            <h6 class="fw-600">Orçamento: {{ $_rubrica !== null ? number_format(($_rubrica['orcamento']),2) : null }}</h6>
        </div>
        <div class="">
            <div class="text-lowercase mb-2">
                <a href="#" onclick="return false;" wire:click="showModalAssociarOrcamento()" class="text-success btn btn-light btn-sm border shadow-sm text-nowrap">
                    <i class="icon-plus2"></i>
                    <span>{{ __('Associar Despasas') }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="mt-2">
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
        @endif
    </div>
    <div class="mt-2">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped" style="font-size: 95%">
                <thead class="table-active">
                    <th>#</th>
                    <th>Descrição da despesa</th>
                    <th>Valro Valor base</th>
                    <th>Associado em</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($despesasAssociadas as $index => $item)
                        <tr wire:transition.slide.down>
                            <td class="p-0 pl-2 pr-2">
                                {{ $index +1 }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                {{ $item->budget_tracker->name }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                {{ number_format((0),2) }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                {{ $item->budget_tracker->created_on }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                <a href="#" onclick="return;" class="text-danger ml-2" title="Remover" wire:click="remove_despesa_rubrica({{ $item->id }})">
                                    <i class="icon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    @if ($showModalAssociarOrcamento)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4 bg-slate-700 rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            {{ __('Associar Despesas - Orçamento') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="pl-3 pr-3 pt-2 mb-2">
                        <input type="text" name="username" wire:model="input_despesa" class="border form-control form-control-sm" id="q-username" autocomplete="off">
                        <span>Procurando por: {{ $input_despesa }}</span>
                    </div>

                    <form wire:submit.prevent="associarDepesasRubrica" method="POST">
                        <div class="modal-body mt-0 pt-0">
                            <div class="bg-light border p-2">
                                <div class="despesas">
                                    <div class="objects-selection" style="height:auto; max-height:250px;">
                                        @foreach ($despesas as $despesa)
                                            <label class="mb-0">
                                                {{-- {{ dd(array_column($despesasAssociadas->toArray(), 'id')) }} --}}
                                                @if (in_array($despesa->id, array_column($despesasAssociadas->toArray(), 'id')))
                                                    <input type="checkbox" name="despesas_id[]" checked="checked" wire:model="selected_despesas_ids" value="{{ $despesa->id }}">ABC {{ $despesa->name }}
                                                @else
                                                    <input type="checkbox" name="despesas_id[]" wire:model="selected_despesas_ids" value="{{ $despesa->id }}"> {{ $despesa->name }}
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="bg-light border mt-2 p-2">
                                <div class="roles">
                                    <div class="objects-selection" style="height:auto; max-height:80px;">
                                        @foreach ($provincias as $provincia)
                                            <label class="mb-0">
                                                <input type="checkbox" name="despesas_id[]" wire:model="selected_provincias_ids" value="{{ $provincia }}"> {{ $provincia }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-1">
                            <button type="submit">{{ __('lang.button_add') }}</button>
                            <button type="button" wire:click="closeModal">{{ __('lang.button_cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in" wire:click="closeModal"></div>
        <div class="fade modal-backdrop show" wire:click="closeModal"></div>
    @endif

</div>
