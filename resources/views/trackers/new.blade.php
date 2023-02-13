@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block pt-3 p-0 rounded">

                    <div class="pl-3 pr-3 pb-0">
                        @include('errors.any')
                    </div>

                    <h5 class="ml-3"><a href="{{ route('tracker.index') }}">{{ __('lang.label_tracker_plural') }}</a> » {{ __('lang.label_tracker_new') }}</h5>

                    <form action="{{ route('tracker.store') }}" method="POST">
                        @csrf
                        <div class="row m-0">
                            <div class="col-md-6">
                                <div class="bg-light p-2 border">
                                    @include('trackers._form')
                                </div>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="bg-light pl-3 p-2 border">
                                    <legend class="w-auto mb-0 p-0"><i class="icon-checkmark5 text-success"></i>{{ __('lang.label_project_plural') }}</legend>
                                    @include('trackers._projects')
                                    <p>
                                        <a href="#" onclick="checkAll('tracker_project_ids', true); return false;">Marcar todos</a> |
                                        <a href="#" onclick="checkAll('tracker_project_ids', false); return false;">Desmarcar todos</a>
                                    </p>
                                </fieldset>
                            </div>
                        </div>

                        <div class="pl-3 pt-2">
                            <button type="submit" class="mr-2">{{ __("lang.button_create") }}</button>
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
