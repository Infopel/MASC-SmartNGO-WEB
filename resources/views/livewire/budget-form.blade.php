<div>
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 bg-white p-3">
                    <div class="d-md-flex">
                        <div class="order-md-2 mb-2">
                        </div>
                        <div class="order-md-1 flex-grow-1">
                            <h5>
                                <i class="icon-coins"></i>
                                <span>Novo: {{ __('lang.label_finance') }}</span> »
                                <span class="text-wrap">
                                    <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">{{ $budget_to['name'] }}</a>
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="">
                        <form action="{{ $request_url }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            <div class="row m-0 bg-light pt-2 pb-2 mb-3">
                                <div class="col-md-7">
                                    <fieldset class="">
                                        <legend class="border-bottom text-bold text-capitalize text-black-50">
                                            <i class="icon-info3" style="font-size:95%"></i>
                                            {{ __('lang.field_description') }}
                                        </legend>

                                        @if ($issue->project->has_shared_budget)
                                            <div class="d-flex col-md-12 p-0 mb-2">
                                                <div class="input-group w-auto col-md-12 p-0">
                                                    <div class="">
                                                        <label for="_project">{{ __('lang.label_project') }}<span class="required"> *</span></label>
                                                    </div>

                                                    <div class="input-group input-group-sm mr-sm-0">
                                                        <div class="input-group-prepend bg-white">
                                                            <div class="input-group-text bg-white rounded-0 border-right-0">
                                                                <i wire:loading.class="d-none" wire:target="search_project" class="icon-search4 mr-0" style="font-size: 96%"></i>
                                                                <i wire:loading wire:target="search_project" class="icon-spinner2 spinner mr-0" style="font-size: 96%"></i>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="" wire:model="selected_project_id" name="project_id" class="border w-100" autocomplete="off">
                                                        <input type="search" name="search[rubrica]" wire:model.debounce.500ms="search_project" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar e selecionar Projecto" autocomplete="off">
                                                    </div>

                                                    <em class="info">Você pode pesquisar e selecionar o projecto nessa caixa de texto</em>

                                                    @if ($isSearch)
                                                        <div class="position-fixed" style="top:0; left:0; right:0; bottom:0" wire:click="reset_search"></div>
                                                        <div class="border w-100 p-2 pb-0 search-result col-md-12" style="max-width: inherit;">
                                                            <ul class="list-unstyled pb-0 mb-1 mt-0">
                                                                <span class="dropdown-header pl-2 mt-0 text-capitalize">
                                                                    Resultados da pesquisa por: <span class="text-uppercase text-success">{{ $search_project }}</span>
                                                                </span>
                                                                @forelse ($projects as $key => $project)
                                                                    <li class="dropdown-item cursor-pointer pl-2"
                                                                        wire:click="select_project('{{ $project['id'] }}', '{{ $project['identifier'] }}')">
                                                                        #{{ $project['id'] }} - {{ $project['name'] }}
                                                                    </li>
                                                                @empty
                                                                    <li class="cursor-pointer pl-2">Ups! Nenhum resultado encontrado...</li>
                                                                @endforelse
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-md-12 p-0">
                                            <div class="d-flex">
                                                <div class="mr-15">
                                                    <select name="" id="" class="my_input p-1 col-md-12 w-auto" wire:model="selected_year">
                                                        @forelse ($years as $item)
                                                            <option value="{{ $item['year'] }}">{{ $item['year'] }}</option>
                                                        @empty
                                                            <option value="{{ $item['year'] }}">2022</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="form-group mb-2 col-md-12 p-0">
                                                        <label for="" class="sr-only">Rubricas</label>
                                                        <select name="" id="" class="my_input p-1 col-md-12 flex-grow-1" wire:model="selected_tracker">
                                                            <option value=""> -- Rubrica --</option>
                                                            @foreach ($budgetTrackers as $budgetTracker)
                                                                <option value="{{ $budgetTracker->id }}">
                                                                    {{ $budgetTracker->rubrica }}.{{ $budgetTracker->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex">
                                                <div class="form-group p-0 mb-2 ml-0 mr-2">
                                                    <input type="text" size="15" wire:model="price" class="my_input" placeholder="Valor" input_type="float">
                                                </div>
                                                <button type="button" class="btn btn-sm btn-primary mb-2" wire:click="add_budget()" {{ $price && $selected_tracker!= null ? null : 'disabled="disabled"' }}>
                                                    <i class="icon-plus2"></i>
                                                        Adicionar
                                                </button>
                                            </div>
                                        </div>

                                        @if ($addRubricaWarning !== null)
                                            <div class="alert-warning text-warning p-2 mb-2 rounded">{{ $addRubricaWarning }}</div>
                                        @endif
                                        <div class="content-body-form p-2  bg-white">
                                            <div class="table-responsive my-shadow">
                                                <table class="table table-bordere table-sm table-hover border table-striped">
                                                    <thead class="">
                                                        <th class="fw-600">
                                                            {{ __('lang.field_description') }}
                                                        </th>
                                                        <th class="text-center fw-600">
                                                            Quanidate
                                                        </th>
                                                        <th class="fw-600">
                                                            Valor / C.Unit
                                                        </th>
                                                        <th class="fw-600">
                                                            Sub-Total
                                                        </th>
                                                        <th style="width: 50px"></th>
                                                    </thead>

                                                    <tbody>
                                                        @foreach ($selected_budget_details as $key => $item)
                                                            <tr wire:transition.slide.down>
                                                                <td class="p-0 pl-2 pr-2">
                                                                    <input type="hidden" name="budget[{{ $key }}][project_id]" value="{{ $selected_project_id }}">
                                                                    <input type="hidden" name="budget[{{ $key }}][id]" value="{{ $item['tracker_id'] }}">
                                                                    {{ $item['tracker_name'] }}
                                                                </td>
                                                                <td class="p-0 pl-2 pr-2 text-center">
                                                                    <input type="hidden" name="budget[{{ $key }}][quantity]" value="{{ $item['Qtd'] }}">
                                                                    {{ $item['Qtd'] ?? "N/A" }}
                                                                </td>
                                                                <td class="p-0 pl-2 pr-2">
                                                                    <input type="hidden" name="budget[{{ $key }}][value]" value="{{ $item['price'] }}">
                                                                    {{ number_format(($item['price']),2) }}
                                                                </td>
                                                                <td class="p-0 pl-2 pr-2">
                                                                    <input type="hidden" name="budget[{{ $key }}][sub_total]" value="{{ $item['Qtd'] }}">
                                                                    {{ number_format(($item['sub_total']),2) }}
                                                                </td>
                                                                <td class="p-0 pl-2 pr-2">
                                                                    <button type="button" class="btn btn-sm" wire:click="remove_budget('{{ $key }}', '{{ $item['tracker_id'] }}')">
                                                                        <i class="icon-trash text-danger"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @if ($selected_budget_details == [])
                                                            <tr wire:transition.slide.down>
                                                                <td colspan="5" class="text-center">
                                                                    {{ __('lang.label_no_data') }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>

                                                <table class="table table-inbox border table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3" class="text-right">
                                                                <span class="fw-600">Orcamento Total</span>
                                                            </td>
                                                            <td colspan="2" class="text-right">
                                                                <span class="fw-600">
                                                                    {{ number_format((collect($selected_budget_details)->sum('price')),2) }} MT
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </fieldset>
                                    @livewire('attachments-form-fields', 'Documentos de suporte')
                                    <hr>
                                    <div class="mt-4">
                                        <h5 class="text-black-50">Comentário</h5>
                                        <vue-editor :input_field="'budget_notes'" :content="'{{ $notes }}'"></vue-editor>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <fieldset class="tabular">
                                        <legend class="border-bottom text-bold text-capitalize text-black-50">
                                            <i class="icon-info3" style="font-size:95%"></i>
                                            Novo orcamento
                                        </legend>
                                        <p>
                                            <label for="my_input" class="text-danger">Criar para<span class="text-danger"> *</span></label>
                                            <select name="orcamento[budget_to]" class="w-75 p-1 my_input" wire:model="orcamentar_para" readonly="readonly" tabindex="-1" aria-disabled="true">
                                                <option value=""></option>
                                                <option value="project">Projecto</option>
                                                <option value="issue">Actividade</option>
                                            </select>
                                        </p>
                                        <p class="">
                                            <label for="my_input">Emitido em: </label>
                                            <input type="date" size="25" name="orcamento[issued_at]" wire:model="issued_at" class="my_input" placeholder="01/01/2019" required>
                                        </p>

                                        @foreach ($available_custom_fields_values as $key => $item)
                                            <p>
                                                <label for="">
                                                    <span></span>
                                                    {{ $key }}
                                                </label>
                                                <select name="budget_issue_custom_field_values[{{ $key }}]" wire:model="{{ strtolower($key).'a' }}" class="w-75 p-1 my_input">
                                                    @foreach ($available_custom_fields_values[$key] as $custom_value)
                                                        <option value="{{ $custom_value['value'] }}">
                                                            {{ $custom_value['value'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </p>
                                        @endforeach

                                        <p class="" id="partners">
                                            <label for="my_input">{{ __('lang.label_partner') }}: </label>
                                            <select name="orcamento[partner]" class="w-75 p-1 my_input">
                                                <option value=""> --- Selecione o Parceiro --- </option>
                                                @foreach ($partners as $partner)
                                                    <option value="{{ $partner->partner_id }}">
                                                        {{ $partner->partner->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </p>
                                    </fieldset>
                                </div>
                            </div>

                            @if ($is_edit)
                                <div class="">
                                    <input type="hidden" name="request_type" value="update">
                                    <button type="submit" class="btn btn-primary pt-1 pb-1">Atualizar Orçamento</button>
                                </div>
                            @else
                                <div class="">
                                    <input type="hidden" name="request_type" value="store">
                                    <button type="submit" class="btn btn-primary pt-1 pb-1">Propor orçamento</button>
                                </div>
                            @endif
                            <input type="hidden" name="orcamento[reference_id]" value="{{ $budget_to['id'] }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div wire:loading id="loading-indicator" wire:target="add_budget">
            <i class="icon-spinner spinner"></i>
            <span>Carregando...</span>
        </div>
        <div wire:loading id="loading-indicator" wire:target="remove_budget">
            <i class="icon-spinner spinner"></i>
            <span>Removendo Despesa...</span>
        </div>
    </div>

    @section('scripts')
       <script>
           function addInputFiles(inputEl) {
                var attachmentsFields = $(inputEl).closest('.attachments_form').find('.attachments_fields');
                var addAttachment = $(inputEl).closest('.attachments_form').find('.add_attachment');
                var clearedFileInput = $(inputEl).clone().val('');
                var sizeExceeded = false;
                var param = $(inputEl).data('param');
                if (!param) { param = 'attachments' };
                sizeExceeded = uploadAndAttachFiles(inputEl.files, inputEl);
                if(sizeExceeded){
                    $(inputEl).remove();
                    clearedFileInput.prependTo(addAttachment);
                }
            }
            function uploadAndAttachFiles(files, inputEl) {
                // var maxFileSize = $(inputEl).data('max-file-size');
                var maxFileSize = 5242880;
                var maxFileSizeExceeded = $(inputEl).data('max-file-size-message');
                var sizeExceeded = false;
                $.each(files, function () {
                    if (this.size && maxFileSize != null && this.size > parseInt(maxFileSize)) { sizeExceeded = true; }
                });
                if (sizeExceeded) {
                    window.alert(maxFileSizeExceeded);
                }
                return sizeExceeded;
            }
        </script>
    @endsection

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
