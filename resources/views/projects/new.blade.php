@extends('layouts.main', ['title' => __('lang.label_project_new')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="card-block p-3">
                    <h4 class="link-option">
                        @if ($parent->type == 'Project')
                            <a href="{{ route('projects.overview', ['project_identifier' => $parent->identifier]) }}">{{ $parent->name }}</a>
                        @else
                            <a href="{{ route('programs.show', ['program' => $parent->identifier]) }}">{{ $parent->name }}</a>
                        @endif
                    </h4>
                    <h5>
                        {{ __('lang.label_project_new') }}
                    </h5>

                    @include('errors.any')

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('projects.store', ['parent' => $parent->identifier]) }}" method="POST">
                                @csrf
                                <project-form :projects="{{ $projects}}" :programs="{{ $programs}}" :parent="{{ $parent}}"></project-form>
                                @include('projects.custom_fields', ['custom_fields' => $custom_fields, 'is_desabled' => false])
                                @include('projects._otherOptions')
                                <div class="">
                                    <button type="submit">{{ __('lang.button_create') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
