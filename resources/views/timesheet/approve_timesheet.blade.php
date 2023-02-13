@extends('layouts.main')
@section('content')
    <div class="col-md-6">
        <div class="card-block w-100 border-left aside-panel p-3">
            <div class="">
                <div class="text-black-50 small m-0 mb-1 p-0 text-left" style="background: none">
                    <h5 class="text-semibold">
                        <i class="icon-history position-left" style="background: #e7eaec; z-index: 1;"></i>
                        FLUXO DE TIMESHEET
                    </h5>
                </div>
            </div>
        </div>

        <div class="row-md-12 d-flex mb-2">
            <div class="">

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
        @foreach ($members as $member)
            @if ($member->user_id == auth()->user()->id)
                @foreach ($actividades as $actividade)
                    @foreach ($ts_workflows as $ts_workflow)
                        @foreach ($approvement_flow as $item)
                            @if (
                                $ts_workflow->next_flow == $item->id ||
                                    ($ts_workflow->flow_id == $item->id && $ts_workflow->project_id == $actividade->project_id))
                                <div class="mt-2">
                                    <table class="table-sm borderless table w-auto border-0" style="font-size: 85%">
                                        <tbody>
                                            <tr>
                                                <td class="border-right border-top-0 fw-600 p-0 pl-2 pr-2">Aprovado
                                                    por:
                                                </td>
                                                <td class="border-top-0 fw-500 text-capitalize p-0 pl-2 pr-2">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-500 p-0 pl-2 pr-2">
                                                    Categoria:
                                                </td>
                                                <td class="border-top-0 fw-500 p-0 pl-2 pr-2">
                                                    {{ $item->description }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-right border-top-0 fw-500 p-0 pl-2 pr-2">Data de
                                                    Aprovação:</td>
                                                <td class="border-top-0 fw-500 text-muted p-0 pl-2 pr-2">
                                                    {{ $ts_workflow->approved_on }}
                                                </td>
                                            </tr>
                                            @if ($ts_workflow->is_approved == true)
                                                <tr>
                                                    <td class="border-right border-top-0 fw-500 p-0 pl-2 pr-2">Status:
                                                    </td>
                                                    <td class="border-top-0 fw-500 text-success p-0 pl-2 pr-2">
                                                        Aprovado
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td class="border-right border-top-0 fw-500 p-0 pl-2 pr-2">Status:
                                                    </td>
                                                    <td class="border-top-0 fw-500 text-danger p-0 pl-2 pr-2">
                                                        Pendente
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            @endif
        @endforeach
    </div>
@endsection
