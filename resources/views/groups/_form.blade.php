<div class="col-md-12">
    <fieldset class="mb-3 tabular bg-light border p-3 pt-0">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">{{ __('lang.label_information_plural') }}</legend>
        <div class="col-md-10 form_grupos">
            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.label_group') }} :<span class="text-danger"> *</span></label>
                <input size="25" class="my_input @error('group.name') is-invalid @enderror" type="text" name="group[name]" placeholder="{{ __('lang.label_group') }}" value="{{ $group ? $group['lastname'] : '' }}">
                <br>
                @error('group.name')
                    <span class="text-danger-600 fw-300" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </p>

            <div class="form_grupos">
                {{-- Campos personalizados --}}
                @include('layouts.custom_fields_inputs', ['custom_fields' => $custom_fields])
                {{-- / Campos personalizados --}}
            </div>
        </div>
    </fieldset>
</div>
