@extends('layouts.main', ['title' => __('lang.label_new_timesheet')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="card-block p-3">
                    <h5>
                        {{ __('lang.label_new_timesheet') }}
                    </h5>

                    @include('errors.any')

                    <div class="row">
                        <div class="col-md-12">
                            {{-- , ['parent' => $parent->identifier] --}}
                            <form action="{{ route('timesheets.store') }}" method="POST">
                                @csrf
                                @include('timesheet._form')
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
