@extends('layouts.main')
@section('content')
    <div class="row m-0 p-0 pt-2">
        <div class="col-lg-3 col-md-4" style="min-height: 70vh">
            @include('admin.bugs._menu')
        </div>

        <div class="col-lg-9 col-md-8">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">
                    <h5>{{ $componentTitle }}</h5>

                    {{-- session handler --}}
                    @include('errors.any')
                    {{-- session handler --}}

                    @livewire($viewComponentName ?? 'unknownComponentName')
                </div>
            </div>
        </div>
    </div>
@endsection
