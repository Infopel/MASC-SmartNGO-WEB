@extends('layouts.main', ['title' => __('lang.label_project_new')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="card-block p-3">
                    <h4 class="link-option">
                        PE: <a href="{{ route('projects.overview', ['project_identifier' => $project ? $project->identifier : 'undefined']) }}">{{ $project->name }}</a>
                    </h4>
                    <h5>
                        <a href="{{ route('programs.index') }}" class="text-black-50">{{ 'Nova Linha Estratégica' }}</a>
                    </h5>

                    {{-- sessions alerts --}}
                    @include('errors.any')
                    {{-- sessions alerts --}}
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <form action="{{ route('programs.create', ['project_identifier' => $project->identifier]) }}" method="POST">
                                @csrf
                                <program-form></program-form>

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
