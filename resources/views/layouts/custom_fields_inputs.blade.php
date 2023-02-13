{{-- Campos personalizados --}}
@foreach($custom_fields as $key => $custom_field)
    @if($custom_field['field_format'] == 'list')
        <p>
            <label for="{{ $key }}" class="float-left">{{ $key }}</label>

            @if ($custom_field['multiple'])
                @include('layouts.formats.mult_check', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store']])
            @else
                @include('layouts.formats.select', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store']])
            @endif
        </p>
    @elseif($custom_field['field_format'] == 'text')
        @include('layouts.formats.text', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store']])
    @elseif($custom_field['field_format'] == 'date')
        @include('layouts.formats.date', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store']])
    @elseif($custom_field['field_format'] == 'attachment')
        @livewire('attachments-form-fields', 'Documentos & Ficheiros', key(auth()->user()->id))
        {{-- @include('layouts.formats.file', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store']]) --}}
    @elseif($custom_field['field_format'] == 'bool')
        @include('layouts.formats.bool', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store']])
    @else
        @include('layouts.formats.string', ['custom_field' => $custom_field['values'], 'field' => $key, 'format_store' => $custom_field['format_store'], 'field_format' => $custom_field['field_format']])
    @endif
@endforeach
{{-- / Campos personalizados --}}


