<p>
    <label for="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}" class="float-left">{{ $field }}:</label>
    @if ($format_store['edit_tag_style'] ?? false)
        @if ($format_store['edit_tag_style'] == 'check_box')
            <input type="checkbox" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" value="" id="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}" value="1" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
            <input type="hidden" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" value="0" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>

        @elseif($format_store['edit_tag_style'] == 'radio')
            <span class="bool_cf check_box_group">
                <label><input type="radio" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" value="" checked="checked" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}> (nenhum)</label>
                <label><input type="radio" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" value="1" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}> Sim</label>
                <label><input type="radio" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" value="0" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}> Não</label>
            </span>
        @else
        @endif
    @else
        <select name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" id="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}" class="my_input p-1 select-searchs w-25" style="with:80%" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
            <option {{ $custom_field[0] ? $custom_field[0]['value'] == null ? 'selected="selected"' : null : null }} value=""></option>
            <option {{ $custom_field[0] ? $custom_field[0]['value'] == 1 ? 'selected="selected"' : null : null }} value="1">Sim</option>
            <option {{ $custom_field[0] ? $custom_field[0]['value'] == '0' ? 'selected="selected"' : null : null }} value="0">Não</option>
        </select>
    @endif
</p>
