@extends('layouts.main', ['title' => "Calendário -". $_project['name'] ?? 'MASC'])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12 h-100">
            <div class="row h-100">
                <div class="card-block">
                    <div class="p-2">
                        <h5>
                            <a href="{{ route('gantt.index') }}">{{ 'Calendário' }}</a> » <a href="#">{{ $_project['name'] ?? null}}</a>
                        </h5>
                    </div>
                    <calendar :events_data="{{ json_encode($events) }}"></calendar>
                </div>
            </div>
        </div>
    </div>
@endsection
