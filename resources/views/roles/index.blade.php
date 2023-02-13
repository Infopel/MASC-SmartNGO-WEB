@extends('layouts.main', ['title' => __('lang.label_role_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- Actions Notifications --}}
                    @include('errors.any')
                    {{-- /Actions Notifications --}}
                    <div class="w-100">
                        @if (session('isRemoveTrue'))
                            <div class="alert alert-warning">
                                {{ session('isRemoveTrue')['msg'] }}
                                <div>
                                    <h6>{{ __('lang.button_delete').' '.__('lang.label_role') }}: <b>{{ session('isRemoveTrue')['role_name'] }}</b><h6>
                                    <form method="POST" action='{{ route('roles.remove', ['role'=> session('isRemoveTrue')['role_id'] ]) }}'>
                                        @csrf
                                        <input name="role" value="{{ session('isRemoveTrue')['role_id'] }}" type="hidden">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex border-bottom">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_role_plural') }}</h5>
                        </div>
                        <div class="text-lowercase">
                            <a href="{{ route('global_roles.index') }}" class="text-primary">
                                <i class="icon-list2"></i>
                                <span>{{ __('Permissões Globais') }}</span>
                            </a>
                            @can('criar_permissoes', App\Models\Roles::class)
                                <a href="{{ route('roles.new') }}" class="text-success">
                                    <i class="icon-plus2"></i>
                                    <span>{{ __('lang.label_role_new') }}</span>
                                </a>
                            @endcan
                        </div>
                    </div>
                    {{-- <fieldset class="border p-3 pt-0">
                        <legend class="pl-2 pr-2 p-0 m-0 w-auto">Filstros</legend>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="">Situação</label>
                                <select name="" class="form-control form-control-sm pr-3">
                                    <option value="">Activo</option>
                                </select>
                            </div>
                        </div>
                    </fieldset> --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-striped table-hover border nowrap">
                            <thead class="table-active ">
                                <th>{{ __('lang.label_role') }}</th>
                                <th style="min-width: 80px;"></th>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr class="{{ $role->status == 1 ? '' : "text-black-50" }}">
                                        @if ($role->default)
                                            <td class="p-0 pl-2 pr-2">
                                                <a disabled href="#">
                                                    <i>{{ $role->name }}</i>
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2"></td>
                                        @else
                                            <td class="p-0 pl-2 pr-2">
                                                <a href="#" onclick="return;">
                                                    {{ $role->name }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-right">
                                                @can('atualizar_permissoes', [App\Models\Roles::class, $role])
                                                    <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="ml-2">
                                                        <i class="icon-pencil5"></i>
                                                        <span>{{ __('lang.button_edit') }}</span>
                                                    </a>
                                                @endcan
                                                @can('excluir_permissoes', [App\Models\Roles::class, $role])
                                                    <a href="{{ route('roles.remove_permission', ['role' => $role->id]) }}" class="ml-2 text-danger">
                                                        <i class="icon-trash"></i>
                                                        <span>{{ __('lang.button_delete') }}</span>
                                                    </a>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $roles }} --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
