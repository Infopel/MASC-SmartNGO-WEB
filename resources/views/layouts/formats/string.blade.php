<p>
    <label for="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}" class="float-left">{{ $field }}:</label>
    <input size="25" class="my_input" type="text" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]"
        placeholder="{{ $field }}"
        value="{{ $custom_field[0] ? $custom_field[0]['value'] : null }}"
        id="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}"
        cf_type='{{ $field_format }}'
        {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
</p>
