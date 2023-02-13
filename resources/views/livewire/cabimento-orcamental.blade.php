<div style="min-height: 60vh">
    <div class="d-flex bg-light border rounded align-items-baseline p-2 pb-3">
        <div class="flex-grow-1">
            <h5 class="fw-600">Projecto: <span class="text-muted">{{ $project->name }}</span></h5>
            <div class="form-inline">
                <div class="form-group mx-sm-2">
                    <label for="">Pronícias ({{ $project_provincias->count() ?? 0 }})</label>
                    <select name="" class="border p-1" wire:model="provincia">
                        <option value="" selected>Selecione a Provincia</option>
                        @foreach ($project_provincias as $project_provincia)
                            <option value="{{ $project_provincia['value'] }}">{{ $project_provincia['value'] }}</option>
                        @endforeach
                    </select>
                </div>

                @if ($provincia != null)
                    <div class="form-group mx-sm-2">
                        <label for="">Ano</label>
                        <select name="" class="border p-1" wire:model="year">
                            <option value="">Ano</option>
                            <option value="2020">2020</option>
                            {{-- @foreach ($project_linhasEstr as $pde)
                                <option value="{{ $pde['id'] }}">{{ $pde['name'] }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-inline">
            <input type="text" size="5" class="form-control form-control-sm mr-2"  wire:model="year_script" placeholder="Ano" value="{{ $year_script }}">
            <button class="btn btn-sm btn-primary border-top-success-800 shadow-sm" wire:click="runScript()">
                Run Script (Atualizar Despesas)
            </button>
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

    {{-- Section 2 --}}
    <div class="pt-3">
        <div class="table-responsive">
            <table class="table table-sm table-hover table-striped" style="font-size: 93%">
                <thead class="table-active">
                    <th class="fw-600">Tipo de despesa</th>
                    <th class="fw-600 text-nowrap">Orçamento</th>
                    <th class="fw-600">Província</th>
                    <th class="fw-600">Valor Gasto</th>
                    <th>-</th>
                </thead>

                <tbody>
                    @foreach ($despesas as $despesa)
                        <tr>
                            <td class="p-1 pl-2 pr-2">
                                {{ $despesa->budget_tracker->name }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ number_format(($despesa->value),2) }} MZN
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ $despesa->provincia }}
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                {{ number_format((0),2) }} MZN
                            </td>
                            <td class="p-1 pl-2 pr-2">
                                <a href="#" onclick="return;" title="Editar" wire:click="editarOrcamento('{{ $despesa->id }}', '{{ $despesa->budget_tracker->name }}', '{{ $despesa->value }}')">
                                    <i class="icon-pencil5"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    @if ($despesas == [])
                        <tr>
                            <td class="p-1 pl-2 pr-2 text-center" colspan="5">
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
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4 bg-slate-700 rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            {{ __('Atualizar Orçamento') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body mt-0 pt-3">
                        <div class="bg-light border p-2">
                            <h6 class="fw-600">
                                <span class="text-muted">Despesas:</span>
                                <span>{{ $buget_project->budget_tracker->name }}</span>
                            </h6>

                            <div class="form-group mt-2">
                                <label for="input_orcamento">Orçamento</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">MZN</div>
                                    </div>
                                    <input type="text" class="form-control" wire:model="buget_project_value" id="input_orcamento" placeholder="0.00" input_type="float">
                                </div>
                                <small id="emailHelp" class="form-text text-muted">Orçamento atual: <b>{{ number_format(($buget_project->value),2) }} MZN</b>.</small>
                                @error('buget_project_value') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Nota Descritiva</label>
                                <textarea class="form-control" wire:model="buget_project_description" id="description" rows="3"></textarea>
                                <small class="form-text text-muted text-normal">Descrição da atuaização do orçamento.</small>
                                @error('buget_project_description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="">
                                <button class="btn btn-sm btn-primary border-top-success-800 shadow-sm" wire:click="update({{ $buget_project->id }})">
                                   {{ __('lang.button_update')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in" wire:click="closeModal"></div>
        <div class="fade modal-backdrop show" wire:click="closeModal"></div>
    @endif

    <div wire:loading id="loading-indicator" wire:target="editarOrcamento, runScript, provincia, year">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
