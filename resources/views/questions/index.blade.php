@extends('layouts.main', ['title' => $questionnaireCategory->name.' '.__('Modelos de Avaliação')])
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
                        {{-- /session rows --}}
                        @include('errors.any')

                        <div class="w-100">
                            @if (session('isRemoveTrue'))
                                <div class="alert alert-warning">
                                    {{ session('isRemoveTrue')['msg'] }}
                                    <div>
                                        <h6>{{ __('lang.button_delete').' '.__('lang.label_question') }}: <b>{{ session('isRemoveTrue')['question_title'] }}</b><h6>
                                        <form method="POST" action='{{ route('questions.destroy', ['questionnaireCategory' => $questionnaireCategory->id, 'question'=> session('isRemoveTrue')['question_id'] ]) }}'>
                                            @csrf
                                            <input name="question" value="{{ session('isRemoveTrue')['question_id'] }}" type="hidden">
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
                                <h5>
                                    <a href="{{ route('questionnaire.models.index') }}">
                                        {{ __('Categorias') }}
                                    </a> » {{ $questionnaireCategory->name }}
                                </h5>
                            </div>
                            <div class="">
                                <a href="{{ route('questions.create', ['questionnaireCategory' => $questionnaireCategory->id]) }}">
                                    <i class="icon-plus2"></i>
                                    Adicionar pergunta
                                </a>
                            </div>
                        </div>

                        <div class="content-body">
                            <div class="mb-2">
                                Perguntas
                            </div>
                            <div class="table-responsive border">
                                <table class="table table-sm table-hover table-striped">
                                    <thead class="table-active">
                                        <th>Titulo</th>
                                        <th>{{ __('lang.field_field_format') }}</th>
                                        <th class="text-center">Obrigatório</th>
                                        <th class="text-center">Multipla Escolha</th>
                                        <th>Criado em</th>
                                        <th></th>
                                    </thead>

                                    <tbody>
                                        @forelse ($questions as $question)
                                            <tr>
                                                <td class="p-0 pl-2 pr-2">
                                                    <a href="{{ route('questions.edit', ['questionnaireCategory' => $questionnaireCategory->id, 'question' => $question->id]) }}">
                                                        {{ $question->title }}
                                                    </a>
                                                </td>
                                                <td class="p-0 pl-2 pr-2 text-nowrap">
                                                    @if ($question->format == "bool")
                                                        Resposta Fechada
                                                    @elseif($question->format == "list")
                                                        Lista de Opções
                                                    @elseif($question->format == "text")
                                                        Resposta Aberta
                                                    @elseif($question->format == "int")
                                                        Valor Numérico
                                                    @endif
                                                </td>
                                                <td class="p-0 pl-2 pr-2 text-center">
                                                    @if ($question->required)
                                                        <i class="icon-checkmark-circle text-success"></i>
                                                    @endif
                                                </td>
                                                <td class="p-0 pl-2 pr-2 text-center">
                                                    @if ($question->multiple)
                                                        <i class="icon-checkmark-circle text-success"></i>
                                                    @endif
                                                </td>
                                                <td class="p-0 pl-2 pr-2 text-nowrap">
                                                    {{ \Carbon\Carbon::parse($question->created_on)->format('Y-m-d') }}
                                                </td>
                                                <td class="p-0 pl-2 pr-2 text-nowrap">
                                                    <a href="{{ route('questions.remvoe_request', [ 'questionnaireCategory' => $questionnaireCategory->id, 'question' => $question->id]) }}">
                                                        <i class="icon-trash"></i>
                                                        {{ __('lang.button_delete') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="p-0 pl-2 pr-2 text-center text-nowrap" colspan="6">
                                                    {{ __('lang.label_no_data') }}
                                                </td>
                                            </tr>
                                        @endforelse
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
                    -
                </div>
            </div>
            {{-- @include('admin._menu') --}}
        </div>
    </div>
@endsection
