@extends('layouts.main', ['title' => __('lang.label_partner_new').' - '.__('lang.label_partner_plural') ])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        <div class="w-100">
                            @if (session('status'))
                                <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                    <i class="icon-checkmark"></i>
                                    {{ session('status') }}
                                </div>
                            @elseif(session('erros'))
                                <div class="ml-0 p-2 alert alert-danger">
                                    <i class="icon-warning2"></i>
                                    {{ session('erros') }}
                                </div>
                            @endif
                        </div>
                        @include('errors.any')
                        {{-- /session rows --}}

                        <div class="w-100">
                            @if (session('isRemoveTrue'))
                                <div class="alert alert-warning">
                                    {{ session('isRemoveTrue')['msg'] }}
                                    <div>
                                        <h6>{{ __('lang.button_delete').' '.__('lang.field_category') }}: <b>{{ session('isRemoveTrue')['category_name'] }}</b><h6>
                                        <form method="POST" action='{{ route('questionnaire.destroy', ['questionnaireCategory' => session('isRemoveTrue')['category_id'] ]) }}'>
                                            @csrf
                                            <input name="question" value="{{ session('isRemoveTrue')['category_id'] }}" type="hidden">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-lg-flex">
                            <div class="flex-grow-1">
                                <h5>
                                    <a href="{{ route('partners.index') }}">
                                        {{ __('lang.label_partner_plural') }}
                                    </a> » {{ __('Modelo de Avaliação') }}
                                </h5>
                            </div>
                            @can('definir_modelos_avaliacao', App\Models\User::class)
                                <div>
                                    <a href="{{ route('questionnaire.form.new') }}" class="mr-2 text-success">
                                        <i class="icon-file-plus2"></i>
                                        Criar Formulario de Avaliação
                                    </a>
                                    <a href="{{ route('questionnaire.create') }}" class="">
                                        <i class="icon-plus-circle2"></i>
                                        Criar Categoria
                                    </a>
                                </div>
                            @endcan
                        </div>

                        <div class="content-body">
                            <div class="mt-2">
                                <h5 class="text-black-50">Categorias</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm border table-striped" style="font-size: 96.7%">
                                    <thead class="table-active">
                                        <th>
                                            Nome da categoria
                                        </th>
                                        <th class="text-center">
                                            {{ __('lang.label_question_plurar') }}
                                        </th>
                                        <th class="text-center">
                                            {{ __('lang.label_used_by') }}
                                        </th>
                                        <th>
                                            {{ __('lang.field_created_on') }}
                                        </th>
                                        @can('definir_modelos_avaliacao', App\Models\User::class)
                                            <th></th>
                                        @endcan
                                    </thead>

                                    <tbody>
                                        @foreach ($questionnaireCategories as $categories)
                                            <tr>
                                                <td class="p-0 pr-2 pl-2">
                                                    <a href="{{ route('questions.index', ['questionnaireCategory' => $categories->id]) }}">
                                                        {{ $categories->name }}
                                                    </a>
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    {{ $categories->questions->count() }}
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-center">
                                                    (0) Parceiros
                                                </td>
                                                <td class="p-0 pr-2 pl-2 text-nowrap">
                                                    {{ \Carbon\Carbon::parse($categories->created_on)->format('Y-m-d') }}
                                                </td>
                                                @can('definir_modelos_avaliacao', App\Models\User::class)
                                                    <td class="p-0 pr-2 pl-2 text-right text-nowrap">
                                                        <a href="{{ route('questionnaire.edit', ['questionnaireCategory' => $categories->id]) }}" class="mr-2 ml-2">
                                                            <i class="icon-pencil5" style="font-size: 99%"></i>
                                                            {{ __('lang.button_edit') }}
                                                        </a>
                                                        <a href="{{ route('questionnaire.remvoe_request', ['questionnaireCategory' => $categories->id]) }}" class="text-danger">
                                                            <i class="icon-trash" style="font-size: 99%"></i>
                                                            {{ __('lang.button_delete') }}
                                                        </a>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach

                                        @if ($questionnaireCategories->count() <= 0)
                                            <tr>
                                                <td class="text-center" colspan="5">
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
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 aside-panel">
                    ---
                </div>
            </div>
            {{-- @include('admin._menu') --}}
        </div>
    </div>
@endsection
