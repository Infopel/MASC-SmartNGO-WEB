@extends('layouts.main', ['title' =>  __('lang.label_issue_status_new') .' - '.__('lang.label_issue_status_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 mr-0 rounded">
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

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>
                                <a href="{{ route('issue_statuses.index') }}">{{ __('lang.label_issue_status_plural') }}</a> »
                                {{ __('lang.label_issue_status_new') }}
                            </h5>
                        </div>
                    </div>

                    <form action="{{ route('issue_statuses.store') }}" method="POST">
                        @csrf
                        <div class="row m-0">
                            @include('issue_statuses._form')
                        </div>
                        <div class="col pl-0 pt-3 pr-2">
                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
