<div class="tab-pane fade" id="nav-trackers" role="tabpanel" aria-labelledby="nav-trackers-project">
    <div class="row">
        <div class="col-md-12">
            <h5>Tipos de Actividades</h5>
            <form action="{{ route('projects.project_tracker', ['project_identifier' => $project->identifier]) }}" id="task_type_form" method="POST">
                @csrf
                <div class="mb-3 bg-light rounded border p-3 pt-0" style="font-size:90%">
                    <p class="text-muted">{{ __('Selecione os tipos de tarefa a habilitar para este projeto') }}</p>
                    <p>
                        @foreach ($project->trackers as $tracker)
                            <label class="m-0" style="display:block;">
                                <input type="checkbox" name="enabled_project_tracker[]" value="{{ $tracker['id'] }}" {{ $tracker['is_selected'] ? "checked='checked'" : null }}>
                                {{ $tracker['name'] }}
                            </label>
                        @endforeach
                    </p>
                </div>
                <p>
                    <a href="#" onclick="checkAll('task_type_form', true); return false;">
                        Marcar todos
                    </a> | <a href="#" onclick="checkAll('task_type_form', false); return false;">
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
