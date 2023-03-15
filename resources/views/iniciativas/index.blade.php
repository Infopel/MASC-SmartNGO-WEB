@extends('layouts.main')
@section('content')

    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 bg-white p-3">
                    <div class="m-0">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>Iniciativas</h5>
                            </div>
                            {{-- <div class="text-lowercase">
                                <a href="#" class="text-success">
                                    <i class="icon-plus2"></i>
                                    <span>Nova actividade</span>
                                </a>
                            </div> --}}
                        </div
                    </div>
                    <div class="m-0">
                        <div class="table-responsive">
                            <table class="table-striped table-sm table-hover datatable-show-all table border"
                                style="font-size: 93%">
                                <thead class="nowrap bg-slate-600">
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Assunto</th>
                                    <th>Estado</th>
                                    <th>Prioridade</th>
                                    <th>Atribuído para</th>
                                    <th class="text-center">Aprovado</th>
                                    <th>Alterado em</th>
                                </thead>

                                <tbody>
                                    @foreach ($iniciativas as $item)
                                    <tr class="p-2 pl-2 pr-2">
                                        <td> {{ $item->nome }} </td>
                                        <td> {{ $item->bairro }} </td>
                                        <td> {{ $item->dataConstituicao }} </td>
                                        <td> {{ $item->idResponsavel }} </td>
                                        <td> {{ $item->idMobilizador }} </td>
                                        <td> {{ $item->tipoIniciativa }} </td>
                                        <td> {{ $item->project_id }} </td>
    
                                        <td>
                                            <form action="{{ route('iniciativas.destroy', $item->id) }}" method="POST">
    
                                                <a type="button" class="text-success-400 fw-400 ml-2">
                                                    <i class="icon-eye"></i>
                                                    <span>{{ __('lang.button_view') }}</span>
                                                </a>
                                                <a type="button" class="text-success-400 fw-400 ml-2"
                                                    href="{{ route('iniciativas.edit', $item->id) }}">
                                                    <i class="icon-pencil5"></i>
                                                    <span>{{ __('lang.button_edit') }}</span>
                                                </a>
    
                                                @csrf
                                                @method('DELETE')
                                                <a type="submit" class="text-danger-400 fw-400 ml-2">
                                                    <i class="icon-trash"></i>
                                                    <span>{{ __('lang.button_delete') }}</span>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
    
                                @if ($iniciativas->count() < 1)
                                    <tr>
                                        <td colspan=4>
                                            <div class="alert-warning text-black-50 rounded border p-1 text-center">
                                                {{ __('lang.label_no_data') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination-sm pt-2">
                            <span class="text-black-50">
                                (1-1/1)
                            </span>

                        </div>
                    </div>
                </div>
            @endsection
