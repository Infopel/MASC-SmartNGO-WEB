@extends('layouts.main', ['title' =>  __('lang.label_enumeration_new') .' - '.__('lang.label_enumerations')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session rows --}}
                    <div class="">
                        @include('errors.any')
                    </div>
                    {{-- /session rows --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>
                                <a href="{{ route('enumerations.index') }}">{{ $enumeration['type'] }}</a> »
                                {{ __('lang.label_enumeration_new') }}
                            </h5>
                        </div>
                    </div>

                    <form action="{{ route('enumerations.update', ['enumeration' => $enumeration->id]) }}" method="POST">
                        @csrf
                        <div class="row m-0">
                            @include('enumerations._form')
                        </div>
                        <div class="col pl-0 pt-3 pr-2">
                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_update") }}</button>
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
