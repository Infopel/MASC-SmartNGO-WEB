@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 bg-white p-3">
                    <h4>{{ __('lang.label_settings') }}</h4>
                    <div class="mt-3">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link link-option active" id="nav-info-proejct" data-toggle="tab" href="#nav-info" role="tab" aria-controls="nav-home" aria-selected="true">Informações</a>
                                <a class="nav-item nav-link link-option" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Módulos</a>
                                <a class="nav-item nav-link link-option" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Membros</a>
                                <a class="nav-item nav-link link-option" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Versões</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-info" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
