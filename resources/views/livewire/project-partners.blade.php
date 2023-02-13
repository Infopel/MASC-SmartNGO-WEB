<div style="min-height: 60vh">
    <div class="d-flex bg-lights align-items-baseline">
        <div class="flex-grow-1">
            <div class="form-inline">
                <div class="form-group mx-sm-2">
                    <label for="" class="fw-600">Parceiros ({{ $project_partners->count() }})</label>
                </div>
            </div>
        </div>
        <div class="">
            <div class="text-lowercase">
                <a href="#" onclick="return false;" wire:click="showModal()" class="text-success btn btn-light btn-sm border shadow-sm">
                    <i class="icon-plus2"></i>
                    <span>{{ __('Cadastrar Parceiros') }}</span>
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
        @elseif(session()->has('removePartner'))
            <div class="alert alert-danger p-2 mb-0">
                {{ __('lang.text_are_you_sure') }}
                <h6>{{ __('lang.button_delete').' '.__('Rubrica') }}: <b>{{ $to_remove_project_partner['partner']['name'] }}</b><h6>
                <div class="text-left">
                    <button type="submit" class="btn btn-sm btn-danger" wire:click="remove_partner_from_project('{{ $to_remove_project_partner['partner']['id'] }}', 1)">SIM TENHO</button>
                </div>
            </div>
        @endif
    </div>

    {{-- Section 2 --}}

    <div class="mt-2">

        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped" style="font-size: 93%">
                <thead class="table-active">
                    <th class="fw-600">ID</th>
                    <th class="fw-600">Parceiros</th>
                    <th class="fw-600">Tipo</th>
                    <th class="fw-600">Parceiro a</th>
                    <th></th>
                </thead>

                <tbody class="border-bottom">
                    @foreach ($project_partners as $project_partner)
                        <tr>
                            <td class="p-0 pl-2 pr-2">
                                {{ $project_partner->partner['id'] }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                {{ $project_partner->partner['name'] }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                {{ $project_partner['type'] }}
                            </td>
                            <td class="p-0 pl-2 pr-2">
                                {{ \Carbon\Carbon::parse($project_partner['partner']['start_date'])->diffForHumans() }}
                            </td>
                            <td class="p-0 pb-1 pl-2 pr-2">
                                <a href="#" onclick="return;" title="Remover Parceiro" wire:click="remove_partner_from_project('{{ $project_partner['partner']['id'] }}', {{ false }})" class="text-danger">
                                    <i class="icon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if ($project_partners->count() <= 0)
                        <tr>
                            <td class="text-center" colspan="5">
                                {{ __('lang.label_no_data') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if ($showModal)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4 bg-slate-700 rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            {{ __('Parceiros') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="pl-3 pr-3 pt-2 mb-2">
                        <input type="text" name="username" wire:model="input_partner" class="border form-control form-control-sm" id="q-username" autocomplete="off">
                        <span>Procurando por: {{ $input_partner }}</span>
                    </div>

                    <form wire:submit.prevent="store_project_partner" method="POST">
                        <div class="pl-3 pr-3 pt-2 mb-2">
                            <label for="my_input" class="float-left">{{ __("Tipo de Parceria") }}<span class="text-danger"> *</span></label>
                            <select name="partner[type_fund]" class="border p-1 ml-3" wire:model="type">
                                <option value=""></option>
                                <option value="Doador" >Doador</option>
                                <option value="Subvencao">Subvencao</option>
                                <option value="Join Venture">Join Venture</option>
                            </select>
                        </div>
                        <div class="modal-body mt-0 pt-0">
                            
                            <div class="bg-light border p-2">
                                <div class="partners">
                                    <div class="objects-selection" style="height:auto; max-height:250px;">
                                        @foreach ($partners as $partner)
                                            <label class="mb-0">
                                                <input type="checkbox" name="despesas_id[]" wire:model="selected_partners_ids" value="{{ $partner['id'] }}"> {{ $partner['name'] }}
                                            </label>
                                        @endforeach

                                        @if ($partners->count() < 1)
                                            <span class="text-center">{{ __('lang.label_no_data') }}</span>
                                        @endif
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

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
