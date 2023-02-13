@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">
                    {{-- session rows --}}
                    <div class="w-100">
                        @if (session('isRemoveTrue'))
                            <div class="alert alert-warning">
                                {{ session('isRemoveTrue')['msg'] }}
                                <div>
                                    <h6>{{ __('lang.button_delete').' '.__('lang.label_user') }}: <b>{{ session('isRemoveTrue')['user_name'] }}</b><h6>
                                    <form method="POST" action='{{ route('users.remove', ['user'=> session('isRemoveTrue')['user_id'] ]) }}'>
                                        @csrf
                                        <input name="user_id" value="{{ session('isRemoveTrue')['user_id'] }}" type="hidden">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-danger">SIM TENHO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif (session('success'))
                            <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                <i class="icon-checkmark"></i>
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-danger">
                                <i class="icon-warning2"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    {{-- /session rows --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_user_plural') }}</h5>
                        </div>
                        @can('cadastrar_usuarios', App\Models\User::class)
                            <div class="text-lowercase ">
                                <a href="{{ route('users.new') }}" class="text-success">
                                    <i class="icon-plus2"></i>
                                    <span>{{ __('lang.label_user_new') }}</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                    <fieldset class="border p-3 pt-0">
                        <legend class="pl-2 pr-2 p-0 m-0 w-auto">Filstros</legend>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="">Situação</label>
                                <select name="" class="form-control form-control-sm pr-3">
                                    <option value="">Activo</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-striped table-hover border nowrap">
                            <thead class="table-active text-center">
                                <th>{{ __('lang.field_user') }}</th>
                                <th>{{ __('lang.field_name') }}</th>
                                <th>{{ __('lang.field_lastname') }}</th>
                                <th>{{ __('lang.field_address') }}</th>
                                <th>{{ __('lang.field_admin') }}</th>
                                <th style="min-width: 90px;">{{ __('lang.field_created_on') }}</th>
                                <th style="min-width: 90px;">{{ __('lang.field_last_login_on') }}</th>
                                @can('bloquear_desbloquar_usuarios', App\Models\User::class)
                                <th style="min-width: 120px;"></th>
                                @endcan
                            </thead>

                            <tbody>
                                @foreach ($data['users'] as $user)
                                <tr class="{{ $user->status == 1 ? '' : "text-black-50" }}">
                                    <td class="p-0 pl-2 pr-2">
                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}">
                                            {{ $user->login }}
                                        </a>
                                    </td>
                                    <td class="p-0 pl-2 pr-2">{{ $user->firstname }}</td>
                                    <td class="p-0 pl-2 pr-2">{{ $user->lastname}}</td>
                                    <td class="p-0 pl-2 pr-2">
                                        <a class="{{ $user->status == 1 ? '' : "text-black-50" }}" href="mailto:{{ $user->address}}">{{ $user->address}}</a>
                                    </td>
                                    <td class="p-0 pl-2 pr-2 text-center">
                                        @if ($user->admin)
                                            <i class="icon-checkmark-circle position-left text-success"></i>
                                        @endif
                                    </td>
                                    <td class="p-0 pl-2 pr-2 text-center">{{ $user->created_on}}</td>
                                    <td class="p-0 pl-2 pr-2 text-center">{{ $user->last_login_on}}</td>

                                    @can('bloquear_desbloquar_usuarios', App\Models\User::class)
                                        <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                            @if ($user->status == 1)
                                                <a href="{{ route('users.lock', ['user' => $user]) }}"
                                                    class="text-slate-800"
                                                    onclick="event.preventDefault(); document.getElementById('look-form_{{ $user->id }}').submit();">
                                                    <i class="icon-lock4 text-slate-800"></i>
                                                    <span>{{ __('lang.button_lock') }}</span>
                                                </a>

                                                <form id="look-form_{{ $user->id }}" action="{{ route('users.lock', ['user' => $user]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            @elseif($user->status == 2)
                                                <a href="{{ route('users.activate', ['user' => $user]) }}"
                                                    class="{{ $user->status == 1 ? 'text-slate-800' : "text-black-50" }}"
                                                    onclick="event.preventDefault(); document.getElementById('activate-form_{{ $user->id }}').submit();">
                                                    <i class="icon-checkmark-circle"></i>
                                                    <span>{{ __('lang.button_activate') }}</span>
                                                </a>

                                                <form id="activate-form_{{ $user->id }}" action="{{ route('users.activate', ['user' => $user]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>

                                            @elseif($user->status == 3)
                                                <a href="{{ route('users.unlock', ['user' => $user]) }}"
                                                    class="{{ $user->status == 1 ? 'text-slate-800' : "text-black-50" }}"
                                                    onclick="event.preventDefault(); document.getElementById('unlock-form_{{ $user->id }}').submit();">

                                                    <i class="icon-unlocked"></i>
                                                    <span>{{ __('lang.button_unlock') }}</span>
                                                </a>
                                                <form id="unlock-form_{{ $user->id }}" action="{{ route('users.unlock', ['user' => $user]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            @endif
                                            @can('remover_usuarios', App\Models\User::class)
                                                <a href="{{ route('users.delete-request', ['user' => $user]) }}" class="ml-2 {{ $user->status == 1 ? 'text-danger-400' : "text-black-50" }}">
                                                    <i class="icon-trash"></i>
                                                    <span>{{ __('lang.button_delete') }}</span>
                                                </a>
                                            @endcan

                                        </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
