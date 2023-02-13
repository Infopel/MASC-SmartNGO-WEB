<div class="col-md-12 border bg-light p-2">
    <div class="tabular col-md-7">
        <p class="">
            <label class="float-left" for="my_input">{{ __('lang.field_name') }} :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('enumeration.name') is-invalid @enderror" type="text" name="enumeration[name]" placeholder="{{ __('lang.field_name') }}"
                value="{{ $enumeration ? $enumeration->name : '' }}">

            <br>
            @error('enumeration.name')
                <span class="text-danger-600 fw-300" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>

        <p>
            <label for="is_active" class="float-left mb-0">{{ __('lang.field_active') }}</label>
            <label class="block mb-0">
                <input type="hidden" name="enumeration[active]" value='0'>
                <input type="checkbox" id='is_active' name="enumeration[active]" value="1" {{ $enumeration ? $enumeration->active == 1 ? 'checked="checked"' : '' : '' }}>
            </label>
        </p>

        <p>
            <label for="is_default" class="float-left mb-0">{{ __('lang.field_is_default') }}</label>
            <label class="block mb-0">
                <input type="hidden" name="enumeration[is_default]" value='0'>
                <input type="checkbox" id='is_default' name="enumeration[is_default]" value="1" {{ $enumeration ? $enumeration->is_default == 1 ? 'checked="checked"' : '' : '' }}>
            </label>
        </p>
    </div>
</div>
