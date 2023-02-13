@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        @include('errors.any')
                        {{-- /session rows --}}

                        <h5><a href="{{ route('users.index') }}">{{ __('lang.label_user_plural') }}</a> » {{ $user['login'] }}</h5>

                        <nav>
                            <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link link-option active" id="nav-overview-tab" data-toggle="tab" href="#nav-overview" role="tab" aria-controls="nav-overview" aria-selected="true">{{ __('lang.label_overview') }}</a>
                                <a class="nav-item nav-link link-option" id="nav-groups-tab" data-toggle="tab" href="#nav-groups" role="tab" aria-controls="nav-groups" aria-selected="false">{{ __('lang.label_group_plural') }}</a>
                                <a class="nav-item nav-link link-option" id="nav-projects-tab" data-toggle="tab" href="#nav-projects" role="tab" aria-controls="nav-projects" aria-selected="false">{{ __('lang.label_project_plural') }}</a>

                                @can('alterar_senha_de_usuarios', App\Models\User::class)
                                    <a class="nav-item nav-link link-option" id="user-authentication-tab" data-toggle="tab" href="#user-authentication" role="tab" aria-controls="user-authentication" aria-selected="false">{{ __('lang.label_authentication') }}</a>
                                @endcan
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-overview" role="tabpanel" aria-labelledby="nav-overview-tab">
                                <form action="{{ route('users.update', ['user' => $user['id']]) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        @include('users._form', ['custom_fields' => $custom_fields, 'is_desabled' => false])
                                        <div class="col pl-3 pt-3 pr-2">
                                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="nav-groups" role="tabpanel" aria-labelledby="nav-groups-tab">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('users.updateGroups', ['user' => $user->id]) }}" method="POST">
                                            @csrf
                                            <div class="w-100 bg-light border rounded p-2" id="user_group_ids">
                                                <ul class="list-unstyled m-0">
                                                    @foreach ($groups as $group)
                                                        <li>
                                                            @if (in_array($group->id, $user_groups->toArray()))
                                                                <label class="mb-0">
                                                                    <input type="checkbox" name="user[group_ids][]" value="{{ $group->id }}" Checked>
                                                                    {{ $group->name }}
                                                                </label>
                                                            @else
                                                                <label class="mb-0">
                                                                    <input type="checkbox" name="user[group_ids][]" value="{{ $group->id }}">
                                                                    {{ $group->name }}
                                                                </label>
                                                            @endif


                                                        </li>
                                                    @endforeach
                                                    <input type="hidden" name="user[group_ids][]" id="user_group_ids_" value="">
                                                </ul>
                                                <p class="mt-2">
                                                    <a href="#" onclick="checkAll('user_group_ids', true); return false;">
                                                        Marcar todos
                                                    </a> |
                                                    <a href="#" onclick="checkAll('user_group_ids', false); return false;">
                                                        Desmarcar todos
                                                    </a>
                                                </p>
                                            </div>

                                            <div class="pt-3 pr-2">
                                                <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_update") }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-projects" role="tabpanel" aria-labelledby="nav-projects-tab">
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm table-striped table-hover border">
                                        <thead class="table-active text-center">
                                            <th>{{ __('lang.label_project') }}</th>
                                            <th>{{ __('lang.label_role_plural') }}</th>
                                            <th style="min-width: 120px;"></th>
                                        </thead>

                                        <tbody>
                                            @foreach ($user->projects as $project)
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

                            <div class="tab-pane fade" id="user-authentication" role="tabpanel" aria-labelledby="user-authentication-tab">
                                <form action="{{ route('user.update_senha', ['user' => $user->id]) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        @include('users._auth_form')
                                        <div class="col pl-3 pt-2 pr-2">
                                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">
                                                {{ __('lang.button_update') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
