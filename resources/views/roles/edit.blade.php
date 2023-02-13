@extends('layouts.main', ['title' => $role->name.' - '.__('lang.label_role_plural') ])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        @include('errors.any')
                        {{-- /session rows --}}

                        <h5><a href="{{ route('roles.index') }}">{{ __('lang.label_role_plural') }}</a> » {{ $role->name }}</h5>

                        <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                @include('roles._form')
                                @include('roles.permissions')
                                @can('atualizar_permissoes', [App\Models\Roles::class, $role])
                                    <div class="col pl-3 pt-3 pr-2">
                                        <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_update") }}</button>
                                    </div>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
