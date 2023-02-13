@extends('layouts.main', ['title' => $project->name])
@section('content')
<div class="row m-0 mt-2">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12 mb-1">
                <div class="d-flex">
                    <div class="flex-grow-1">
                    </div>
                    <div class="d-flex">
                        @can('cadastrar_projectos', App\Models\Projects::class)
                            @if ($project->status == 1 && $project->type == 'Project')
                                <div class="mr-2">
                                    <a href="{{ route('projects.new', ['parent' => $project->identifier]) }}" class="text-success">
                                        <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                                        <span>{{ __('lang.label_subproject_new') }}</span>
                                    </a>
                                </div>
                            @endif
                        @endcan
                        @can('criar_linhas_estrategicas', App\Models\Projects::class)
                            @if ($project->status == 1 && $project->type == "PDE")
                                <div class="mr-2">
                                    <a href="{{ route('programs.pde.create', ['indentifier' => $project->identifier]) }}" class="text-success">
                                        <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                                        <span>{{ __('Nova Linha Estratégica') }}</span>
                                    </a>
                                </div>
                            @endif
                        @endcan
                        @can('gerir_projectos', App\Models\Projects::class)
                            <div class="mr-2">
                                <a href="{{ route('projects.request_action', ['project_identifier' => $project->identifier, 'action' => $project->status == 1 ? 'close' : 'open']) }}" class="text-danger-700">
                                    <i class="icon-plus-circle2" style="font-size:90%"></i>
                                    @if ($project->status == 1)
                                        <span>{{ __('lang.button_close')}}</span>
                                    @elseif($project->status == 5)
                                        <span>{{ __('lang.button_reopen')}}</span>
                                    @endif
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>

            <div class="pl-3 pr-3 w-100">
                @if (session('isRemoveTrue'))
                    <div class="alert alert-warning">
                        {{ session('isRemoveTrue')['msg'] }}
                        <div>
                            <h6>{{ session('isRemoveTrue')['action_name'].' '.__('lang.label_project') }}: <b>{{ session('isRemoveTrue')['project_name'] }}</b><h6>
                            <form method="POST" action='{{ route('projects.run_action', ['project_identifier' => session('isRemoveTrue')['project_identifier'], 'action' => session('isRemoveTrue')['action']]) }}'>
                                @csrf
                                <div class="text-left">
                                    <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            {{-- @include('errors.any') --}}

            @if ($project->status == 5)
                <div class="col-md-12">
                    <div class="pt-1 pb-1 pl-3 pr-3 alert alert-danger text-center">
                        <i class="icon-lock2" style="font-size:90%"></i>
                        {{ __('lang.text_project_closed') }}
                    </div>
                </div>
            @endif

            {{-- Column 1 --}}
            <div class="col-md-6 mb-3">
                <div class="card-block rounded bg-white p-3 border h-auto">
                    <h5 class="m-0 mb-2">Visão Geral - Informações sobre o projeto</h5>
                    <p>{!! $project->description !!}</p>
                    <hr>
                    @if ($project['type'] == 'Project')
                        <ul class="ul" style="font-size: 92%">
                            @foreach ($project->custom_field_values as $key => $custom_value)
                                @if ($custom_value['field_format'] == 'list')
                                    <li class=""><span class="fw-500">{{ $key }}:</span>
                                        <ul>
                                            @foreach ($custom_value['values'] as $item)
                                                @if ($item['is_selected'])
                                                    <li class="">{{ $item['value'] }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @else
                                    <li class=""><span class="fw-500">{{ $key }}:</span> {{ $custom_value['values'][0]['value'] }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @elseif($project['type'] == 'PDE')
                        <ul class="ul" style="font-size: 93%">
                            <li>
                                <span class="fw-500">{{ __('lang.field_start_date')}}:</span> {{ $project->start_date }}
                            </li>
                            <li>
                                <span class="fw-500">{{ __('lang.field_due_date')}}:</span> {{ $project->start_date }}
                            </li>
                        </ul>
                    @endif
                </div>

                <div class="card rounded p-3 mt-3">
                    <h6 class="m-0 mb-2 fw-600">{{ __('Indicadores de Progresso') }}</h6>
                    <div class="table-responsive" style="max-height: 500px;overflow-y: auto;">
                        <table class="table mt-2 border table-sm hover table-striped"  style="font-size:93%">
                            <thead class="table-active">
                                <th class="fw-600 ">Indicador(es)</th>
                                <th class="fw-600 ">Cumulativo</th>
                                <th class="fw-600 text-center">Meta</th>
                                <th class="fw-600 text-nowrap">Tipo de Meta</th>
                                <th class="fw-600 text-center">Alcancado</th>
                            </thead>
                            <tbody>
                                @foreach ($project->indicators as $indicator)
                                  
                                {{-- {{ dd($project->indicators) }} --}}
                                <tr>
                                        <td class="p-1 pl-2 pr-2">{{ $indicator['name'] }}</td>
                                        <td class="p-1 pl-2 pr-2 text-center">
                                            @if ($indicator['is_cumulative'])
                                                <i class="icon-checkmark-circle text-success"></i>
                                            @endif
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-center">
                                            {{ $indicator['meta'] }}
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-center">
                                            {{ __('lang.label_field_format_'.$indicator['meta_type']) }}
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-center">{{ $indicator['achived_value'] }}</td>
                                    </tr>
                                @endforeach
                                @if ($project->indicators == [])
                                    <tr>
                                        <td class="p-0 pl-2 pr-2 text-center" colspan="5">
                                            {{ __('lang.label_no_data') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- /Column 1 --}}

            {{-- Column 2 --}}
            <div class="col-md-6">
                @if (sizeof($project->childs) > 0 && $project['type'] == 'Project')
                    <div class="card-block h-auto rounded bg-white p-2 mb-3 border">
                        <h6 class="m-0 mb-2 fw-600"> <i class="icon-stack"></i> {{ __('lang.label_subproject_plural') }}</h6>

                        @foreach ($project->childs as $child)
                            <a href="{{ route('projects.overview', ['project_identifier' => $child['identifier']]) }}" class="link-option" style="font-size:97%">{{ $child->name }}</a>,
                        @endforeach
                    </div>
                @elseif($project['type'] == 'PDE')
                    <div class="card-block h-auto rounded bg-white p-3 mb-3 border">
                        <h6 class="m-0 mb-2 fw-600">{{ __('lang.label_program_plural') }}</h6>
                        <div class="table-responsive">
                            <table class="table border table-sm table-hover" style="font-size:93%">
                                <thead class="table-active">
                                    <th>{{ __('lang.label_program') }}</th>
                                    <th class="text-right">{{ __('lang.label_project_plural') }}</th>
                                    {{-- <th>Projectos Associados</th> --}}
                                </thead>
                                <tbody>
                                    @foreach ($project->childs as $program)
                                        <tr>
                                            <td class="p-0 pl-2 pr-2">
                                                <a href="{{ route('programs.show', ['program' => $program['identifier']]) }}">
                                                   {{ $program->name }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-right">
                                                {{ $program->childs->count() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if (sizeof($project->childs) <=0)
                                        <tr>
                                            <td class="p-0 pl-2 pr-2 text-center" colspan="2">
                                                {{ __('lang.label_no_data') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <p class="pt-1 pb-1 m-0">
                                <a href="{{ route('programs.index', ['view_all' => true, 'set_filter' => 1, 'parent' => $project->identifier]) }}">
                                    {{ __('Ver todos programas')}}
                                </a>
                            </p>
                        </div>
                    </div>
                @endif

                @can('view_issues', [ \App\Models\Projects::class, $project])
                    {{-- card 1 --}}
                    <div class="card-block h-auto rounded bg-white p-3 mb-3 border">
                        <h6 class="m-0 mb-2 fw-600">{{ __('lang.label_issue_plural') }}</h6>
                        <div class="table-responsive">
                            <table class="table border table-sm table-hover" style="font-size:93%">
                                <thead class="table-active">
                                    <th></th>
                                    <th class="text-center">{{ __('lang.label_open_issues') }}</th>
                                    <th class="text-center">{{ __('lang.label_closed_issues') }}</th>
                                    <th class="text-center">{{ __('lang.label_total') }}</th>
                                    {{-- <th>{{ __('lang.label_progress_issues') }}</th> --}}
                                </thead>

                                <tbody>
                                    @foreach ($project->project_trackers_overview as $key => $project_tracker)
                                        <tr>
                                            <td>
                                                <a href="{{ route('projects.issue_tracking_alt', ['setfilter' => '1','project_identifier' => $project->identifier, 'tracker' => $project_tracker['tracker_id']]) }}">
                                                    <span>{{ $key }}</span>
                                                </a>
                                            </td>
                                            <td class="text-center"><a href="#"><span>{{  sizeof($project_tracker['0'] ?? []) }}</span></a></td>
                                            <td class="text-center"><a href="#"><span>{{  sizeof($project_tracker['1'] ?? []) }}</span></a></td>
                                            <td class="text-center">
                                                <a href="#">
                                                    <span>{{ sizeof($project_tracker['0'] ?? []) + sizeof($project_tracker['1'] ?? []) }}</span>
                                                </a>
                                            </td>
                                            {{-- <td>
                                                <div class="progress" style="width: 120px;">
                                                    <div role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-success" style="width: {{ $tracker['due_percent'] }};">{{ $tracker['due_percent'] }}</div>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <p class="pt-1 pb-1 m-0">
                                <a href="{{ route('projects.issues.tracking', ['project_identifier' => $project->identifier, 'set_filter' => 1]) }}">{{ __('lang.label_issue_view_all')}}</a>
                                | <a href="/redmine/projects/plano-estrategico-2010-2023/issues/calendar">{{ __('lang.label_calendar')}}</a>
                                | <a href="/redmine/projects/plano-estrategico-2010-2023/issues/gantt">{{ __('lang.label_gantt')}}</a>
                            </p>
                        </div>
                    </div>
                    {{-- /card 1 --}}
                @endcan


                {{-- card 2 --}}
                @if ($project['type'] == 'Project')
                    <div class="card-block h-auto rounded bg-white p-3 mb-3 border">
                        <h6 class="m-0 fw-600">{{ __('lang.label_member_plural') }}</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover border datatable-show-all" style="font-size:93%">
                                <thead class="table-active">
                                    <th>{{ __('lang.label_member') }}</th>
                                    <th>{{ "Act. Criadas" }}</th>
                                    <th>{{ "Act. Atribuidas" }}</th>
                                    <th>{{ __('lang.label_closed_issues') }}</th>
                                    {{-- <th>{{ __('lang.label_progress_issues') }}</th> --}}
                                </thead>

                                <tbody>
                                    @foreach ($project->members as $membro)
                                        <tr>
                                            <td class="row m-0 " style="min-width: 230px;">
                                                <div class="d-flex">
                                                    <div class="m-1 mr-2 user-label bg-slate-800 text-white">{{ substr($membro->user->firstname, 0, 1). substr($membro->user->lastname, 0, 1) }}</div>
                                                    <div class="d-block">
                                                        <div class="font-weight-bold" style="margin-bottom: -4px;">
                                                            <a href="/users/{{ $membro['user_id'] }}">{{ $membro->user->full_name }}</a>
                                                        </div>
                                                        @foreach ($membro->project_roles as $memberRole)
                                                            <small class='text-black-50'>{{ $memberRole->role->name ?? '' }}</small> |
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $membro->memeberCreatedIssues() }}</td>
                                            <td>{{ $membro->memeberAssigenedIssues() }}</td>
                                            <td>0</td>
                                            {{-- <td>95% Concluido</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            {{-- /Column 2 --}}
        </div>
    </div>
</div>
@endsection
