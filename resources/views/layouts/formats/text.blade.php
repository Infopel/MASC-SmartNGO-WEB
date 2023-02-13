<p>
    <label for="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}" class="float-left mt-2"><span>{{ $field }}:</span></label>
    <textarea class="text_cf border mt-2" rows="7"
        name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]"
        placeholder="{{ $field }}"
        value="{{ $custom_field[0] ? $custom_field[0]['value'] : null }}"
        id="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}"
        {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>{{ $custom_field[0] ? $custom_field[0]['value'] : null }}
    </textarea>
</p>

