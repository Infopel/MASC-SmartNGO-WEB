@extends('layouts.main')
@section('content')
<div class="p-2 bg-light m-1">
    <div class="p-2 pl-3 pr-3">
        <div class="col-md-12">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <h4>TimeSheet</h4>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row-md-12 m-0 p-0" style="height: 90vh;">
        <div class="row-md-12 d-flex mb-2">
            <div class="">
                {{-- <select class="form-control w-100" name="requestFundos[TypeSolicitacao]" wire:model="selected_typeSolicitacao_id" required>
                    <option value="null">Selecione a TimeSheet</option>
                    @foreach ($timesheets as $timesheet)
                        <option value="{{ $timesheet->id }}">{{ $timesheet->descrition }}</option>
                    @endforeach
                </select> --}}

            </div>
            <div class="float-right ml-2">
                <a href="{{ route('timesheets.activity.index') }}" class="btn btn-primary form-control">
                    <i class="icon-plus-circle2 icon-sm " style="font-size:90%"></i>
                    <span>{{ __('Actividades A Timesheet') }}</span>
                </a>
            </div>
        

            <div class="float-right ml-2">
                <a href="{{ route('timesheets.new') }}" class="btn btn-success form-control">
                    <i class="icon-plus-circle2 icon-sm" style="font-size:90%"></i>
                    <span>{{ __('Adicionar Timesheet') }}</span>
                </a>
            </div>
            
 
        </div>
        
        <div>
            <table class="table table-striped border table-sm table-hover datatable-show-all1s" style="font-size: 93%">
                <thead class="nowrap bg-slate-600">
                    <th>#</th>
                    <th>{{ __('Descricao') }}</th>
                    <th>{{ __('Autor') }}</th>
                    <th>{{ __('Data de Inicio') }}</th>
                    <th>{{ __('Data de Fim') }}</th>

                </thead>

                <tbody>
                    @foreach ($timesheets as $issue)
                        <tr>
                            <td>
                               
                            </td>
                            <td>
                                {{ $issue->descrition }}
                             </td>
                             <td>
                             @forelse ($users as $user)
                             @if (($issue->user_id)==($user->id))
                                   {{ $user->fullname }}
                             @endif 
                             @empty
                                 Não Tem autor
                             @endforelse
                             
                             </td>
                             <td>
                                {{ $issue->data_inicio }}
                             </td>
                             <td>
                                {{ $issue->data_fim }}
                             </td>
                         
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
   
</div>

@endsection