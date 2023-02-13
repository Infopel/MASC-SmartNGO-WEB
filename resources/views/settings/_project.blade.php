<div class="bg-light p-2">
    <div class="tabular settings">
        <p>
            <label for="member_management" class="">{{ __('lang.setting_default_projects_public') }}</label>
            <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                <input name="settings[default_projects_public]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_public]" value="1" >
            </label>
        </p>

        <p>
            <label class="float-left mb-0">{{ __('lang.setting_default_projects_modules') }}</label>


            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.label_module_issue_tracking') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_news') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_documents') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_files') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_wiki') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_repository') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_boards') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_billing') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_calendar') }}
            </label>

            <label class="block mb-0" id="">
                <input name="settings[default_projects_modules]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="settings[default_projects_modules]" value="1" >
                {{ __('lang.project_module_gantt') }}
            </label>

        </p>
    </div>
</div>
