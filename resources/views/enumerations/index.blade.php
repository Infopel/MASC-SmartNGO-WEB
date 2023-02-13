@extends('layouts.main', ['title' => __('lang.label_enumerations') ])
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
                                        <h6>{{ __('lang.button_delete').' '.__('lang.label_enumerations') }}: <b>{{ session('isRemoveTrue')['enumeration_name'] }}</b><h6>
                                        <form method="POST" action='{{ route('enumerations.remove', ['enumeration'=> session('isRemoveTrue')['enumeration_id'] ]) }}'>
                                            @csrf
                                            <input name="enumeration" value="{{ session('isRemoveTrue')['enumeration_id'] }}" type="hidden">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-danger">SIM TENHO</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <h4>{{ __('lang.label_enumerations') }}</h4>

                        <div class="mt-3">
                            @foreach ($enumerations as $key => $item)
                                <div class="mb-4">
                                    @if ($key == 'DocumentCategory')
                                        <h5 class="text-black-50">{{ __('lang.enumeration_doc_categories') }}</h5>
                                    @elseif($key == 'IssuePriority')
                                        <h5 class="text-black-50">{{ __('lang.enumeration_issue_priorities') }}</h5>
                                    @elseif($key == 'TimeEntryActivity')
                                        <h5 class="text-black-50">
                                            {{ __('lang.enumeration_activities') }}
                                        </h5>
                                    @elseif($key == 'PartnersCategory')
                                        <h5 class="text-black-50">
                                            {{ __('lang.enumeration_partner_type') }}
                                        </h5>
                                    @elseif($key == 'MultiIndicators')
                                        <h5 class="text-black-50">
                                            {{ __('Indicadores Multidimensionais') }}
                                        </h5>

                                    @elseif($key == 'IssueArea')
                                        <h5 class="text-black-50">
                                            {{ __('Sol. Fundos - Area') }}
                                        </h5>

                                    @elseif($key == 'IssueActividade')
                                        <h5 class="text-black-50">
                                            {{ __('Sol. Fundos - Actividades') }}
                                        </h5>

                                    @elseif($key == 'IssueNecessidade')
                                        <h5 class="text-black-50">
                                            {{ __('Sol. Fundos - Necessidade') }}
                                        </h5>
                                    @endif
                                    <div class="text-lowercase mb-2">
                                        <a href="{{ route('enumerations.new', ['type' => $key]) }}" class="text-success btn btn-light btn-sm border-bottom my-shadow">
                                            <i class="icon-plus2"></i>
                                            <span>{{ __('lang.label_enumeration_new') }}</span>
                                        </a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="border table table-sm table-striped table-hover table-inbox nowrap">
                                            <thead class="table-active">
                                                <th>{{ __('lang.field_name') }}</th>
                                                <th class="text-center w-25">{{ __('lang.field_is_default') }}</th>
                                                <th class="text-center">{{ __('lang.field_active') }}</th>
                                                <th></th>
                                            </thead>

                                            <tbody>
                                                @foreach ($item as $enumeration)
                                                    <tr>
                                                        <td class="p-0 pr-2 pl-2">
                                                            <a href="{{ route('enumerations.edit', ['enumeration' => $enumeration->id]) }}">{{ $enumeration->name }}</a>
                                                        </td>
                                                        <td class="p-0 pr-2 pl-2 text-center">
                                                            @if ($enumeration->is_default)
                                                                <i class="icon-checkmark-circle text-success"></i>
                                                            @endif
                                                        </td>
                                                        <td class="p-0 pr-2 pl-2 text-center">
                                                            @if ($enumeration->active)
                                                                <i class="icon-checkmark-circle text-success"></i>
                                                            @endif
                                                        </td>
                                                        <td class="p-0 pr-3 pl-2 text-right text-nowrap">
                                                            @can('excluir_tipos_categorias', [\App\Models\Enumerations::class, $enumeration])
                                                                <a href="{{ route('enumerations.remove-request', ['enumeration' => $enumeration->id ]) }}">
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
                            @endforeach
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
