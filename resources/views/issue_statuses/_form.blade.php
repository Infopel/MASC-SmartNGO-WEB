<div class="col-md-12 border bg-light p-2">
    <div class="tabular col-md-7">
        <p class="">
            <label class="float-left" for="my_input">{{ __('lang.label_role') }} :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('issues_status.name') is-invalid @enderror" type="text" name="issues_status[name]" placeholder="{{ __('lang.label_issue_status_new') }}"
                value="{{ $data['issues_status'] ? $data['issues_status']->name : '' }}">

            <br>
            @error('issues_status.name')
                <span class="text-danger-600 fw-300" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>

        <p>
            <label for="issues_status_is_closed" class="float-left mb-0">{{ __('lang.field_is_closed') }}</label>
            <label class="block mb-0">
                <input type="hidden" name="issues_status[is_closed]" value='0'>
                <input type="checkbox" name="issues_status[is_closed]" value="1" {{ $data['issues_status'] ? $data['issues_status']->is_closed == 1 ? 'checked="checked"' : '' : '' }} id="issues_status_is_closed">
            </label>
        </p>
    </div>
</div>
