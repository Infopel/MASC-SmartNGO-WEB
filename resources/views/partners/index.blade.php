@extends('layouts.main', ['title' => __('lang.label_partner_plural') ])
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
                                        <h6>{{ __('lang.button_delete').' '.__('lang.label_partner') }}: <b>{{ session('isRemoveTrue')['partner_name'] }}</b><h6>
                                        <form method="POST" action='{{ route('partners.remove', ['partner'=> session('isRemoveTrue')['partner_id'] ]) }}'>
                                            @csrf
                                            <input name="partner" value="{{ session('isRemoveTrue')['partner_id'] }}" type="hidden">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h4>{{ __('lang.label_partner_plural') }}</h4>
                            </div>
                            @can('definir_modelos_avaliacao', App\Models\Partners::class)
                                <div class="text-capitalize ">
                                    <a href="{{ route('questionnaire.models.index') }}" class="text-primary mr-2">
                                        <i class="icon-stack-check"></i>
                                        <span>{{ __('Modelos de Avaliação') }}</span>
                                    </a>
                                </div>
                            @endcan
                            {{-- @can('cadastrar_parceiros', App\Models\User::class) --}}
                                <div class="text-capitalize ">
                                    <a href="{{ route('partners.new') }}" class="text-success">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('lang.label_partner_new') }}</span>
                                    </a>
                                </div>
                            {{-- @endcan --}}
                        </div>

                        <div class="mt-3">
                            <div class="filters">

                            </div>

                            <div class="content-body">
                                <div class="table-responsive">
                                    <table class="table border table-sm table-striped table-hover">
                                        <thead class="table-active">
                                            <th>
                                                {{ __('lang.field_name') }}
                                            </th>
                                            <th>
                                                {{ __('lang.label_partner_address') }}
                                            </th>
                                            <th class="text-center">
                                                {{ __('lang.field_type') }}
                                            </th>
                                            <th>Inicio da Parceira</th>
                                            <th></th>
                                            <th></th>
                                        </thead>

                                        <tbody>
                                            @foreach ($partners as $partner)
                                                <tr>
                                                    <td class="p-0 pl-2 pr-2">
                                                        <a href="{{ route('partners.show', ['partner' => $partner->id]) }}">
                                                            {{ $partner->name }}
                                                        </a>
                                                    </td>
                                                    <td class="p-0 pl-2 pr-2">
                                                        {{ $partner->address }}
                                                    </td>
                                                    <td class="p-0 pl-2 pr-2 text-center">
                                                        {{ $partner->tipo ? $partner->tipo->name : 'Erro ou não definido.' }}
                                                    </td>
                                                    <td class="p-0 pl-2 pr-2">
                                                        {{ $partner->start_date }}
                                                    </td>
                                                    <td class="p-0 pl-2 pr-2">
                                                        {{-- {{ $partner->due_date }} --}}
                                                    </td>
                                                    <td class="p-0 pl-2 pr-2 text-right">
                                                        <a href="{{ route('partners.remove_confirmation', ['partner' => $partner->id ]) }}">
                                                            <i class="icon-trash"></i>
                                                            {{ __('lang.button_delete') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @if (sizeof($partners) == 0)
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        {{ __('lang.label_no_data') }}
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="pt-2 pagination-sm">
                                        <span class="text-black-50">
                                            ({{ $partners->count() }}-{{ $partners->lastItem() }}/{{ $partners->total() }})
                                        </span>
                                        {{ $partners->links() }}
                                    </div>
                                </div>
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
