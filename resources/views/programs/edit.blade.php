@extends('layouts.main', ['title' => __('lang.label_project_new')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="card-block p-3">
                    <h4>
                        <a href="{{ route('programs.index') }}">{{ 'Programas' }}</a> » {{ __('lang.button_edit')}} »{{ $program->name }}
                    </h4>
                    {{-- sessions alerts --}}
                    @include('errors.any')
                    {{-- sessions alerts --}}
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <form action="{{ route('programs.update', ['program' => $program->identifier]) }}" method="POST">
                                @csrf
                                <program-form :content="{{ $program }}"></program-form>
                                <div class="">
                                    <button type="submit">{{ __('lang.button_update') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
