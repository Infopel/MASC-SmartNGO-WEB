
<div class="date-tab input-group w-auto">
    <div class="">
        <label for="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}" class="float-left mr-3 mt-2">{{ $field }}:</label>
    </div>
    <input type="text" class="my_input pickadate-year" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]"
        placeholder="{{ $field }}"
        value="{{ $custom_field[0] ? $custom_field[0]['value'] : null }}"
        id="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}"
        {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
</div>
