@extends('layouts.main', ['title' => "Gantt -". $_project['name'] ?? 'MASC'])
@section('content')
    <div class="row m-0 p-2" style="height:800px">
        <div class="col-md-12 h-100">
            <div class="row h-100">
                <div class="card-block">

                    <div class="p-2">
                        <h4>
                            <a href="{{ route('gantt.index') }}">{{ 'Gantt' }}</a> » <a href="#">{{ $_project['name'] ?? null}}</a>
                        </h4>
                    </div>

                    <gantt style="height:100%" :project="'{{ $_project['identifier']}}'"></gantt>

                </div>
            </div>
        </div>
    </div>
@endsection
