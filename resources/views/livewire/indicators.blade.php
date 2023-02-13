<div>
    <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size: 90%;">
        <div class="tabular">
            @foreach ($indicator_fields as $key => $indicator)
                @if ($project_parent['type'] == 'Project' || $project_parent['type'] == 'Program')
                {{-- {{ dd($indicator_fields) }} --}}
                    <p class="col-md-9">
                        <label for="issues_parent" class="float-left">Relacionado ao Indicador
                            {{-- <span class="text-danger"> *</span> --}}
                        </label>
                        <select style="min-width: 50%;" name="indicadores[{{ $key }}][parent_id]" class="my_input p-1 border">
                            <option value=""></option>
                            @foreach ($search_parent_indicators_results as $parent_indicators)
                                <option value="{{ $parent_indicators['id'] }}" {{ $indicator['related_to'] == $parent_indicators['id'] ? 'selected' : null }}>
                                    {{ $parent_indicators['id'] }} - {{ $parent_indicators['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </p>
                @endif
               
                <p class="col-md-12">

                    <label for="name" class="float-left">{{ __('Designação') }}
                        {{-- <span class="text-danger"> *</span> --}}
                    </label>
                    <input type="text" class="my_input w-75" name="indicadores[{{ $key }}][name]"
                        placeholder="Nome do indicador" value="{{ $indicator['indicator_name'] ?? null }}">

                    <input type="hidden" name="indicadores[{{ $key }}][indicator_id]" value="{{ $indicator['indicator_id'] ?? null }}">
                    @isset($indicator['indicator_isNew'])
                        <input type="hidden" name="indicadores[{{ $key }}][is_new]" value="{{ $indicator['indicator_isNew'] ? $indicator['indicator_isNew'] ? 1 : 0 : 0 }}">
                    @else
                        <input type="hidden" name="indicadores[{{ $key }}][is_new]" value="1">
                    @endisset


                    <select name="indicadores[{{ $key }}][type]" class="my_input p-1" >
                        @isset($indicator['indicator_type'])
                            <option value="" {{ $indicator['indicator_type'] == null ? 'selected' : null }}>Tipo</option>
                            <option value="1" {{ $indicator['indicator_type'] == '1' ? 'selected' : null }}>Cumulativo </option>
                            <option value="0" {{ $indicator['indicator_type'] == '0' ? 'selected' : null }}>Não Cumulativo</option>
                        @else
                            <option value="">Tipo</option>
                            <option value="1">Cumulativo </option>
                            <option value="0">Não Cumulativo</option>
                        @endisset
                    </select>
                </p>
                <p class="col-md-10">
                    <label for="name" class="float-left">{{ __('Meta') }}
                        {{-- <span class="text-danger"> *</span> --}}
                    </label>
                    <select name="indicadores[{{ $key }}][meta][type]" class="my_input p-1" >
                        @isset($indicator['meta_type'])
                        <option value="">Tipo</option>
                            <option value="text" {{ $indicator['meta_type'] == 'text' ? 'selected' : null }}>Descritiva</option>
                            <option value="decimal" {{ $indicator['meta_type'] == 'decimal' ? 'selected' : null }}>Numérica</option>
                            <option value="percent" {{ $indicator['meta_type'] == 'percent' ? 'selected' : null }}>Percentual</option>
                        @else
                            <option value="text">Descritiva</option>
                            <option value="decimal">Numérica </option>
                            <option value="percent">Percentual</option>
                        @endisset
                    </select>
                    <input type="text" class="my_input w-75" name="indicadores[{{ $key }}][meta][value]" placeholder="Meta" value="{{ $indicator['meta_value'] ?? null }}">
                </p>

                @if ($project_parent['type'] == 'Project')
                    <p>
                        <select wire:key="{{ $key }}" class="my_input p-1" id="selet">
                            <option >Ano 01</option>
                            <option >Trimestre 01</option>
                        </select>
                        <input type="text"  class="my_input" name="indicadores[{{ $key }}][meta][trim_01]" placeholder="Meta" value="{{ $indicator['m_trim_01'] ?? null }}">

                        <select wire:key="{{ $key }}" class="my_input p-1" id="selet">
                            <option value="">Ano 02</option>
                            <option value="">Trimestre 02</option>
                        </select>
                        <input type="text" class="my_input" name="indicadores[{{ $key }}][meta][trim_02]" placeholder="Meta" value="{{ $indicator['m_trim_02'] ?? null }}">
                    </p>
                    <p>
                        <select wire:key="{{ $key }}" class="my_input p-1" id="selet">
                            <option value="">Ano 03</option>
                            <option value="">Trimestre 03</option>
                        </select>
                        <input type="text" class="my_input" name="indicadores[{{ $key }}][meta][trim_03]" placeholder="Meta" value="{{ $indicator['m_trim_03'] ?? null }}">

                        <select wire:key="{{ $key }}" class="my_input p-1" id="selet">
                            <option value="">Ano 04</option>
                            <option value="">Trimestre 04</option>
                        </select>
                        <input type="text" class="my_input" name="indicadores[{{ $key }}][meta][trim_04]" placeholder="Meta" value="{{ $indicator['m_trim_04'] ?? null }}">
                    </p>
                @endif
                <p class="col-md-11 mt-2">
                    <label for="" class="float-left">Fonte de Verificação</label>
                    <input type="text" class="my_input" name="indicadores[{{ $key }}][fonte_ver]" placeholder="Fonte de Verificação" value="{{ $indicator['fonte_ver'] ?? null }}">
                </p>
                <p>
                    <label for="" class="float-left">Base de referência / População</label>
                    <input type="text" class="my_input" name="indicadores[{{ $key }}][base_ref]" placeholder="Base de referência /  População" value="{{ $indicator['base_ref'] ?? null }}">
                </p>
                <p>
                    <label for="" class="mr-2">-</label>
                    <button type="button" class="btn border p-1 pl-2 pr-2 bg-success-600" wire:click="add_indicador_field">
                        <i class="icon-add-to-list"></i>
                    </button>
                    <button type="button" class="btn border p-1 pl-2 pr-2 bg-danger-600" wire:click="remove_indicador_field({{ $key }})">
                        <i class="icon-trash-alt"></i>
                    </button>
                </p>
                <div class="col-md-10 m-auto">
                    <hr class="m-0 mt-2 mb-2">
                </div>
            @endforeach
        </div>
        <input type="hidden" name="deleted_indicators[ids]" value="{{ implode(',', $deleted_indicators) }}">
    </div>

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
