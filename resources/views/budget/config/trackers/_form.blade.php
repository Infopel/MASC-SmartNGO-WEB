<div class="col-md-12 border bg-light p-2">
    <div class="tabular col-md-9">
        <p class="">
            <label class="float-left" for="my_input">{{ __('lang.field_name') }} :<span class="text-danger"> *</span></label>
            <input size="50" class="my_input @error('budgetTracker.name') is-invalid @enderror" type="text" name="budgetTracker[name]" placeholder="{{ __('lang.field_name') }}"
                value="{{ $budgetTracker ? $budgetTracker->name : '' }}">

            <br>
            @error('budgetTracker.name')
                <span class="text-danger-600 fw-300" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>

        <p>
            <label for="is_active" class="float-left mb-0">{{ __('lang.field_active') }}</label>
            <label class="block mb-0">
                <input type="hidden" name="budgetTracker[active]" value='0'>
                <input type="checkbox" id='is_active' name="budgetTracker[active]" value="1" {{ $budgetTracker ? $budgetTracker->status == 1 ? 'checked="checked"' : '' : '' }}>
            </label>
        </p>
    </div>
</div>
