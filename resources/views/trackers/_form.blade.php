<div class="tabular">
    <p class="">
        <label for="my_input">{{ __('lang.field_name') }} :<span class="text-danger"> *</span></label>
        <input size="25" class="my_input @error('tracker.name') is-invalid @enderror" type="text" name="tracker[name]" placeholder="{{ __('lang.label_tracker') }}"
            value="{{ $tracker ? $tracker->name : '' }}">
        <br>
        @error('tracker.name')
            <span class="required-feedback text-danger-600 fw-300" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </p>

    <p>
        <label for="my_input">{{ __('lang.field_default_status') }}: <span class="text-danger"> *</span></label>
        <select name="default_status_id" class="my_input p-1 border">
            <option value=""></option>
            @foreach ($issues_status as $issuesStatus)
                <option value="{{ $issuesStatus->id }}" {{ $tracker ? $issuesStatus->id == $tracker->default_status_id ? 'Selected' : '' : '' }}>{{ $issuesStatus->name }}</option>
            @endforeach
        </select>
    </p>

    <p>
        <label for="my_input">{{ __('Fluxo de Aprovacao Associado') }}: <span class="text-danger"></span></label>
        <select name="tagCode" class="my_input p-1 border">
            <option value=""></option>
            @foreach ($aprovement_flows as $aprovement_flow)
                <option value="{{ $aprovement_flow->tagCode }}" {{ $tracker ? $aprovement_flow->tagCode == $tracker->assined_workflow_tag ? 'Selected' : '' : '' }}>{{ $aprovement_flow->title }}</option>
            @endforeach
        </select>
    </p>

    <p>
        <label for="member_management" class="float-left">{{ __('lang.field_is_in_roadmap') }}</label>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
            <input name="tracker[is_in_roadmap]" type="hidden" value="0">
            @if($tracker == [])
                <input type="checkbox" value="1" {{'checked="checked"'}} name="tracker[is_in_roadmap]" id="tracker_is_in_roadmap">
            @else
                <input type="checkbox" value="1" {{ $tracker->is_in_roadmap ? 'checked="checked"' : null }} name="tracker[is_in_roadmap]" id="tracker_is_in_roadmap">
            @endif
        </label>
    </p>

    <p>
        <label class="float-left mb-0">{{ __('lang.field_core_fields') }}</label>
        <input type="hidden" name="tracker[core_fields]" value="">
        <label class="block mb-0">
            @if(in_array('assigned_to_id', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="assigned_to_id" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="assigned_to_id">
            @endif
            Atribuído para
        </label>
        <label class="block mb-0">
            @if(in_array('category_id', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="category_id" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="category_id">
            @endif
            Categoria
        </label>
        <label class="block mb-0">
            @if(in_array('fixed_version_id', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="fixed_version_id" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="fixed_version_id">
            @endif
            Versão
        </label>
        <label class="block mb-0">
            @if(in_array('parent_issue_id', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="parent_issue_id" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="parent_issue_id">
            @endif
            Tarefa pai
        </label>
        <label class="block mb-0">
            @if(in_array('start_date', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="start_date" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="start_date">
            @endif
            Início
        </label>
        <label class="block mb-0">
            @if(in_array('due_date', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="due_date" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="due_date">
            @endif
            Data prevista
        </label>
        <label class="block mb-0">
            @if(in_array('estimated_hours', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="estimated_hours" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="estimated_hours">
            @endif
            Tempo estimado
        </label>
        <label class="block mb-0">
            @if(in_array('done_ratio', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="done_ratio" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="done_ratio">
            @endif
            % Terminado
        </label>
        <label class="block mb-0">
            @if(in_array('description', $tracker->core_fields ?? []))
                <input type="checkbox" name="tracker[core_fields][]" value="description" checked="checked">
            @else
                <input type="checkbox" name="tracker[core_fields][]" value="description">
            @endif
            Descrição
        </label>


    </p>

    @if (sizeof($custom_field_tracker_ids) > 0)
        <p>
            <input type="hidden" name="custom_field_ids">
            <label class="float-left mb-0">{{ __('lang.label_custom_field_plural') }}</label>
            @foreach ($custom_field_tracker_ids as $custom_field)
                <label class="block mb-0">

                    @isset($tracker->custom_fields_trackers)
                        @if(in_array($custom_field->id, array_column($tracker->custom_fields_trackers->toArray(), 'custom_field_id')))
                            <input type="checkbox" name="custom_field_ids[]" Checked='checked' value="{{ $custom_field->id }}">
                            {{ $custom_field->name }}
                        @else
                            <input type="checkbox" name="custom_field_ids[]" value="{{ $custom_field->id }}">
                            {{ $custom_field->name }}
                        @endif
                    @else
                        <input type="checkbox" name="custom_field_ids[]" value="{{ $custom_field->id }}">
                        {{ $custom_field->name }}
                    @endisset


                </label>
            @endforeach
        </p>
    @endif

</div>
