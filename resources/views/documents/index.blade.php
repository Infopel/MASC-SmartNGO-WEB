@extends('layouts.main', ['title' => __('lang.label_document_plural'). ' - '.$project->name])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-9">
            <div class="row h-100">
                <div class="col-md-12 bg-white pb-4">
                    <div class="d-flex pt-3 mb-0">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_document_plural') }}</h5>
                        </div>
                        <div class="text-capitalize ">
                            <a href="{{ route('document.create', ['project_identifier' => $_project['identifier']]) }}" class="text-success">
                                <i class="icon-plus2" style="font-size: 90%"></i>
                                <span>Novo document</span>
                            </a>
                        </div>
                    </div>
                    <hr class="mt-0 mb-3">
                    @foreach ($project->documents as $key => $document)
                        <div id="accordion">
                            <div class="border">
                                <div class="bg-light rounded d-flex" id="headingOne">
                                    <h5 class="mb-0 flex-grow-1">
                                        <button class="btn btn-link text-body" data-toggle="collapse" data-target="#{{ $key }}" aria-expanded="true" aria-controls="{{ $key }}">
                                            {{ $key }}
                                        </button>
                                    </h5>
                                    <div class="">
                                        <h6 class="mb-0 mt-2 mr-2 text-black-50">
                                            <span class="p-2">{{ \sizeof($document) }} Registro(s)</span>
                                        </h6>
                                    </div>
                                </div>

                                <div id="{{ $key }}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        @foreach ($document as $item)
                                            <div class="border-bottom">
                                                <div class="proj-desc">
                                                    <h5>
                                                        <a href="{{ route('documents.show', ['document' => $item->id]) }}" class="link-option">{{ $item->title }}</a>
                                                    </h5>
                                                    <div class="text-black-50">
                                                        {!! $item->description?:"Nodescription" !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if ($project['documents'] == [])
                        <div class="alert-warning p-1 text-center border">
                            Sem dados para mostrar
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 border-left aside-panel">
                    <div class="">
                        <h5>{{ __('lang.label_sort_by', ['value' => null]) }}</h5>
                    </div>
                    <div class="options">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
