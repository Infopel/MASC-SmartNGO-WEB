<div class="tab-pane fade" id="nav-modules" role="tabpanel" aria-labelledby="nav-modules-project">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('projects.update-modules', ['project_identifier' => $project->identifier]) }}" id="modules-form" method="POST">
                @csrf
                <div class="mb-3 bg-light rounded border p-3 pt-0" style="font-size:90%">
                    <p class="text-muted">{{ __('lang.text_select_project_modules') }}:</p>
                    <p>
                        @foreach ($project->modules as $module)
                            <label class="m-0" style="display:block;">
                                <input type="checkbox" name="enabled_module_names[]" value="{{ $module['name'] }}" {{ $module['is_enabled'] ? "checked='checked'" : null }}>
                                {{ $module['module'] }}
                            </label>
                        @endforeach
                    </p>
                </div>
                <p>
                    <a href="#" onclick="checkAll('modules-form', true); return false;">
                        Marcar todos
                    </a> | <a href="#" onclick="checkAll('modules-form', false); return false;">
                        Desmarcar todos
                    </a>
                </p>
                <div class="">
                    <button type="submit"> {{ __('lang.button_save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
