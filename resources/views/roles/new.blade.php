@extends('layouts.main', ['title' => 'New - '.__('lang.label_role_plural') ])
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


                        <h5><a href="{{ route('roles.index') }}">{{ __('lang.label_role_plural') }}</a> » {{ __('lang.label_role_plural') }}</h5>

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                @include('roles._form')
                                @include('roles.permissions')
                                <div class="col pl-3 pt-3 pr-2">
                                    <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                                </div>
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
