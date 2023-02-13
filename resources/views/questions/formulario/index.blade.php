@extends('layouts.main', ['title' => __('Formulario de Avaliação').' de '.__('lang.label_partner_plural') ])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        @include('errors.any')
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>
                                    <a href="{{ route('questionnaire.models.index') }}">
                                        {{ __('Modelo de Avaliação') }}
                                    </a> » {{ __('Novo formulario de avaliação') }}
                                </h5>
                            </div>
                        </div>

                        <div class="">
                             <form action="{{ route('questionnaire.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="">
                                            Ano
                                            <input type="text" class="form-control form-control-sm">
                                        </label>
                                    </div>
                                    <div class="col-md-12 box tabular" id="permissions" style="font-size:90%">
                                        @foreach ($questionnaireCategories as $category)
                                            <fieldset class="border pl-3 pr-3 pt-2 mb-2">
                                                <legend class="pl-2 pr-2 p-0 m-0 w-auto text-capitalize text-back-50">{{ $category->name }}</legend>
                                                @foreach ($category->questions as $question)
                                                    @include('questions.formulario._form')
                                                @endforeach

                                                @if ($category->questions->count() <= 0)
                                                    <center class="text-center mb-2">
                                                        {{ __('lang.label_no_data') }}
                                                    </center>
                                                @endif
                                            </fieldset>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col pl-0 pt-3 pr-2">
                                    {{-- <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_save") }}</button> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 aside-panel">
                    -
                </div>
            </div>
            {{-- @include('admin._menu') --}}
        </div>
    </div>
@endsection
