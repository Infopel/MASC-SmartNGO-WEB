@extends('layouts.main')
@section('content')
<div class="p-2 bg-light m-1">
    <div class="p-2 pl-3 pr-3">
        <div class="col-md-127">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <h4>Projectos</h4>
                </div>
                <div class="d-flex">
                    @can('gerir_linhas_estrategicas', App\Models\Projects::class)
                        <div class="mr-2">
                            <form action="/projects" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                <label for="closed">
                                @if ($_GET['closed'] ?? false)
                                    <input type="checkbox" checked id="closed" onchange="this.form.submit();">
                                @else
                                    <input type="checkbox" name="closed" id="closed" value="1" onchange="this.form.submit();">
                                @endif
                                Visualizar projetos fechados
                                </label>
                            </form>
                        </div>
                    @endcan
                    @can('cadastrar_plano_estrategico', App\Models\Projects::class)
                        <a href="{{ route('pde.new') }}" class="text-danger" title="Plano de Desenvolvimento Estratégico">
                            <i class="icon-plus-circle2" style="font-size: 90%"></i>
                            <span>{{ __('Novo PE') }}</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="row-md-12 m-0 p-0 mb-4" style="height: 90vh;">
        
        @foreach ($projects as $project)
            <!-- column My Tasks -->
            @forelse ($project->childs as $child)
                <div class="col-md-4 mb-3 float-left" style="font-size: 95% !important;">
                    <div class="card-block shadow-sm p-3 position-relative" style="max-height: 67vh; min-height: 55vh; ">
                        <div class="">
                            <div class="approval-item-element p-2 bg-light rounded mb-2">
                                <p class="mb-2" style="max-height: 120px !important; overflow: hidden; font-size: 100% !important">
                                    <a href="{{ route('projects.overview', ['project_identifier' => $child['identifier']]) }}">
                                        {{ $child->name }}
                                    </a>
                                </p>
                                <div class="proj-desc border-bottom mb-2">
                                    {!! $child['description'] !!}
                                </div>

                                <div class="d-flex">
                                    <div class="text-grey small mr-20">
                                        Membros - {{ $child->members->count() }}
                                    </div>
                                    <div class="text-grey small mr-20">
                                        Actividades - {{ $child->issues->count() }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @empty

            @endforelse
            {{--  <div class="col-md-4 mb-3 " style="font-size: 95% !important;">
                <div class="card-block shadow-sm p-3 position-relative" style="max-height: 87vh; min-height: 77vh; overflow-y: auto">
                    {{-- Header -}}
                    <div
                        class="bg-white border-bottom mb-2 pb-2 pl-3 position-sticky pr-3 pt-3 title-card"
                        style="top: -16px; left: 0; margin-left: -15px; margin-right: -15px; margin-top: -8px;"
                        >
                        <h4 class="flex-grow-1 cursor-pointer" style="font-size: 18px !important;">
                            <span class="text-muted"></span><span>{{ $project->name }}</span>
                        </h4>
                        <div class="d-flex mb-1 d-flex justify-content-between">
                            <div class="text-grey">
                                <span class="text-grey mr-2">Projectos Associados: ({{ $project->childs->count() }})</span>
                            </div>
                            <div class="text-grey">
                                <span class="text-gray mr-2">Criado a: {{ \Carbon\Carbon::parse($project->created_on)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    {{-- /end header --}}

                    {{-- Content Body -}}
                    

                    {{-- Content Body -}}

                </div>
            </div>--}}
            <!-- column My Tasks -->
        @endforeach
    </div>
</div>

@endsection
