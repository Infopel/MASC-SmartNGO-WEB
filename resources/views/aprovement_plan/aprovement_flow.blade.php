@extends('layouts.main')
@section('content')
    <div class="row m-0 p-0 pt-2">
        <div class="col-lg-2 col-md-4" style="min-height: 70vh">
            @include('aprovement_plan._menu')
        </div>

        <div class="col-lg-10 col-md-12">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">
                    {{-- session handler --}}
                    @include('errors.any')
                    {{-- session handler --}}

                    @livewire($viewComponentName ?? 'unknownComponentName')
                </div>
            </div>
        </div>
    </div>
@endsection
