<div class="col-md-12">
    <fieldset class="mb-2 tabular bg-light border p-2 pt-0">
        <legend class="pl-2 pr-1 p-0 m-0 w-auto text-capitalize">{{ __('Categoria') }}</legend>

        <div class="col-md-10 form_grupos">
            <p class="">
                <label for="my_input" class="float-left">{{ __('lang.field_name') }}<span class="text-danger"> *</span></label>
                <input size="25" class="my_input @error('partner.name') is-invalid @enderror" type="text" name="questionnaireCategory[name]" placeholder="{{ __('lang.label_partner_name') }}" value="{{ $questionnaireCategory ? $questionnaireCategory['name'] : '' }}">
                <br>
                @error('questionnaireCategory.name')
                    <span class="text-danger-600 fw-300" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </p>

            <p>
            <label for="is_active" class="float-left mb-0">{{ __('lang.field_active') }}</label>
            <label class="block mb-0">
                <input type="hidden" name="questionnaireCategory[active]" value='0'>
                <input type="checkbox" id='is_active' name="questionnaireCategory[active]" value="1" {{ $questionnaireCategory ? $questionnaireCategory->active == 1 ? 'checked="checked"' : '' : '' }}>
            </label>
        </p>
        </div>

    </fieldset>
</div>
