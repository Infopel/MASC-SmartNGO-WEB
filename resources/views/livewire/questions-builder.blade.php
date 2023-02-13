<div>

    <div class="row m-0 p-2">
        {{-- <div wire:poll.50ms>
        Current time: {{ now() }}
        </div> --}}
            <div class="col-md-12 bg-white p-3 rounded">

                <div class="row">

                    <div class="col-md-7">
                        <div class="p-2">
                            <h5>
                                <a href="{{ route('questionnaire.models.index') }}">
                                    {{ __('Categorias') }}
                                </a> » {{ $questionnaireCategory->name }}
                            </h5>
                        </div>
                        @if ($isEdit)
                        <form action="{{ route('questions.update', [
                            'questionnaireCategory' => $questionnaireCategory->id,
                            'question' => $question['id']
                            ]) }}" method="POST">
                        @else
                        <form action="{{ route('questions.store', ['questionnaireCategory' => $questionnaireCategory->id]) }}" method="POST">
                        @endif
                            @csrf
                            <div class="mb-3 bg-light rounded border p-2 pt-0" style="font-size:90%">
                                <div class="tabular">
                                    <p>
                                        <label for="question_title" class="float-left">Titulo da questao<span class="text-danger">*</span></label>

                                        <textarea name="question[title]" id="question_title" cols="30" rows="3" class="my_input" style="resize:none" wire:model="question_title">

                                        </textarea>
                                        <em class="info">Nao use quebra de linha neste campo</em>
                                    </p>
                                    <p class="pr-3">
                                        <label for="format" class="float-left">
                                            Formato da entrada<span class="text-danger">*</span>
                                        </label>

                                        <select name="question[format]" id="format" class="my_input p-1" wire:model="question_format">
                                            <option value="bool">Resposta fechada</option>
                                            <option value="list">Lista de opcoes</option>
                                            <option value="text">Resposta Aberta</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="is_required" class="float-left">Resposta Obrigatória</label>
                                        <input name="question[required]" type="hidden" value="0">
                                        <input type="checkbox" value="1" name="question[required]" id="is_required">
                                    </p>
                                    @if ($question_format == 'bool')
                                        <p>
                                            <label for="custom_field_possible_values" class="float-left">Possíveis valores</label>
                                            <textarea rows="3" name="custom_field[possible_values]" class="border" style="resize:none" disabled readonly>Sim ou Não
                                            </textarea>
                                        </p>

                                    @elseif($question_format == 'list')
                                        <p>
                                            <label for="is_multiple_values" class="float-left">Múltiplos valores</label>
                                            <input name="question[multiple]" type="hidden" value="0">
                                            <input type="checkbox" value="1" name="question[multiple]" id="is_multiple_values" wire:model="is_multiple_values">
                                        </p>
                                        <p>
                                            <label for="question_possible_values" class="float-left">Possíveis valores</label>
                                            <textarea rows="10" name="question[possible_values]" id="question_possible_values" class="border" style="resize:none" wire:model="possible_values"></textarea>
                                            <em class="info">Uma linha para cada valor</em>
                                        </p>

                                        <p>
                                            <label for="is_outro_available" class="float-left">incluir opcoa de (Outro/a)</label>
                                            <input name="question[is_outro_available]" type="hidden" value="0">
                                            <input type="checkbox" value="1" id="is_outro_available" name="questoin[is_outro_available]" id="custom_field_multiple" wire:model="is_outro_available">
                                        </p>

                                    @elseif($question_format == 'text')

                                    @elseif($question_format == 'int')
                                        <p>
                                            <label for="custom_field_min_length" class="float-left">Tamanho mín-máx</label>
                                            <input class="border " size="5" type="text" name="custom_field[min_length]" id="custom_field_min_length"> -
                                            <input class="border " size="5" type="text" name="custom_field[max_length]" id="custom_field_max_length">
                                        </p>
                                    @endif
                                </div>
                            </div>

                            @if ($isEdit)
                                <div class="mt-3">
                                    <button>{{ __('lang.button_update') }}</button>
                                </div>
                            @else
                                <div class="mt-2">
                                    <button>{{ __('lang.button_create') }}</button>
                                    <button name="continue" value="true">{{ __('lang.button_create_and_continue') }}</button>
                                    <a href="#" class="ml-2" onclick="return false;" wire:click="preview()">Previsualizar</a>
                                </div>
                            @endif
                        </form>
                    </div>
                    <div class="col-md-5">
                        <h5>Pré-visualização</h5>
                        <div class="">
                            <span>Questão: <b>{{ $question_title }}</b></span>
                            <div class="">
                                @if ($question_format == 'list')
                                    @foreach ($preview_possible_values as $key => $item)
                                        @if ($is_multiple_values)
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" id="input_{{ $key }}" name="checkbox" class="custom-control-input cursor-pointer">
                                                <label class="custom-control-label cursor-pointer" for="input_{{ $key }}">
                                                    {{ $item }}
                                                </label>
                                            </div>
                                        @else
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="input_{{ $key }}" name="radio" class="custom-control-input cursor-pointer" value="{{ $item }}">
                                                <label class="custom-control-label cursor-pointer" for="input_{{ $key }}">
                                                    {{ $item }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                @elseif($question_format == 'bool')
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="radio" class="custom-control-input cursor-pointer">
                                        <label class="custom-control-label cursor-pointer" for="customRadioInline1">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline2" name="radio" class="custom-control-input cursor-pointer">
                                        <label class="custom-control-label cursor-pointer" for="customRadioInline2">Não</label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </div>

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
