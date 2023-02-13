<div class="bg-light p-2">
    <div class="tabular col-lg-7">
        <p class="">
            <label for="my_input">{{ __('lang.label_role') }} :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('role.name') is-invalid @enderror" type="text" name="" placeholder="{{ __('lang.label_role') }}" value="">
            <br>
            @error('role.name')
                <span class="required-feedback text-danger-600 fw-300" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>
    </div>
</div>
