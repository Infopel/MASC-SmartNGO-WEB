<select name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}]" id="custom_field_values_{{ $custom_field[0]['custom_field_id'] }}"
    class="my_input p-1 select-searchs" style="with:80%" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
    <option value=""></option>
    @foreach ($custom_field as $key => $item)
        @if ($item['is_selected'] ? $item['is_selected'] : false)
            <option value="{{ $item['value'] }}" selected="selected">{{ $item['value'] }}</option>
        @else
            <option value="{{ $item['value'] }}">{{ $item['value'] }}</option>
        @endif
    @endforeach
</select>
