<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="row">
        <div class="col-md-9 bg-white p-3">
            @if ($isEdit)
                <h5>
                    {{ __('lang.button_edit') }} - <a href="{{ route('issues.show', ['issue' => $issue['id']]) }}">#{{ $issue['id'] }} {{ $issue['subject'] }}</a>
                </h5>
            @else
                <h4>
                {{ __('lang.label_issue_new') }}
                </h4>
            @endif
            <div class="mb-3 mt-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
                <vue-editor class="flex-grow-1 d-none" style="display:none !important" :input_field="'false'" :content="'mucanzer'"></vue-editor>
                <div class="d-flex">
                    <div class="flex-grow-1 text-right">
                        <input name="issue[is_private]" type="hidden" value="0">
                        <label class="inline" for="issue_is_private" id="issue_is_private_label">
                            <input type="checkbox" value="1" name="issue[is_private]" id="issue_is_private" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}}>
                            {{ __('lang.field_is_private') }}
                        </label>
                    </div>
                </div>
                <div class="tabular">
                    <p class="col-md-8">
                        <label for="issues_type" class="float-left">{{ __('lang.field_type') }}<span class="text-danger"> *</span></label>
                        <select name="issue[type]" wire:model="selectd_tracker" class="p-1 border my_input w-50">
                            <option value=""></option>
                            @foreach ($trackers as $tracker)
                                <option value="{{ $tracker['tracker_id'] }}">{{ $tracker['tracker']['name'] }}</option>
                            @endforeach
                        </select>
                    </p>
                    <p class="col-md-8">
                        <label for="name" class="float-left">{{ __('lang.field_title') }}<span class="required"> *</span></label>
                        <input size="60" type="text" value="{{ $issue['subject'] ?? null }}" name="issue[title]" class="border" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}}>
                    </p>

                    @if (in_array('description', $core_fields))
                        <p class="col-md-12 ">
                            <div class="d-flex">
                                <div class="date-tab input-group w-auto">
                                    <div class="">
                                        <label for="project_name" class="float-left">{{ __('lang.field_description') }}<span class="text-danger"> *</span></label>
                                    </div>
                                     <textarea name="issue[description]" id="" cols="100" rows="9" class="border">{{ $issue['description'] ?? null }}</textarea>
                                    {{-- <vue-editor
                                        class="flex-grow-1"
                                        :input_field="'issue[description]'"
                                        :content="'{{ $issue['description'] ?? null }}'">
                                    </vue-editor>--}}
                                </div>
                            </div>
                        </p>
                    @endif

                    <div class="custom-flex">
                        <div class="mr-3" style="min-width:400px">
                            <div class="tabular">
                                <p class="">
                                    <label for="issues_type" class="float-left">{{ __('Data de Início') }}<span class="text-danger"> *</span></label>
                                    <input type="date" name="issue[_start_date]" class="p-1 border my_input w-100" value='{{ $issue['start_date'] ?? null }}' required>
                                </p>
                                <p class="">
                                    <label for="issues_type" class="float-left">{{ __('Data de prevista') }}</label>
                                    <input type="date" name="issue[_due_date]" class="p-1 border my_input w-100" value='{{ $issue['due_date'] ?? null }}'>
                                </p>
                                <p class="">
                                    <label for="issues_type" class="float-left">{{ __('lang.field_status') }}<span class="text-danger"> *</span></label>
                                    <select name="issue[status]" class="p-1 border my_input w-100" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}}>

                                    @if ($default_status)
                                            <option value="{{ $default_status['id'] }}">{{ $default_status['name'] }}</option>
                                        @endif
                                    </select>
                                </p>

                                <p class="">
                                    <label for="issues_type" class="float-left">{{ __('lang.field_priority') }}<span class="text-danger"> *</span></label>
                                    <select name="issue[priority]" class="p-1 border my_input w-100" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}}>
                                        @foreach ($priorities as $priority)
                                            <option
                                                value="{{ $priority['id'] }}"
                                                {{ $priority_id == $priority['id'] ? 'selected' : null }}>{{ $priority['name'] }}</option>
                                        @endforeach
                                    </select>
                                </p>
                                @if (in_array('assigned_to_id', $core_fields))
                                    <p class="">
                                        <label for="issues_type" class="float-left">{{ __('lang.field_assigned_to') }}</label>
                                        <select name="issue[assigned_to]" class="p-1 border my_input w-100">
                                            <option value="{{ auth()->user()->id }}">&lt;&lt; mim &gt;&gt;</option>
                                            @foreach ($user_members as $member)
                                                <option
                                                    value="{{ $member['user']['id'] }}"
                                                    {{ $assigned_to_id == $member['user']['id'] ? 'selected' : null }}>
                                                    {{ $member['user']['firstname'].' '.$member['user']['lastname'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </p>
                                @endif
                            </div>

                            {{-- Campos personalizados --}}
                            @include('layouts.custom_fields_inputs', ['custom_fields' => $tracker_custom_fields ?? [], 'is_desabled' => $issue ? $issue['is_aproved'] ? true : false : null])
                            {{-- / Campos personalizados --}}
                        </div>
                        <div class="">
                            <div class="tabular">
                                @if (in_array('parent_issue_id', $core_fields))
                                    <div class="d-flex">
                                        <div class="date-tab input-group w-auto">
                                            <div class="">
                                                <label for="issues_parent">{{ __('lang.field_parent_issue') }}<span class="required"> *</span></label>
                                            </div>
                                            <input type="hidden" value="" wire:model="parent_id" name="issue[parent_id]" class="border w-100" autocomplete="off">
                                            <input size="60" type="text" value="" wire:model.debounce.500ms="parent" class="border w-100" autocomplete="off" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}}>
                                            @if ($isSearch)
                                                <div class="position-fixed" style="top:0; left:0; right:0; bottom:0" wire:click="reset_search"></div>
                                                <div class="border w-100 p-2 search-result">
                                                    <ul class="list-unstyled">
                                                        <h6 class="dropdown-header pl-2">{{ $parent }}</h6>
                                                        @foreach ($search_parent_results as $key => $parent)
                                                            <li class="dropdown-item cursor-pointer pl-2"
                                                                wire:click="selected_parent('{{ $parent['id'] }}', '{{ $parent['subject'] }}')">
                                                                #{{ $parent['id'] }} - {{ $parent['subject'] }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                    <p>
                                        @if (in_array('start_date', $core_fields))
                                            <div class="d-md-flex">
                                                <div class="d-none date-tab input-group w-auto">
                                                    <div class="">
                                                        <label class="float-left mr-3 mt-2">Início:</label>
                                                    </div>
                                                    <input type="date" class="my_input" name="issue[start_date]" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}} value='{{ $issue['start_date'] ?? null }}'>
                                                </div>
                                            </div>
                                        @endif
                                        @if (in_array('due_date', $core_fields))
                                            <div class="d-flex">
                                                <div class="d-none date-tab input-group w-auto">
                                                    <div class="">
                                                        <label class="float-left mr-3 mt-2">Data prevista:</label>
                                                    </div>
                                                    <input type="date" class="my_input" name="issue[due_date]" value='{{ $issue['due_date'] ?? null }}' {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}}>
                                                </div>
                                            </div>
                                        @endif
                                    </p>

                                @if (in_array('estimated_hours', $core_fields))
                                    <p>
                                        <label for="name" class="float-left">Tempo estimado<span class="required"> *</span></label>
                                        <input size="60" type="text" value="" name="issue[time_tracking]" class="border w-50" {{-- $issue ? $issue['is_aproved'] ? 'disabled="true"' : null : null --}} value='{{ $issue['estimated_hours'] ?? null }}'>
                                    </p>
                                @endif

                                @if (in_array('done_ratio', $core_fields))
                                    <p>
                                        <label for="issue_done_ratio" class="float-left">% Terminado<span class="required"> *</span></label>
                                        <select name="issue[done_ratio]" class="p-1 border my_input w-50">
                                            <option selected="selected" value="0">0 %</option>
                                            <option value="10" {{ $done_ratio == 10 ? 'selected' : null }}>10 %</option>
                                            <option value="20" {{ $done_ratio == 20 ? 'selected' : null }}>20 %</option>
                                            <option value="30" {{ $done_ratio == 30 ? 'selected' : null }}>30 %</option>
                                            <option value="40" {{ $done_ratio == 40 ? 'selected' : null }}>40 %</option>
                                            <option value="50" {{ $done_ratio == 50 ? 'selected' : null }}>50 %</option>
                                            <option value="60" {{ $done_ratio == 60 ? 'selected' : null }}>60 %</option>
                                            <option value="70" {{ $done_ratio == 70 ? 'selected' : null }}>70 %</option>
                                            <option value="80" {{ $done_ratio == 80 ? 'selected' : null }}>80 %</option>
                                            <option value="90" {{ $done_ratio == 90 ? 'selected' : null }}>90 %</option>
                                            <option value="100" {{ $done_ratio == 100  ? 'selected': null }}>100 %</option>
                                        </select>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($isEdit)
                    <div class="col-md-12 mt-3">
                        <fieldset class="border pl-3 pr-3 pt-2">
                            <legend class="text-capitalize w-auto p-0 pl-2 pr-2">Notas</legend>
                            <div class="mb-3">
                                <vue-editor :input_field="'issue[notes]'"></vue-editor>
                            </div>
                        </fieldset>
                    </div>
                @endif
            </div>

            <div class="mb-3">
                @livewire('attachments-form-fields', 'Documentos de suporte')
            </div>

            @isset($selectd_tracker)
            @if ($selectd_tracker != 10)
                <div class="mb-3">
                    <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
                        <div class="">
                            Meta - Beneficiários
                        </div>
                        <div class="tabular">


                            @foreach ($fields_benfHomens_Mulheres as $key => $item)
                                <p class="col-md-11 mt-2">
                                    <label for="" class="float-left">Total de Beneficiários</label>
                                    <input type="text" class="my_input" name="beneficiarios[beneficiarios][ {{ $key }}][num]" placeholder="Fonte de Verificação" input_type="int" value="{{ $item['num'] ?? 0 }}">
                                    <input type="hidden" name="beneficiarios[beneficiarios][ {{ $key }}][_onStorageID]"  value="{{ $item['_onStorageID'] ?? null }}">
                                    <select name="beneficiarios[beneficiarios][ {{ $key }}][faixa_etaria]" class="my_input p-1">

                                        <option value="N/A">Faixa etaria</option>
                                        <option value="N/A" {{ $item['faixa_etaria'] == 'N/A' ? 'selected' : null }}>N/A</option>
                                        <option value="19_25" {{ $item['faixa_etaria'] == '19_25' ? 'selected' : null }}>19 aos 25 Anos</option>
                                        <option value="26_30" {{ $item['faixa_etaria'] == '26_30' ? 'selected' : null }}>26 aos 30 Anos</option>
                                        <option value="31_50" {{ $item['faixa_etaria'] == '31_50' ? 'selected' : null }}>31 aos 50 Anos</option>
                                        <option value="_>50" {{ $item['faixa_etaria'] == '_>50' ? 'selected' : null }}>Maiores de 50 Anos</option>
                                    </select>

                                    {{-- <button type="button"
                                        class="btn p-1 pl-2 pr-2 border-0 bg-success-600"
                                        style="font-size: 93%; margin-top: -3px"
                                        wire:click="add_field_beneficiarios">
                                        <i class="icon-add-to-list"></i>
                                    </button>
                                    @if ($item['_onStorageID'] == null)
                                        <button type="button"
                                            class="btn p-1 pl-2 pr-2"
                                            style="font-size: 95%;  margin-top: -3px"
                                            wire:click="remove_field_beneficiarios({{ $key }})">
                                            <i class="icon-trash-alt text-danger-600"></i>
                                        </button>
                                    @endif --}}
                                </p>
                            @endforeach
                            <hr class="ml-6 mr-6 mt-1 mb-1">


                            @foreach ($fields_benfHomens as $key => $item)
                                <p class="col-md-11 mt-2">
                                    <label for="" class="float-left">Homens</label>
                                    <input type="text" class="my_input" name="beneficiarios[homens][ {{ $key }}][num]" placeholder="Fonte de Verificação" input_type="int" value="{{ $item['num'] ?? 0 }}">

                                        <input type="hidden" name="beneficiarios[homens][ {{ $key }}][_onStorageID]"  value="{{ $item['_onStorageID'] ?? null }}">

                                        <select name="beneficiarios[homens][ {{ $key }}][faixa_etaria]" class="my_input p-1">
                                            <option value="N/A">Faixa etaria</option>
                                            <option value="N/A" {{ $item['faixa_etaria'] == 'N/A' ? 'selected' : null }}>N/A</option>
                                            <option value="19_25" {{ $item['faixa_etaria'] == '19_25' ? 'selected' : null }}>19 aos 25 Anos</option>
                                            <option value="26_30" {{ $item['faixa_etaria'] == '26_30' ? 'selected' : null }}>26 aos 30 Anos</option>
                                            <option value="31_50" {{ $item['faixa_etaria'] == '31_50' ? 'selected' : null }}>31 aos 50 Anos</option>
                                            <option value="_>50" {{ $item['faixa_etaria'] == '_>50' ? 'selected' : null }}>Maiores de 50 Anos</option>
                                        </select>

                                        <button type="button"
                                            class="btn p-1 pl-2 pr-2 border-0 bg-success-600"
                                            style="font-size: 93%; margin-top: -3px"
                                            wire:click="add_field_benfHomens">
                                            <i class="icon-add-to-list"></i>
                                        </button>
                                        @if ($item['_onStorageID'] == null)
                                            <button type="button"
                                                class="btn p-1 pl-2 pr-2"
                                                style="font-size: 95%;  margin-top: -3px"
                                                wire:click="remove_field_benfHomens({{ $key }})">
                                                <i class="icon-trash-alt text-danger-600"></i>
                                            </button>
                                        @endif
                                    </p>
                                @endforeach
                                <hr class="ml-6 mr-6 mt-1 mb-1">
                                @foreach ($fields_benfMulheres as $key => $item)
                                    <p class="col-md-11 mt-2">
                                        <label for="" class="float-left">Mulheres</label>
                                        <input type="text" class="my_input" name="beneficiarios[mulheres][ {{ $key }}][num]" placeholder="Fonte de Verificação" input_type="int" value="{{ $item['num'] ?? 0 }}">

                                        <input type="hidden" name="beneficiarios[mulheres][ {{ $key }}][_onStorageID]"  value="{{ $item['_onStorageID'] ?? null }}">

                                        <select name="beneficiarios[mulheres][ {{ $key }}][faixa_etaria]" class="my_input p-1" >
                                            <option value="N/A">Faixa etaria</option>
                                            <option value="N/A" {{ $item['faixa_etaria'] == 'N/A' ? 'selected' : null }}>N/A</option>
                                            <option value="19_25" {{ $item['faixa_etaria'] == '19_25' ? 'selected' : null }}>19 aos 25 Anos</option>
                                            <option value="26_30" {{ $item['faixa_etaria'] == '26_30' ? 'selected' : null }}>26 aos 30 Anos</option>
                                            <option value="31_50" {{ $item['faixa_etaria'] == '31_50' ? 'selected' : null }}>31 aos 50 Anos</option>
                                            <option value="_>50" {{ $item['faixa_etaria'] == '_>50' ? 'selected' : null }}>Maiores de 50 Anos</option>
                                        </select>

                                        <button type="button"
                                            class="btn p-1 pl-2 pr-2 border-0 bg-success-600"
                                            style="font-size: 93%; margin-top: -3px"
                                            wire:click="add_field_benfMulheres">
                                            <i class="icon-add-to-list"></i>
                                        </button>

                                        @if ($item['_onStorageID'] == null)
                                            <button type="button"
                                                class="btn p-1 pl-2 pr-2"
                                                style="font-size: 95%;  margin-top: -3px"
                                                wire:click="remove_field_benfMulheres({{ $key }})">
                                                <i class="icon-trash-alt text-danger-600"></i>
                                            </button>
                                        @endif
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @livewire('indicators', $issue, $project_parent, $isEdit)
                @endif

            @endisset


            

             <div class="mt-3 pl-3 row">
                <button type="submit" class="btn bg-success-600 btn-sm fw-600 pl-3 pr-3 pt-2 pb-2">
                    <i class="icon-add-to-list"></i>
                    {{ __('lang.button_create') }} {{ $selectd_tracker_name }}
                </button>
            </div>
        </div>

        <div class="col-md-3 bg-secondary">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 border-left aside-panel">
                    <div class="">
                        <h5 class="fw-500">
                            {{ __('Inicadores disponíveis') }}
                        </h5>
                        <div class="border-bottom mb-2 pb-2" style="border-color: #cccccc !important;">
                            <span class="text-black-50">
                                Se um indicador se indifica cam a sua tarefa selecione-o e adicione os dados relacionados.
                                <small><b class="">(This feature) - Development in progress</b></small>
                            </span>
                        </div>
                        <ul class="list-unstyled">
                            {{-- @foreach ($available_indicatores as $key => $indicator)
                                <li class="fw-600 text-capitalize">
                                    <label for="indicador_{{ $indicator['id'] }}" class="inline mb-1">
                                        {{ $indicator['name'] }}
                                        <input class="ml-2" type="checkbox" value="{{ $indicator['id'] }}" name="available_indicators[]" id="indicador_{{ $indicator['id'] }}">
                                    </label>
                                </li>
                            @endforeach --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
