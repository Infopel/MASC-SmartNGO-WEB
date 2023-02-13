@extends('layouts.main')
@section('content')
<div class="row m-0">
    <div class="col-md-12 p-0 mb-4">
        <div class="row m-0">
            <div class="col-md-12 pt-2">
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
            @foreach ($data['projects'] as $projects)
                <div class="col-md-4 pt-2">
                    <div class="p-3 bg-white rounded">
                        <div class="plan-title text-uppercase mb-2">
                            <h5 class="mb-0 text-wrap">
                                @if ($projects['type'] == 'Project' || $projects['type'] == 'PDE')
                                    <a href="{{ route('projects.overview', ['project_identifier' => $projects['identifier']]) }}" class="text-wrap {{ $projects['status'] == 5 ? 'text-back-50' : null }}">
                                        <span>{{ $projects['name'] }}</span> <span class="text-danger">{{ $projects['status']  == 5 ? '- Fechado' : null }}</span>
                                    </a>
                                @else
                                    <a href="{{ route('programs.show', ['program' => $projects['identifier']]) }}" class="text-wrap {{ $projects['status'] == 5 ? 'text-back-50' : null }}">
                                        <span>{{ $projects['name'] }}</span> <span class="text-danger">{{ $projects['status']  == 5 ? '- Fechado' : null }}</span>
                                    </a>
                                @endif
                            </h5>
                            <span class="text-lowercase text-black-50">{!! $projects['description'] !!}</span>
                        </div>
                        <div class="">
                            @if (isset($projects['child']))
                                @foreach ($projects['child'] as $child)
                                    <div class="programa pl-2 mb-3">
                                        <div class="pg-title">
                                            <h6 class="mb-0">
                                                <a href="{{ route('programs.show', ['program' => $child['identifier']]) }}" class="{{ $child['status'] == 5 ? 'text-black-50' : 'text-success' }}">
                                                    <span>{{ $child->name }}</span> <span class="text-danger">{{ $child['status']  == 5 ? '- Fechado' : null }}</span>
                                                </a>

                                                <hr class="mt-2 mb-2">
                                            </h6>
                                            <div class="childs">
                                                @if (isset($child['child']))
                                                    @include('projects.childs', ['childs' => $child['child']])
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
