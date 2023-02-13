@extends('layouts.main', ['title' => "Gantt"])
@section('content')
    <div class="row m-0 p-2" style="height:100vh">
        <div class="col-md-12">
            <div class="row" style="height:100vh">
                <div class="card-block" style="height:100vh">
                    <div class="p-2">
                        <h4>
                            <a href="{{ route('gantt.index') }}">{{ 'Gantt' }}</a>
                        </h4>
                    </div>
                    <gantt style="height:95%"></gantt>
                </div>
            </div>
        </div>
    </div>
@endsection
