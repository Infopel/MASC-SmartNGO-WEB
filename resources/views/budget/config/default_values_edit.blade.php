@extends('layouts.main', ['title' =>  __('Valores Base') .' - '.__('lang.label_budget')])
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
                                <a href="{{ route('budget.config.index') }}"> Tipo de Despesa </a>
                                <span class="text-muted">
                                    » Valores Base » {{ $default_value->budget_tracker->name }} » Editar
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="">
                        <form action="{{ route('budget.config.valor_base.update', ['default_value' => $default_value->id]) }}" method="POST">
                            @csrf
                            <div class="form-row align-items-center">
                                <div class="col-auto my-1">
                                    <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Tipo de despesa</label>
                                    <select class="custom-select custom-select-sm mr-sm-2"  name="tipo_despesa">
                                        <option value="{{ $default_value->budget_tracker->id }}">{{ $default_value->budget_tracker->name }}</option>
                                    </select>
                                </div>
                                <div class="col-auto my-1">
                                    <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Província</label>
                                    <select class="custom-select custom-select-sm mr-sm-2" name="provincia">
                                        <option value="{{ $default_value->provincia }}">{{ $default_value->provincia }}</option>
                                    </select>
                                </div>
                                <div class="col-auto my-1">
                                    <div class="">
                                        <input type="text" value="{{ $default_value->value }}" class="form-control form-control-sm" placeholder="Valor base" input_type="float" name="value">
                                    </div>
                                </div>
                                <div class="col-auto my-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        {{ __('lang.button_update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="mt-4">
                        <form action="{{ route('budget.config.valor_base') }}" method="GET">
                            <div class="pl-2 pr-2 form-row align-items-center">
                                <div class="col-md-4 p-0 my-1">
                                    {{-- <label class="" for="inlineFormCustomSelect">Selecione a Província</label> --}}
                                    <select class="custom-select custom-select-sm mr-sm-2" name="provincia">
                                        <option value="">Selecione Província...</option>
                                        <option value="Maputo-Cidade" {{ request('provincia') == 'Maputo-Cidade' ? 'selected' : null}}>Maputo-Cidade</option>
                                        <option value="Maputo-Província" {{ request('provincia') == 'Maputo-Província' ? 'selected' : null}} >Maputo-Província</option>
                                        <option value="Gaza" {{ request('provincia') == 'Gaza' ? 'selected' : null}}>Gaza</option>
                                        <option value="Inhambane" {{ request('provincia') == 'Inhambane' ? 'selected' : null}}>Inhambane</option>
                                        <option value="Manica" {{ request('provincia') == 'Manica' ? 'selected' : null}}>Manica</option>
                                        <option value="Sofala" {{ request('provincia') == 'Sofala' ? 'selected' : null}}>Sofala</option>
                                        <option value="Tete" {{ request('provincia') == 'Tete' ? 'selected' : null}}>Tete</option>
                                        <option value="Cabo Delgado" {{ request('provincia') == 'Cabo Delgado' ? 'selected' : null}}>Cabo Delgado</option>
                                        <option value="Niassa" {{ request('provincia') == 'Niassa' ? 'selected' : null}}>Niassa</option>
                                        <option value="Nampula" {{ request('provincia') == 'Nampula' ? 'selected' : null}}>Nampula</option>
                                        <option value="Zambézia" {{ request('provincia') == 'Zambézia' ? 'selected' : null}}>Zambézia</option>
                                    </select>
                                </div>
                                <div class="col-auto my-1">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        {{ __('Pesquisar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-sm border table-striped table-hover">
                                <thead class="table-active">
                                    <th>Tipo de Despesa</th>
                                    <th class="text-nowrap">Província</th>
                                    <th>Valor Base</th>
                                    <th class="text-nowrap">Criado em</th>
                                    <th class="text-nowrap">Atualizado em</th>
                                </thead>
                                <tbody>
                                    @foreach ($defaultValues as $item)
                                        <tr>
                                            <td class="p-0 pr-2 pl-2">
                                                <a href="{{ route('budget.config.valor_base.edit', ['default_value' => $item->id]) }}">
                                                    {{ $item->budget_tracker->name }}
                                                </a>
                                            </td>
                                            <td class="p-0 pr-2 pl-2 text-nowrap">{{ $item->provincia }}</td>
                                            <td class="p-0 pr-2 pl-2 text-nowrap text-center fw-600">{{ number_format(($item->value),2) }} MZN</td>
                                            <td class="p-0 pr-2 pl-2 text-nowrap">{{ $item->created_on }}</td>
                                            <td class="p-0 pr-2 pl-2 text-nowrap">{{ $item->updated_on }}</td>
                                        </tr>
                                    @endforeach

                                    @if ($defaultValues->count() == 0)
                                        <tr>
                                            <td class="p-0 pr-2 pl-2 text-center" colspan="5">
                                                {{ __('lang.label_no_data') }}
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
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
