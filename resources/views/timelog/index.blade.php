@extends('layouts.main', ['title' => __('lang.label_spent_time')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="card-block p-3" style="min-height: 70vh">
                    <div class="header border-bottom">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>
                                    <a href="#">{{ __("lang.label_spent_time") }}</a>
                                </h5>
                            </div>

                            <div class="">
                                <a href="{{ route('time_entries.new') }}">
                                    <i class="icon-add-to-list"></i>
                                    Nova Entrada
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- session rows --}}
                    <div class="">
                        @include('errors.any')
                    </div>
                    {{-- /session rows --}}

                    <div class="w-100">
                        @if (session('isRemoveTrue'))
                            <div class="alert alert-warning">
                                <h5>
                                    <b>{{ session('isRemoveTrue')['msg'] }}</b>
                                </h5>
                                <div>
                                    <h6>{{ __('lang.button_delete').' '.__('lang.label_spent_time') }} com atividade: <b>{{ session('isRemoveTrue')['actividade'] }}</b>
                                        <br>
                                        Tarefa: <b>{{ session('isRemoveTrue')['issue'] }}</b>
                                        <br>
                                        IndexID: <b>{{ session('isRemoveTrue')['time_entry_id'] }}</b>
                                    <h6>
                                    <form method="POST" action='{{ route('time_entries.remove', ['time_entry'=> session('isRemoveTrue')['time_entry_id'] ]) }}'>
                                        @csrf
                                        <input name="enumeration" value="{{ session('isRemoveTrue')['time_entry_id'] }}" type="hidden">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-2">
                        <div class="table-responsive border">
                            <table class="table table-sm table-striped table-hover" style="font-size: 95%">
                                <thead class="table-active text-nowrap">
                                    <th class="fw-600">ID</th>
                                    @if (Route::is('time_entries.index'))
                                        <th class="fw-600">Projecto</th>
                                    @endif
                                    <th class="fw-600 text-center">Data</th>
                                    <th class="fw-600 text-center">User</th>
                                    <th class="fw-600 text-center">Atividade</th>
                                    <th class="fw-600 text-center">Tarefa</th>
                                    <th class="fw-600 text-center">Comentario</th>
                                    <th class="fw-600 text-center">Horas</th>
                                    <th class="fw-600 text-center"></th>
                                </thead>

                                <tbody>
                                    @foreach ($timelogs as $timelog)
                                        <tr>
                                            <td>
                                                {{ $timelog->id }}
                                            </td>
                                            @if (Route::is('time_entries.index'))
                                                <td class="p-0 pl-2 pr-2">
                                                    <a href="{{ route('projects.overview', ['project_identifier' => $timelog->project->identifier]) }}">
                                                    {{ $timelog->project->name }}
                                                    </a>
                                                </td>
                                            @endif
                                            <td class="p-0 pl-2 pr-2 text-center text-nowrap">
                                                <a href="{{ route('time_entries.issues', ['issue' => $timelog['issue']['id'] ?? 002 ]) }}">
                                                    {{ $timelog->created_on }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                <a href="{{ route('users.show', $timelog->user->id) }}">
                                                    {{ $timelog->user->full_name }}
                                                </a>
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                {{ $timelog->atividade->name }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                <span class="text-black-50">{{ $timelog->issue->tracker->name }}</span> -
                                                {{ $timelog->issue->subject }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2">
                                                {{ $timelog->comments }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-center">
                                                {{ $timelog->hours }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-right text-nowrap">
                                                {{-- <a href="#" class="text-primary">
                                                    <i class="icon-pencil5"></i>
                                                </a> --}}
                                                <a href="{{ route('time_entries.remove_request', ['time_entry' => $timelog->id]) }}" class="text-danger">
                                                    <i class="icon-trash"></i>
                                                    Remover
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
