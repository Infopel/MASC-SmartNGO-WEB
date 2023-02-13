<form action="">
    @csrf
    <input type="hidden" name="_act" value="display">
    <div class="bg-light p-2">
        <div class="tabular settings">

            <p class="">
                <label for="my_input">{{ __('lang.label_theme') }}</label>
                <input type="hidden" name="settings[ui_theme]" value="">
                <select name="settings[ui_theme]" class="my_input p-1 select-search">
                    <option value="">{{ __('lang.label_default') }}</option>
                    <option value="alternate">Alternate</option>
                    <option value="classic">CLassic</option>
                </select>
            </p>

            <p class="">
                <label for="my_input">{{ __('lang.setting_default_language') }}</label>
                <select name="settings[default_language]" id="settings_default_language" class="my_input p-1 select-search">
                    {{-- <option value="sq">Albanian (Shqip)</option>
                    <option value="ar">Arabic (عربي)</option>
                    <option value="az">Azerbaijani (Azeri)</option>
                    <option value="eu">Basque (Euskara)</option>
                    <option value="bs">Bosnian (Bosanski)</option>
                    <option value="bg">Bulgarian (Български)</option>
                    <option value="ca">Catalan (Català)</option>
                    <option value="hr">Croatian (Hrvatski)</option>
                    <option value="cs">Czech (Čeština)</option>
                    <option value="da">Danish (Dansk)</option>
                    <option value="nl">Dutch (Nederlands)</option> --}}
                    <option value="en">English</option>
                    {{-- <option value="en-GB">English (British)</option>
                    <option value="et">Estonian (Eesti)</option>
                    <option value="fi">Finnish (Suomi)</option>
                    <option value="fr">French (Français)</option>
                    <option value="gl">Galician (Galego)</option>
                    <option value="de">German (Deutsch)</option>
                    <option value="el">Greek (Ελληνικά)</option>
                    <option value="he">Hebrew (עברית)</option>
                    <option value="hu">Hungarian (Magyar)</option>
                    <option value="id">Indonesian (Bahasa Indonesia)</option>
                    <option value="it">Italian (Italiano)</option>
                    <option value="ja">Japanese (日本語)</option>
                    <option value="ko">Korean (한국어)</option>
                    <option value="lv">Latvian (Latviešu)</option>
                    <option value="lt">Lithuanian (lietuvių)</option>
                    <option value="mk">Macedonian (Македонски)</option>
                    <option value="mn">Mongolian (Монгол)</option>
                    <option value="no">Norwegian (Norsk bokmål)</option>
                    <option value="fa">Persian (پارسی)</option>
                    <option value="pl">Polish (Polski)</option> --}}
                    <option value="pt">Portuguese (Português)</option>
                    <option selected="selected" value="pt-BR">Portuguese/Brasil (Português/Brasil)</option>
                    {{-- <option value="ro">Romanian (Română)</option>
                    <option value="ru">Russian (Русский)</option>
                    <option value="sr-YU">Serbian (Srpski)</option>
                    <option value="sr">Serbian Cyrillic (Српски)</option>
                    <option value="zh">Simplified Chinese (简体中文)</option>
                    <option value="sk">Slovak (Slovenčina)</option>
                    <option value="sl">Slovene (Slovenščina)</option>
                    <option value="es">Spanish (Español)</option>
                    <option value="es-PA">Spanish/Panama (Español/Panamá)</option>
                    <option value="sv">Swedish (Svenska)</option>
                    <option value="th">Thai (ไทย)</option>
                    <option value="zh-TW">Traditional Chinese (繁體中文)</option>
                    <option value="tr">Turkish (Türkçe)</option>
                    <option value="uk">Ukrainian (Українська)</option>
                    <option value="vi">Vietnamese (Tiếng Việt)</option> --}}
                </select>
            </p>

            <p>
                <label for="member_management" class="">{{ __('lang.setting_force_default_language_for_loggedin') }}<span class="text-danger"> *</span></label>
                <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                    <input name="settings[force_default_language_for_anonymous]" type="hidden" value="0">
                    <input style="margin:0px !important" type="checkbox" name="settings[force_default_language_for_anonymous]" value="1" >
                </label>
            </p>
        </div>
    </div>

    <div class="pt-3 pr-2">
        <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __('lang.button_save') }}</button>
    </div>
</form>
