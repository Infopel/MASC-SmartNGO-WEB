<span class="check_box_group mt-2 ">
    @foreach ($custom_field as $key => $item)
        <label class="m-0">
            <input type="checkbox" {{ $item['is_selected'] ? "checked='checked'" : null }}
                name="custom_field_values[{{ $item['custom_field_id'] }}][]" value="{{ $item['value'] }}" {{ $is_desabled ? $is_desabled ? 'disabled="true"' : '' : null }}>
            {{ $item['value'] }}
        </label>
    @endforeach
    <input type="hidden" name="custom_field_values[{{ $custom_field[0]['custom_field_id'] }}][]" value="">
</span>
