@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">
                    <h5><a href="{{ route('tracker.index') }}">{{ __('lang.label_tracker_plural') }}</a> » {{ __('lang.label_tracker_new') }}</h5>

                    <form action="{{ route('tracker.update', ['tracker' => $tracker->id]) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-light p-2 border">
                                    @include('trackers._form')
                                </div>
                            </div>
                            <div class="col-md-6">
                                <fieldset class="border pl-3 pr-3 pt-2 bg-light">
                                    <legend class="pl-0 pr-2 p-0 m-0 w-auto text-capitalize">{{ __('lang.label_project_plural') }}</legend>
                                    @include('trackers._projects')
                                </fieldset>
                            </div>
                        </div>

                        @can('gerir_tipos_tarefas', App\Models\User::class)
                            <div class="pt-2">
                                <button type="submit" class="mr-2">{{ __("lang.button_update") }}</button>
                            </div>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
