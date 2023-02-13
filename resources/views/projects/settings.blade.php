@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 bg-white p-3">
                    <h4>{{ __('lang.label_settings') }}</h4>

                    @include('errors.any')


                    <div class="mt-3">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link link-option active" id="nav-info-proejct" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Informações</a>

                                @can('select_project_modules', [App\Models\Projects::class, $project])
                                    <a class="nav-item nav-link link-option" id="nav-modules-project" data-toggle="tab" href="#nav-modules" role="tab" aria-controls="nav-modules" aria-selected="false">Módulos</a>
                                @endcan
                                <a class="nav-item nav-link link-option" id="nav-trackers-project" data-toggle="tab" href="#nav-trackers" role="tab" aria-controls="nav-modules" aria-selected="false">Tipos de Actividades</a>

                                @if ($project['type'] == 'Project' || $project['type'] == 'PDE'|| $project['type'] == 'Program')
                                    <a class="nav-item nav-link link-option" id="nav-members-project" data-toggle="tab" href="#nav-members" role="tab" aria-controls="nav-members" aria-selected="false">Membros</a>
                                @endif

                                <a class="nav-item nav-link link-option" id="nav-categories-project" data-toggle="tab" href="#nav-categories" role="tab" aria-controls="nav-categories" aria-selected="false">Categorias de Actividades</a>

                                @can('wiki', [\App\Models\Projects::class, $project])
                                    <a class="nav-item nav-link link-option" id="nav-wiki-project" data-toggle="tab" href="#nav-wiki" role="tab" aria-controls="nav-wiki" aria-selected="false">Wiki</a>
                                @endcan

                                {{-- @can('manage_members', [\App\Models\Projects::class, $project['id']]) --}}
                                    <a class="nav-item nav-link link-option" id="nav-activites-project" data-toggle="tab" href="#nav-activites" role="tab" aria-controls="nav-activites" aria-selected="false">Actividades (registro de horas)</a>
                                {{-- @endcan --}}

                                {{-- @can('manage_members', [\App\Models\Projects::class, $project['id']]) --}}
                                    <a class="nav-item nav-link link-option" id="nav-project-partners" data-toggle="tab" href="#nav-partners" role="tab" aria-controls="nav-partners" aria-selected="false">Parceiros</a>
                                {{-- @endcan --}}
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @include('projects.edit')
                            @include('projects.settings.modules')
                            @include('projects.settings.trackers')
                            @include('projects.settings.members')
                            @include('projects.settings.issues_categories')
                            @include('projects.settings.wiki')
                            @include('projects.settings.activities')
                            @include('projects.settings.projects_partners')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
