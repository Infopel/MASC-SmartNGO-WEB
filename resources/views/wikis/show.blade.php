@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-9">
            <div class="row h-100">
                <div class="col-md-12 bg-white p-3">
                    <div class="d-md-flex mb-0">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_wiki') }}</h5>
                        </div>
                        <div class="text-capitalize ">
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="text-option mr-2">
                                <i class="icon-plus2" style="font-size: 90%"></i>
                                <span>Nova Pagina Wiki</span>
                            </a>
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="link-option mr-2">
                                <i class="icon-pencil5" style="font-size: 90%"></i>
                                <span>Editar</span>
                            </a>
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="link-option mr-2">
                                <i class="icon-star-empty3" style="font-size: 90%"></i>
                                <span>Observar</span>
                            </a>
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="text-danger link-option mr-2">
                                <i class="icon-lock2" style="font-size: 90%"></i>
                                <span>Bloquear</span>
                            </a>
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="link-option mr-2">
                                <i class="icon-pencil5" style="font-size: 90%"></i>
                                <span>Renomear</span>
                            </a>
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="link-option mr-2">
                                <i class="icon-trash" style="font-size: 90%"></i>
                                <span>Excluir</span>
                            </a>
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="link-option mr-2">
                                <i class="icon-history" style="font-size: 90%"></i>
                                <span>Histórico</span>
                            </a>
                        </div>
                    </div>
                    <hr class="mt-0 mb-3">


                    {{-- @if ($data['documents'] == [])
                        <div class="alert-warning p-1 text-center border">
                            Sem dados para mostrar
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 border-left aside-panel">
                    <div class="">
                        <h5>{{ __('lang.label_wiki') }}</h5>
                    </div>
                    <div class="options">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
