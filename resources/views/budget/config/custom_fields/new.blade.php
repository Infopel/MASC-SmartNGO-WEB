@extends('layouts.main', ['title' =>  __('Tipo de Despesa') .' - '.__('lang.label_budget')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session rows --}}
                    <div>
                        @include('errors.any')
                    </div>
                    {{-- /session rows --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>
                                <a href="{{ route('budget.config.index') }}"> Orçamento </a> » {{ __('Campos Personalizados de Tarefas vs Orçamento') }}
                            </h5>
                        </div>
                    </div>

                    <form action="{{ route('budget.config.cf_store') }}" method="POST">
                        @csrf
                        <div class="row m-0 pt-3">
                            <h5 class="text-black-50">Campos Personalizados - Tarefas</h5>
                            <div class="table-responsive mt-0">
                                <table class="table table-sm table-hover table-striped border">
                                    <thead class="table-active">
                                        <th>Variavel</th>
                                        <th class="text-center">Formato</th>
                                        <th class="text-center">Valores Multiplos</th>
                                        <th class="text-center">Adionado</th>
                                    </thead>

                                    <tbody>
                                        <input type="hidden" name="custom_fields[]">
                                        @foreach ($issues_custom_fields as $custom_field)
                                            <tr>
                                                <td class="p-0 pr-2 pl-2">
                                                    {{ $custom_field->name }}
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    {{ $custom_field->field_format }}
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    @if ($custom_field->multiple)
                                                        <i class="icon-checkmark-circle text-success"></i>
                                                    @endif
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    <input type="checkbox" name="custom_fields[]" value="{{ $custom_field->id }}" {{ in_array($custom_field->id, $used_custom_fields) ? 'checked="checked"' : '' }}/>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col pl-0 pt-3 pr-2">
                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_save") }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
