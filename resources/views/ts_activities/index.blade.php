@extends('layouts.main')
@section('content')
    <div class="bg-light m-1 p-2">
        <div class="p-2 pl-3 pr-3">
            <div class="col-md-12">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h4>ACTIVIDADES TIMESHEET</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="row-md-12 m-0 p-0" style="height: 90vh;">
                    <div class="row-md-12 d-flex mb-2">

                        <div class="row">


                            <form action="{{ route('app.approve_timesheet') }}" method="POST">

                                @csrf
                                <div class="row-md-12 d-flex mb-2">
                                    <div>
                                        
                                        <select class="form-control w-100" name="timesheet[activite]"
                                            oninvalid="this.setCustomValidity('Selecione uma Actividade Válido')"
                                            oninput="setCustomValidity('')" style="with:60%" required>
                                            <option value="">Selecione a Actividade</option>
                                            @foreach ($tsactivity as $item)
                                                <option value="{{ $item->id }}">{{ $item->descrition }}</option>
                                               
                                                @endforeach
                                        </select>
                                        {{-- <input type="hidden" value="{{ $item->project_id }}" name="timesheet[project_id]"> --}}
                                    </div>

                                    <div class="float-right ml-2 mr-3">
                                        <button type="submit" class="btn btn-primary form-control"
                                            value="submeter">Submeter no Fluxo</button>
                                    </div>
                            </form>
                        </div>
                    </div>

                    <div class="float-right ml-2 ">
                        <a href="{{ route('app.timesheets') }}" class="btn btn-primary form-control">
                            <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                            <span>{{ __('Timesheets') }}</span>
                        </a>
                    </div>

                    <div class="float-right ml-2">
                        <a href="{{ route('timesheets.activity.new') }}" class="btn btn-success form-control">
                            <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                            <span>{{ __('Adicionar Actividade') }}</span>
                        </a>
                    </div>

                    {{-- <div class="float-right ml-2">
                    <a href="{{ route('app.timesheets_approve') }}" class="btn btn-info form-control">
                        <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                        <span>{{ __('Submeter timesheet') }}</span>
                    </a>
                </div> --}}
                </div>

                <div>
                    <table class="table-striped table-sm table-hover datatable-show-all1s table border"
                        style="font-size: 93%">
                        <thead class="nowrap bg-slate-600">
                            <th>#</th>
                            <th>{{ __('Descricao') }}</th>
                            <th>{{ __('Nr de Horas') }}</th>
                            <th>{{ __('Resultados') }}</th>
                            <th>{{ __('Constragimentos') }}</th>
                            <th>{{ __('Actividade') }}</th>
                            <th>{{ __('Projecto') }}</th>
                            <th>{{ __('Data') }}</th>
                        </thead>

                        <tbody>
                            @foreach ($tsactivity as $issue)
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        {{ $issue->descrition }}
                                    </td>
                                    <td>
                                        {{ $issue->nr_horas }}
                                    </td>
                                    <td>
                                        {{ $issue->resultado }}
                                    </td>
                                    <td>
                                        {{ $issue->constragimentos }}
                                    </td>
                                    <td>

                                        @foreach ($actividade as $item)
                                            @if ($item->tag_code == $issue->tag_code_ts)
                                                {{ $item->descrition }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @forelse ($projects as $project)
                                            @if ($issue->project_id == $project->id)
                                                {{ $project->name }}
                                            @endif
                                        @empty
                                            "Não foi encontrado nenhum projecto"
                                        @endforelse


                                        {{ $issue->project_id }}
                                    </td>
                                    <td>
                                        {{ $issue->data }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-3 bg-secondary">
            <div class="row h-100">
                @include('timesheet.timesheet_flow', [
                    'issue' => $issue->project_id,
                ])
            </div>
        </div> --}}
    </div>
    </div>
@endsection
