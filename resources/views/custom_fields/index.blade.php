@extends('layouts.main', ['title' => __('lang.label_custom_field_plural')])
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
                                    <h6>{{ __('lang.label_custom_field') }}: <b>{{ session('isRemoveTrue')['custom_field_name'] }}</b><h6>
                                    <form method="POST" action='{{ route('custom_fields.remove', ['custom_field'=> session('isRemoveTrue')['custom_field_id'] ]) }}'>
                                        @method('post')
                                        @csrf
                                        <input name="id_estudante" value="{{ session('isRemoveTrue')['custom_field_id'] }}" type="hidden">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
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
                            <h5>{{ __('lang.label_custom_field_plural') }}</h5>
                        </div>
                        @can('cadastrar_campos_personalizados', App\Models\User::class)
                            <div class="text-lowercase mr-2">
                                <a href="{{ route('custom_fields.new') }}" class="text-success">
                                    <i class="icon-plus2"></i>
                                    <span>{{ __('lang.label_custom_field_new') }}</span>
                                </a>
                            </div>
                        @endcan
                    </div>

                    <div class="">
                        @include('custom_fields._index')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
