@extends('layouts.main', ['title' => __('lang.label_settings').' - '.__('lang.label_administration') ])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8">
            <div class="row h-100">
                <div class="card-block p-3">
                    <h5>{{ __('lang.label_settings') }}</h5>

                    {{-- session rows --}}
                    <div class="w-100">
                        @if (session('status'))
                            <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                <i class="icon-checkmark"></i>
                                {{ session('status') }}
                            </div>
                        @elseif(session('erros'))
                            <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-danger">
                                <i class="icon-warning2"></i>
                                {{ session('erros') }}
                            </div>
                        @endif
                    </div>
                    {{-- /session rows --}}

                    <div class="">
                        <nav>
                            <div class="nav nav-tabs mb-2" id="nav-tab" role="tablist">

                                <a class="nav-item nav-link link-option active" id="general" data-toggle="tab" href="#tab-general" role="tab" aria-controls="tab-general" aria-selected="true">{{ __('lang.label_general') }}</a>

                                <a class="nav-item nav-link link-option" id="display" data-toggle="tab" href="#tab-display" role="tab" aria-controls="tab-display" aria-selected="true">{{ __('lang.label_display') }}</a>

                                {{-- <a class="nav-item nav-link link-option" id="authentication" data-toggle="tab" href="#tab-authentication" role="tab" aria-controls="tab-authentication" aria-sted="true">{{ __('lang.label_authentication') }}</a> --}}

                                {{-- <a class="nav-item nav-link link-option" id="api" data-toggle="tab" href="#tab-api" role="tab" aria-controls="tab-api" aria-sted="true">{{ __('lang.label_api') }}</a> --}}

                                {{-- <a class="nav-item nav-link link-option" id="project" data-toggle="tab" href="#tab-project" role="tab" aria-controls="tab-project" aria-sted="true">{{ __('lang.label_project_plural') }}</a> --}}

                                {{-- <a class="nav-item nav-link link-option" id="issue_tracking" data-toggle="tab" href="#tab-issue_tracking" role="tab" aria-controls="tab-issue_tracking" aria-cted="true">{{ __('lang.label_issue_tracking') }}</a> --}}

                                {{-- <a class="nav-item nav-link link-option" id="time_tracking" data-toggle="tab" href="#tab-time_tracking" role="tab" aria-controls="tab-time_tracking" aria-sele="true">{{ __('lang.label_time_tracking') }}</a> --}}

                                {{-- <a class="nav-item nav-link link-option" id="attachments" data-toggle="tab" href="#tab-attachments" role="tab" aria-controls="tab-attachments" aria-seld="true">{{ __('lang.label_attachment_plural') }}</a> --}}

                                <a class="nav-item nav-link link-option" id="mail_notification" data-toggle="tab" href="#tab-mail_notification" role="tab" aria-controls="tab-mail_notification" aria-selected="true">{{ __('lang.field_mail_notification') }}</a>

                                {{-- <a class="nav-item nav-link link-option" id="incoming_emails" data-toggle="tab" href="#tab-incoming_emails" role="tab" aria-controls="tab-incoming_emails" aria-selected="true">{{ __('lang.label_incoming_emails') }}</a> --}}

                                {{-- <a class="nav-item nav-link link-option" id="repository" data-toggle="tab" href="#tab-repository" role="tab" aria-controls="tab-repository" aria-selected="true">{{ __('lang.label_repository_plural') }}</a> --}}

                            </div>
                        </nav>

                        <div class="tab-content table-responsive" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="tab-general" role="tabpanel" aria-labelledby="general">
                                @include('settings._general')
                            </div>

                            <div class="tab-pane fade" id="tab-display" role="tabpanel" aria-labelledby="display">
                                @include('settings._display')
                            </div>

                            {{-- <div class="tab-pane fade" id="tab-authentication" role="tabpanel" aria-labelledby="authentication">
                                @include('settings._authentication')
                            </div> --}}

                            {{-- <div class="tab-pane fade" id="tab-api" role="tabpanel" aria-labelledby="api">
                                @include('settings._api')
                            </div> --}}

                            {{-- <div class="tab-pane fade" id="tab-project" role="tabpanel" aria-labelledby="api">
                                @include('settings._project')
                            </div> --}}

                            {{-- <div class="tab-pane fade" id="tab-issue_tracking" role="tabpanel" aria-labelledby="api">
                                @include('settings._issues')
                            </div> --}}

                            <div class="tab-pane fade" id="tab-time_tracking" role="tabpanel" aria-labelledby="time_tracking">
                                @include('settings._issues')
                            </div>

                            <div class="tab-pane fade" id="tab-attachments" role="tabpanel" aria-labelledby="attachments">
                                @include('settings._attachments')
                            </div>

                            <div class="tab-pane fade" id="tab-mail_notification" role="tabpanel" aria-labelledby="mail_notification">
                                @include('settings._notifications')
                            </div>

                            <div class="tab-pane fade" id="tab-incoming_emails" role="tabpanel" aria-labelledby="incoming_emails">
                                @include('settings._mail_handler')
                            </div>

                            <div class="tab-pane fade" id="tab-repository" role="tabpanel" aria-labelledby="repository">
                                repository
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
