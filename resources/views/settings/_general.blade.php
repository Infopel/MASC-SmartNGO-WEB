<form action="">
    @csrf
    <input type="hidden" name="_act" value="general">
    <div class="bg-light p-2">
        <div class="tabular settings">

            <p class="">
                <label for="my_input">{{ __('lang.setting_app_title') }}</label>
                <input size="60" class="my_input @error('role.name') is-invalid @enderror" type="text" name="settings[app_title]" placeholder="{{ __('lang.setting_app_title') }}" value="{{ $data['settings']['app_title'] }}">
            </p>

            <p class="">
                <label for="my_input">{{ __('lang.setting_search_results_per_page') }}</label>
                <input size="7" class="my_input @error('role.name') is-invalid @enderror" type="text" name="settings[search_results_per_page]" placeholder="10" value="{{ $data['settings']['search_results_per_page'] }}">
            </p>

            <p class="">
                <label for="my_input">{{ __('lang.setting_activity_days_default') }}</label>
                <input size="7" class="my_input @error('role.name') is-invalid @enderror" type="text" name="settings[activity_days_default]" placeholder="10" value="{{ $data['settings']['activity_days_default'] }}">
            </p>

            <p class="">
                <label for="my_input">{{ __('lang.setting_host_name') }}</label>
                <input size="40" class="my_input @error('role.name') is-invalid @enderror" type="text" name="settings[host_name]" placeholder="{{ __('lang.setting_host_name') }}" value="{{ $data['settings']['host_name'] }}">
                <em class="info">Exemplo: 127.0.0.1:81/sgmp</em>
            </p>

            <p class="">
                <label for="my_input">{{ __('lang.setting_feeds_limit') }}</label>
                <input size="7" class="my_input @error('role.name') is-invalid @enderror" type="text" name="settings[feeds_limit]" placeholder="10" value="{{ $data['settings']['feeds_limit'] }}">
            </p>
        </div>
    </div>

    <div class="pt-3 pr-2">
        <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __('lang.button_save') }}</button>
    </div>
</form>
