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
                                <h5 class="fw-600">
                                    <a href="{{ route('workflow.index') }}">{{ __('lang.label_workflow') }}</a> » {{ __('lang.label_workflow') }}
                                </h5>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-sm table-striped">
                                <thead class="table-active">
                                    
                                </thead>
                            </table>
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
