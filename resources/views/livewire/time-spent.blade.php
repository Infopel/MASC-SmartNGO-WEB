<div>
    <div class="main-content mt-2">
        <div class="row m-0 flex-grow-1 pt-4 bg-white">
            <div class="mb-3 setp-container step-info-content d-flex justify-content-center w-100">
                <div class="col-md-9 p-0">
                    <div class="header-content mb-2">
                        @if ($issue != null)
                            <h5>
                                <a href="{{ route('time_entries.issues', ['issue' => $issue->id]) }}">
                                    {{ __("lang.label_spent_time") }}
                                </a> » Actividade »
                                <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">{{ $issue->subject }}</a>
                            </h5>
                        @endif
                    </div>

                    @if ($isEdit)
                    <form action="{{ route('time_entries.issues.update', ['issue' => $issue->id, 'time_entrie' => $time_entrie->id]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                    @else
                    <form action="{{ route('time_entries.issues.store', ['issue' => $selected_issue_id ?? 0]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                    @endif

                        @csrf

                        <div class="border col-12 pt-3 pl-4 pr-4 pb-4 bg-white my-shadow">
                            <div class="p-0 border-bottom mb-3">
                                <h5>Informações Base</h5>
                            </div>

                            <div class="form-group mb-2">
                                <div class="">
                                    <label for="issues_parent">
                                        {{ __('lang.label_issue') }}
                                        <span class="text-danger"> *</span>
                                    </label>
                                </div>
                                <input name="issue[id]" type="hidden" class="my_input w-100 pl-2 pr-2" wire:model="selected_issue_id" autocomplete="off"/>
                                <input name="issue[subject]" id="issue_subject" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1" wire:model="search_issues_input" autocomplete="off" required {{ $isEdit ? 'disabled' : null }}/>
                                @if ($is_search)
                                    <div class="position-fixed" style="top:0; left:0; right:0; bottom:0" wire:click="reset_search"></div>
                                    <div class="bg-white border search-result shadow-sm w-100 p-1" style="max-width: 100% !important"  wire:transition.slide.down>
                                        <ul class="list-unstyled m-0" style="max-height: 300px; overflow-y:auto">
                                            @if ($search_issues_result->count() > 0)
                                            @foreach ($search_issues_result as $issue)
                                                <li class="dropdown-item cursor-pointer pl-3 rounded text-truncate" wire:click="selected_issue('{{ $issue->id }}', '{{ $issue->subject }}')" >
                                                    {{ $issue->subject }}
                                                </li>
                                            @endforeach
                                            @else
                                                <h6 class="dropdown-header pl-2 m-0">{{ __('lang.label_no_data') }}</h6>
                                            @endif
                                        </ul>
                                        <div class="align-content-center bg-light border-top d-flex justify-content-end pb-1 pl-2 pr-2 pt-1">
                                            <small class>({{ $search_issues_result->count() }}) - Resultados encontrados</small>
                                        </div>
                                    </div>
                                @endif
                                
                            </div>

                            <div class="form-group mb-2">
                                <div class="">
                                    <label for="issues_parent">
                                        {{ __('Objectivo da Actividade') }}
                                        <span class="text-danger"> *</span>
                                    </label>
                                </div>

                                <input name="issue[description]" id="issue_subject" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1" autocomplete="off" value="{{ $issue->description }}" {{ $isEdit ? 'disabled' : null }}/>
                            </div>

                            
                            @if ($reportType == 'actividades')

                                <div class="form-group">
                                    <div class="row m-0 pt-2">
                                        <div class="mr-3">
                                            <div class="">
                                                <label for="" class="">{{ __('lang.field_start_date') }} da actividade
                                                    <span class="text-danger"> *</span>
                                                </label>
                                            </div>
                                            <input name="timelog[start_date]" type="date" type="date" class="my_input pl-2" autocomplete="off" value="{{ $issue->start_date }}" required disabled/>
                                        </div>
                                        <div class="mr-3">
                                            <div class="">
                                                <label for="issues_parent" class="">{{ __('lang.field_due_date') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            </div>
                                            <input
                                                name="timelog[due_date]"
                                                type="date"
                                                class="my_input pl-2"
                                                autocomplete="off"
                                                value={{ $isEdit ? $time_entrie->created_on : date('Y-m-d') }} required
                                            />
                                        </div>
                                        <div class="">
                                            <div class="">
                                                <label for="issues_parent" class="">{{ __('lang.field_hours') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            </div>
                                            <input type="text" name="timelog[hours]" input_type="int" col="15" class="border p-1" required value={{ $isEdit ? $time_entrie->hours : null }}>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted mt-0 mb-1">Inidique as datas (Obrigatório)</small>
                                </div>

                                @if ($issue->tracker_id != 10)

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('QUEM GOSTARIA DE INFORMAR/INFLUENCIAR') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[peoople_to_inform]" value="{{ $isEdit ? $time_entrie->peoople_to_inform : null }}" id="issue_peoople_to_inform" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('TIPO DE EVIDÊNCIA QUE APRESENTOU') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[evidence_type]" value="{{ $isEdit ? $time_entrie->evidence_type : null }}" id="issue_evidence_type" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('QUAISQUER MEIOS DE VERIFICAÇÃO') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[verification_type]" value="{{ $isEdit ? $time_entrie->verification_type : null }}" id="issue_verification_type" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('DESCREVA COMO FOI O ENCONTRO') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[metting_descrption]" value="{{ $isEdit ? $time_entrie->metting_descrption : null }}" id="issue_metting_descrption" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('QUAL FOI O RESULTADO IMEDIATO?') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[metting_result]" value="{{ $isEdit ? $time_entrie->metting_result : null }}" id="issue_metting_result" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('DESAFIOS ENFRENTADOS E LIÇÕES APRENDIDAS') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[challenge_lessons]" value="{{ $isEdit ? $time_entrie->challenge_lessons : null }}" id="issue_challenge_lessons" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('SEGUIMENTO DA ACTIVIDADE (PRÓXIMOS PASSOS)') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <input name="timelog[falloup]" value="{{ $isEdit ? $time_entrie->falloup : null }}" id="issue_falloup" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>

                                    <div class="form-group mb-2">
                                        <div class="">
                                            <label for="issues_parent">
                                                {{ __('ALGUMA CONTRIBUIÇÃO ESPERADA DO MASC?') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                        </div>                                
                                        <input name="timelog[masc_contribuition]" value="{{ $isEdit ? $time_entrie->masc_contribuition : null }}" id="issue_masc_contribuition" col="20" class="my_input w-100 pl-2 pr-2 pb-1 pt-1"  autocomplete="off" required {{-- $isEdit ? 'disabled' : null --}}/>
                                    </div>
                                    
                                    
                                @endif
                                <div class="form-group mb-2">
                                    <div class="">
                                        <label for="timelog_comments" class="float-left">
                                            {{ __('lang.field_comments') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                    </div>
                                    <textarea rows="5" name="timelog[comments]" id="question_possible_values" id="timelog_comments" class="border w-100" style="resize:none" required>{{ $isEdit ? $time_entrie->comments : null }}</textarea>
                                </div>

                               {{--<div class="form-group">
                                    <div class="">
                                        <label for="activities" class="m-0">
                                            {{ __('lang.field_activity') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <small class="form-text text-muted mt-0 mb-1">Por favor selecione a categoria do reporte (Obrigatório)</small>
                                    </div>
                                    <select name="timelog[activity_id]" id="" class="border p-1" required>
                                        <option value="">--- Por favor, selecione ---</option>
                                        @foreach ($activities as $activity)
                                            <option value="{{ $activity->id }}" {{ $isEdit ? $time_entrie->activity_id == $activity->id ? 'selected' : null : null }}>{{ $activity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>--}} 
                            </div>
                        @endif

                        @if($reportType == 'actividades')

                            <div class="mt-3 border col-12 pt-3 pl-4 pr-4 pb-4 bg-white my-shadow">
                                <div class="p-0 border-bottom mb-3">
                                    <h5>Reporte da activdade</h5>
                                </div>

                                <div class="">
                                    @foreach ($indicators as $key => $indicador)
                                        <div class="mb-3 mt-3 d-block">
                                            <div class="">
                                                <label for="id:fKey:{{ $key }}" class="w-full fw-500 text-slate-800"><span class="font-bold mr-1">{{ ++$key }}.</span>{{ $indicador['indicator_field']['name'] }}</label>
                                            </div>

                                            @if ($indicador['indicator_field']['indicator_issue_values']['meta_type'] == 'text')
                                                <textarea
                                                    name="indicator_achives[{{ $indicador['id'] }}]"
                                                    id="id:fKey:{{ $key-1 }}"
                                                    cols="4"
                                                    class="my_input w-100 p-2">{{ $isEdit ? $time_entrie->time_entries_values()->where('customized_id', $indicador['id'])->first()->value : null }}</textarea>
                                            @else
                                                <input
                                                    type="text"
                                                    name="indicator_achives[{{ $indicador['id'] }}]"
                                                    class="w-100 my_input p-2"
                                                    placeholder="Indique o resultado alcançado"
                                                    value={{ $isEdit ? $time_entrie->time_entries_values()->where('customized_id', $indicador['id'])->first()['value'] : null }}
                                                    >
                                            @endif

                                            <div class="small text-black-50">
                                                Meta: <b>{{ $indicador['indicator_field']['indicator_issue_values']['meta'] }}</b> | Tipo de Meta: <b>{{ $indicador['indicator_field']['indicator_issue_values']['meta_type'] == 'text' ? "Descritiva" : "Numerica" }}</b> | Cumulativo: <b>{{ $indicador['indicator_field']['is_cumulative'] == true ? "Sim" : "Não"}}</b>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if ($indicators == [])
                                        <li>{{ __('lang.label_no_data') }}</li>
                                    @endif
                                </div>
                                <div class="mt-3 pt-2 border-top">
                                    @if ($isEdit)
                                        <button type="submit" class="btn shadow-sm border-bottom-primary bg-primary cursor-pointer"
                                            name="indicator_store_action" value="1">
                                            Atualizar
                                        </button>
                                    @else
                                        <button type="submit" class="btn shadow-sm border btn-primary cursor-pointer"
                                            name="indicator_store_action" value="1">
                                            {{ __('Salvar e fechar') }}
                                        </button>
                                    @endif
                                </div>
                            </div>

                        @elseif ($reportType == 'financeiro')
                        <div class="mt-3 border col-12 pt-3 pl-4 pr-4 pb-4 bg-white my-shadow">
                            <div class="p-0 border-bottom mb-3">
                                <h5>Reporte financeiro</h5>
                            </div>

                            <div class="mt-4">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover table-striped" style="font-size: 90%">
                                        <thead class="table-active">
                                            <th class="fw-600">Descrição - Despsa</th>
                                            <th class="fw-600">Orçamento Previsto</th>
                                            <th class="fw-600">Orçamento Realizado</th>
                                        </thead>

                                        <tbody>
                                            @foreach ($despesas as $key => $despesa)
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="report_financeiro[{{ $key }}][buget_value_id]" value="
                                                        {{ $despesa['id'] }}">
                                                        {{ $despesa['rubrica']['name'] }}
                                                    </td>
                                                    <td>
                                                        {{ number_format(((float)$despesa['issued_value'] ?? 0),2) }} MZN
                                                    </td>
                                                    <td>
                                                        <input type="text" class="my_input" name="report_financeiro[{{ $key }}][value]" value="0.00" input_type="float">
                                                        MTN
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <small class="form-text text-muted mt-2 mb-1">
                                        Note: Os valores devem ser inserido da seguinte forma: 140000.59 = 140,000.59
                                    </small>
                                </div>

                                <div class="multiple_file_upload_row">
                                    <p class="mt-2 border-top pt-2">
                                        <label class="float-left mr-3">Ficheiros</label>
                                        <span class="attachments_form">
                                            <span class="attachments_fields">
                                            </span>
                                            <span class="add_attachment" style="">
                                                <input type="file" name="attachments[0][file]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (195 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                (Tamanho máximo: 195 MB)
                                            </span>
                                        </span>
                                    </p>
                                    @foreach ($file_forms as $key => $item)
                                        <p class="mt-2 border-top pt-2">
                                            <label class="float-left mr-3">Ficheiros</label>
                                            <span class="attachments_form">
                                                <span class="attachments_fields">
                                                </span>
                                                <span class="add_attachment" style="">
                                                    <input type="file" name="attachments[{{ $item['index'] }}][file]" class="file_selector filedrop" multiple="multiple" onchange="addInputFiles(this);" data-max-file-size="204800000" data-max-file-size-message="Este ficheiro não pode ser carregado pois excede o tamanho máximo permitido por ficheiro (195 MB)" data-max-concurrent-uploads="2" data-upload-path="/uploads.js" data-param="attachments" data-description="true" data-description-placeholder="Descrição opcional">
                                                    (Tamanho máximo: 195 MB)
                                                </span>
                                            </span>
                                            <button type="button" class="btn btn-sm border-0 btn-light" wire:click="remove_file_forms({{ $key, $item['index']}})" title="Remover">
                                                <i class="icon-trash text-danger"></i>
                                            </button>
                                        </p>
                                    @endforeach

                                    <button type="button" class="btn btn-sm border btn-light" wire:click="add_file_forms(0)">
                                        <i class="icon-plus2"></i>
                                        Add Ficheiro
                                    </button>
                                </div>

                                <div class="mt-4 pt-2 border-top">
                                    <button type="submit" class="btn bg-light text-dark fw-500 border border-bottom-danger  cursor-pointer"
                                            name="action_finace_report" value="1">
                                        <i class="icon-coins"></i>
                                        Submeter reporte financeiro
                                    </button>
                                </div>
                            </div>
                        </div>

                        @endif
                    </form>
                </div>
            </div>
        </div>
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
        var maxFileSize = 204800000;
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
