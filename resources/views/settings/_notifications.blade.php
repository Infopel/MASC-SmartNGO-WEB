<form action="">
    @csrf
    <input type="hidden" name="_act" value="general">
    <div class="bg-light p-2 mb-3">
        <div class="tabular settings">

            <p class="">
                <label for="my_input">{{ __('lang.setting_mail_from') }}</label>
                <input size="60" class="my_input @error('role.name') is-invalid @enderror" type="text" name="settings[mail_from]" placeholder="{{ __('lang.setting_app_title') }}" value="{{ $data['settings']['mail_from'] }}">
            </p>

            <p>
                <label for="bcc_recipients" class="">{{ __('lang.setting_bcc_recipients') }}</label>
                <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
                    <input name="settings[bcc_recipients]" type="hidden" value="0">
                    <input style="margin:0px !important" id="bcc_recipients" type="checkbox" name="settings[bcc_recipients]" value="1" {{ $data['settings']['bcc_recipients'] == '1' ? 'checked' : '' }}>
                </label>
            </p>

            <p>
                <label for="plain_text_mail" class="">{{ __('lang.setting_plain_text_mail') }}</label>
                <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
                    <input name="settings[plain_text_mail]" type="hidden" value="0">
                    <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
                </label>
            </p>

            <p class="">
                <label for="my_input">{{ __('lang.label_theme') }}</label>
                <input type="hidden" name="settings[ui_theme]" value="">
                <select name="settings[ui_theme]" class="my_input p-1 select-search">
                    <option value="all" {{ $data['settings']['default_notification_option'] == 'all' ? 'selected="selected"' : '' }}>
                        {{ __('lang.label_user_mail_option_all') }}
                    </option>
                    <option value="selected" {{ $data['settings']['default_notification_option'] == 'selected' ? 'selected="selected"' : '' }}>
                        {{ __('lang.label_user_mail_option_selected') }}
                    </option>
                    <option value="only_my_events" {{ $data['settings']['default_notification_option'] == 'only_my_events' ? 'selected="selected"' : '' }}>
                        {{ __('lang.label_user_mail_option_only_my_events') }}
                    </option>
                    <option value="only_assigned" {{ $data['settings']['default_notification_option'] == 'only_assigned' ? 'selected="selected"' : '' }}>
                        {{ __('lang.label_user_mail_option_only_assigned') }}
                    </option>
                    <option value="only_owner" {{ $data['settings']['default_notification_option'] == 'only_owner' ? 'selected="selected"' : '' }}>
                        {{ __('lang.label_user_mail_option_only_owner') }}
                    </option>
                    <option value="none" {{ $data['settings']['default_notification_option'] == 'none' ? 'selected="selected"' : '' }}>
                        {{ __('lang.label_user_mail_option_none') }}
                    </option>
                </select>
            </p>
        </div>
    </div>

    <fieldset class="bg-light border p-3 pt-0">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">{{ __('lang.text_select_mail_notifications') }}</legend>

        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_issue_added') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_issue_updated') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_news_added') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_news_comment_added') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_document_added') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_file_added') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_message_posted') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_wiki_content_added') }}
        </label>
        <br>
        <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal" id="">
            <input name="settings[plain_text_mail]" type="hidden" value="0">
            <input style="margin:0px !important" id='plain_text_mail' type="checkbox" name="settings[plain_text_mail]" value="1" {{ $data['settings']['plain_text_mail'] == '1' ? 'checked' : '' }}>
            {{ __('lang.label_wiki_content_updated') }}
        </label>

    </fieldset>

    {{-- field email header --}}
    <fieldset class="bg-light border p-3 pt-0 mt-3">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">{{ __('lang.setting_emails_header') }}</legend>
        <textarea name="settings[emails_header]" id="" class="form-edit" rows="5">{!! $data['settings']['emails_header'] !!}</textarea>
    </fieldset>

    {{-- field email footer --}}
    <fieldset class="bg-light border p-3 pt-0 mt-3">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">{{ __('lang.setting_emails_footer') }}</legend>
        <textarea name="settings[emails_footer]" id="" class="form-edit" rows="5">{!! $data['settings']['emails_footer'] !!}</textarea>
    </fieldset>

    <div class="pt-3 pr-2">
        <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __('lang.button_save') }}</button>
    </div>
</form>
