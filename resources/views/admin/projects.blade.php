@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">
                    <h5>{{ __('lang.label_project_plural') }}</h5>

                    <div class="w-100">
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
                    {{-- session handler --}}
                    @include('errors.any')
                    {{-- session handler --}}

                    <fieldset class="border p-2 pl-3 pr-3 pt-0">
                        <legend class="pl-2 pr-2 p-0 m-0 w-auto text-capitalize">Filstros</legend>

                        <form action="" method="GET">
                            @csrf
                            <input type="hidden" name="utf8" value="✓">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="">Situação</label>
                                    <select name="status" class="form-control form-control-sm pr-3">
                                        <option value="">{{ __('lang.label_all') }}</option>
                                        <option value="1" {{ $status == 1 ? 'selected' : null }}>{{ __('lang.project_status_active') }}</option>
                                        <option value="5" {{ $status == 5 ? 'selected' : null }}>{{ __('lang.project_status_closed') }}</option>
                                        <option value="9" {{ $status == 9 ? 'selected' : null }}>{{ __('lang.project_status_archived') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-sm btn-primary">Aplicar</button>
                                </div>
                                <div class="form-group">
                                    <a href="{{ route('admin.projects') }}">
                                        <i class="icon-reset"></i>
                                        Limpar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                    <div class="table-responsive mt-3">
                        <table class="border table table-sm table-striped table-hover">
                            <thead class="table-active text-center">
                                <th>{{ __('lang.label_project') }}</th>
                                <th>{{ __('lang.field_is_public') }}</th>
                                <th style="min-width: 90px;">{{ __('lang.field_created_on') }}</th>
                                <th style="min-width: 250px;"></th>
                            </thead>

                            <tbody>
                                @foreach ($data['projects'] as $project)
                                    @php
                                        $i = 1;
                                    @endphp
                                    <tr class="{{ $project->status == 1 ? '' : "text-black-50" }}">
                                        <td>
                                            @if ($project->status == 9)
                                                {{ $project->name }}
                                            @else
                                                <a href="{{ route('projects.settings', ['project_identifier' => $project->identifier]) }}" class="{{ $project->status == 1 ? '' : "text-black-50" }}">
                                                    {{ $project->name }}
                                                </a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($project->is_public)
                                                <i class="icon-checkmark-circle position-left text-success"></i>
                                            @endif
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime($project->created_on)) }}</td>
                                        <td class="text-right">

                                            @can('arquivar_plano_estrategico', [App\Models\Projects::class, $project])
                                                <a href="{{ route('projects.request_action', ['project_identifier' => $project->identifier, 'action' => $project->status == 9 ? 'unarchive' : 'archive']) }}" class="{{ $project->status == 1 ? '' : "text-black-50" }}">
                                                    <i class="icon-pin"></i>
                                                    <span>{{ $project->status == 9 ? __('lang.button_unarchive') : __('lang.button_archive') }}</span>
                                                </a>
                                            @endcan

                                            {{-- <a href="" class="{{ $project->status == 1 ? 'text-slate-800' : "text-black-50" }}">
                                                <i class="icon-copy3"></i>
                                                <span>{{ __('lang.button_copy') }}</span>
                                            </a> --}}

                                            @can('excluir_plano_estrategico', [App\Models\Projects::class, $project])
                                                <a href="{{ route('projects.request_action', ['project_identifier' => $project->identifier, 'action' => 'delete']) }}" class="{{ $project->status == 1 ? 'text-danger-400' : "text-black-50" }}">
                                                    <i class="icon-trash"></i>
                                                    <span>{{ __('lang.button_delete') }}</span>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>

                                    @isset($project->child)
                                        @include('admin.child_project', ['childs' => $project->child, 'child_level' => $i])
                                    @endisset
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-2 pagination-sm">
                        <span class="text-black-50">
                            ({{ $projects->count() }}-{{ $projects->lastItem() }}/{{ $projects->total() }})
                        </span>
                        {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
