@extends('layouts.main', ['title' => __('Novo PDE')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="card-block p-3">
                    <h4>
                        <a href="{{ route('app.projectos') }}">{{ 'PEs' }}</a>
                    </h4>

                    {{-- sessions alerts --}}
                    @include('errors.any')
                    {{-- sessions alerts --}}
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <form action="{{ route('pde.store') }}" method="POST">
                                @csrf
                                <pde-form></pde-form>

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
