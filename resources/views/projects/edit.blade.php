<div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-info-proejct">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('projects.update', ['project_identifier' => $project->identifier]) }}" method="POST">
                @csrf
                <project-form :project="{{ $project ?? []}}" :projects="{{ $projects ?? []}}" :parent="{{ $project->parent ?? 0 }}" :programs="{{ $programs }}"></project-form>


                @if ($project->type !== 'PDE')
                    @include('projects.custom_fields', ['custom_fields' => $custom_fields ?? [], 'is_desabled' => false])

                    @can('editar_projectos', [App\Models\Projects::class , $project])
                        <div class="">
                            <button type="submit">{{ __('lang.button_update') }}</button>
                        </div>
                    @endcan
                @else
                    @can('editar_plano_estrategico', [App\Models\Projects::class , $project])
                        <div class="">
                            <button type="submit">{{ __('lang.button_update') }}</button>
                        </div>
                    @endcan
                @endif
            </form>
        </div>
    </div>
</div>
