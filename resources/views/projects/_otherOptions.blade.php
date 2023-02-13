{{-- Tipo de tarefas --}}
<div class="row mb-3">
    <div class="col-md-12">
        <div class="box tabular" id="permissions" style="font-size:90%">
            <fieldset class="border pl-3 pr-3 pt-2 bg-light rounded border">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto text-capitalize">Modulos</legend>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_issue_tracking" value="issue_tracking" checked="checked">
                    Gerenciamento de Tarefas
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_time_tracking" value="time_tracking" checked="checked">
                    Gerenciamento de tempo
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_news" value="news" checked="checked">
                    Notícias
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_documents" value="documents" checked="checked">
                    Documentos
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_wiki" value="wiki" checked="checked">
                    Wiki
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_boards" value="boards">
                    Fóruns
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_calendar" value="calendar" checked="checked">
                    Calendário
                </label>

                <label class="floating">
                    <input type="checkbox" name="project[enabled_module_names][]" id="project_enabled_module_names_gantt" value="gantt" checked="checked">
                    Gantt
                </label>

                <input type="hidden" name="project[enabled_module_names][]" id="project_enabled_module_names_" value="">
            </fieldset>
        </div>
    </div>
</div>
{{-- / Tipo de Tarefas --}}
