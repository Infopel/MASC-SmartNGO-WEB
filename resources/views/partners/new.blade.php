@extends('layouts.main', ['title' => __('lang.label_partner_new').' - '.__('lang.label_partner_plural') ])
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
                        {{-- session rows --}}

                        <h5><a href="{{ route('partners.index') }}">{{ __('lang.label_partner_plural') }}</a> » {{ __('lang.label_partner_new') }}</h5>

                        <div class="">
                            <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @include('partners._form', ['custom_fields' => $custom_fields, 'is_desabled' => false])
                                    <div class="col pl-3 pt-3 pr-2">
                                        <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                                    </div>
                                </div>
                            </form>
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
