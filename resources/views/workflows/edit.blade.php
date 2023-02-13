@extends('layouts.main', ['title' => __('lang.label_workflow') ])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        @include('errors.any')
                        {{-- /session rows --}}




                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5 class="fw-500">
                                    {{ __('lang.label_workflow') }}
                                </h5>
                            </div>

                            <div class="mt-3">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link link-option active" id="nav-info-proejct" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-info" aria-selected="true">Informações</a>
                                    </div>
                                </nav>
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
