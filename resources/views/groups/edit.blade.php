@extends('layouts.main', ['title' => 'Editar Grupo - '.$group->name])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        <div class="w-100">
                            @if (session('status'))
                                <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                    <i class="icon-checkmark"></i>
                                    {{ session('status') }}
                                </div>
                            @elseif(session('erros'))
                                <div class="ml-0 p-2 alert alert-danger">
                                    <i class="icon-warning2"></i>
                                    {{ session('erros') }}
                                </div>
                            @endif
                        </div>
                        {{-- /session rows --}}


                        <h5><a href="{{ route('groups.index') }}">{{ __('lang.label_group_plural') }}</a> » {{ $group['lastname'] }}</h5>

                        <nav>
                            <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link link-option active" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">{{ __('lang.label_overview') }}</a>
                                <a class="nav-item nav-link link-option" id="nav-users-tab" data-toggle="tab" href="#nav-users" role="tab" aria-controls="nav-users" aria-selected="false">{{ __('lang.label_user_plural') }}</a>
                                <a class="nav-item nav-link link-option" id="nav-projects-tab" data-toggle="tab" href="#nav-projects" role="tab" aria-controls="nav-projects" aria-selected="false">{{ __('lang.label_project_plural') }}</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                                <form action="{{ route('groups.update', ['group' => $group['id']]) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        @include('groups._form', ['custom_fields' => $custom_fields])
                                        <div class="col pl-3 pt-3 pr-2">
                                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab">
                                <div class="col-md-12">
                                    @livewire('member-group', $group)
                                </div>
                            </div>


                            <div class="tab-pane fade" id="nav-projects" role="tabpanel" aria-labelledby="nav-projects-tab">
                                <div class="text-lowercase mb-2">
                                    <a href="-error" class="text-success">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('lang.label_add_projects') }}</span>
                                    </a>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm table-striped table-hover border">
                                        <thead class="table-active text-center">
                                            <th>{{ __('lang.label_project') }}</th>
                                            <th>{{ __('lang.label_role_plural') }}</th>
                                            <th style="min-width: 120px;"></th>
                                        </thead>

                                        <tbody>
                                            @foreach ($group['projects'] as $project)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('projects.overview', ['project_identifier' => $project['identifier']]) }}">
                                                            {{ $project['name'] }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $project['roles'] }}
                                                    </td>
                                                    <td class="text-right">
                                                        <a href="" class="ml-2 text-slate">
                                                            <i class="icon-pencil5"></i>
                                                            <span>{{ __('lang.button_edit') }}</span>
                                                        </a>
                                                        <a href="" class="ml-2 text-danger">
                                                            <i class="icon-trash"></i>
                                                            <span>{{ __('lang.button_delete') }}</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
