@extends('layouts.main', ['title' =>  $budgetTracker->name.' - '.__('Tipo de Despesa') .' - '.__('lang.label_budget')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session rows --}}
                    <div>
                        @include('errors.any')
                    </div>
                    {{-- /session rows --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>
                                <a href="{{ route('budget.config.index') }}"> Tipo de Despesa </a> » Editar » {{ $budgetTracker->name }}
                            </h5>
                        </div>
                    </div>

                    <form action="{{ route('budget.config.tracker_update', ['budgetTracker' => $budgetTracker->id]) }}" method="POST">
                        @csrf
                        <div class="row m-0">
                            @include('budget.config.trackers._form')
                        </div>
                        <div class="col pl-0 pt-3 pr-2">
                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_save") }}</button>
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
