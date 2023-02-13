@extends('layouts.main', ['title' => __('lang.label_budget') ])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        <div class="">
                            @include('errors.any')
                        </div>
                        {{-- /session rows --}}

                        <div class="w-100">
                            @if (session('isRemoveTrue'))
                                <div class="alert alert-warning">
                                    {{ session('isRemoveTrue')['msg'] }}
                                    <div>
                                        <h6>{{ __('lang.button_delete').' '.__('Tipo de Despesa') }}: <b>{{ session('isRemoveTrue')['budgetTracker'] }}</b><h6>
                                        <form method="POST" action='{{ route('budget.config.tipo.destroy', ['budgetTracker'=> session('isRemoveTrue')['budgetTracker_id'] ]) }}'>
                                            @csrf
                                            <input name="budgetTracker[id]" value="{{ session('isRemoveTrue')['budgetTracker_id'] }}" type="hidden">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex border-bottom">
                            <div class="flex-grow-1">
                                <h4>Configuração de {{ __('lang.label_budget') }}</h4>
                            </div>
                        </div>

                        <div class="mb-4 mt-3">
                            <h5 class="text-black-50">
                                {{ __('Tipo de Despesa') }}
                            </h5>
                            <div class="text-lowercase mb-2">
                                @can('cadastrar_tipos_despesa', App\Models\Budgets::class)
                                    <a href="{{ route('budget.config.tracker_new') }}" class="text-success btn btn-light btn-sm border my-shadow">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('lang.button_add').' tipo' }}</span>
                                    </a>
                                @endcan
                                @can('cadastrar_valores_base', App\Models\Budgets::class)
                                    <a href="{{ route('budget.config.valor_base') }}" class="bg-success btn btn-light btn-sm my-shadow">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('lang.button_add').' Valores base' }}</span>
                                    </a>
                                @endcan
                            </div>
                            <div class="table-responsive">
                                <table class="border table table-sm table-striped table-hover">
                                    <thead class="table-active">
                                        <th>{{ __('lang.field_name') }}</th>
                                        <th class="text-center w-25">
                                            {{ __('lang.field_type') }}
                                        </th>
                                        <th class="text-center">{{ __('lang.field_active') }}</th>
                                        <th></th>
                                    </thead>

                                    <tbody>
                                        @foreach ($budget_trackers as $budget_tracker)
                                            <tr>
                                                <td class="p-0 pr-2 pl-2">
                                                    <a href="{{ route('budget.config.tracker_edit', ['budgetTracker' => $budget_tracker->id]) }}">{{ $budget_tracker->name }}</a>
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    @if ($budget_tracker->type == 'expense')
                                                        {{ __('Despesa') }}
                                                    @elseif($budget_tracker->type == 'incoming')
                                                        {{ __('Receita') }}
                                                    @endif
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    @if ($budget_tracker->status)
                                                        <i class="icon-checkmark-circle text-success"></i>
                                                    @endif
                                                </td>
                                                <td class="p-0 pr-3 pl-2 text-right text-nowrap">
                                                    @can('excluir_tipos_despesa', App\Models\Budgets::class)
                                                        <a href="{{ route('budget.config.tracker_remove_confirmation', ['budgetTracker' => $budget_tracker->id]) }}">
                                                            <i class="icon-trash"></i>
                                                            {{ __('lang.button_delete') }}
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-4 mt-3">
                            <h5 class="text-black-50">
                                {{ __('Campos Personalizados de Tarefas vs Orçamento') }}
                            </h5>
                            {{-- <div class="text-lowercase mb-2">
                                <a href="{{ route('budget.config.cf_new') }}" class="text-success btn btn-light btn-sm border my-shadow">
                                    <i class="icon-plus2"></i>
                                    <span>{{ __('lang.button_add') }}</span>
                                </a>
                            </div> --}}
                            <div class="content-body">
                                <form action="{{ route('budget.config.cf_store') }}" method="POST">
                                    @csrf
                                    <div class="row m-0 pt-3">
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
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
