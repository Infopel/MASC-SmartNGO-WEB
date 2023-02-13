<div>
    <div class="mt-0">
        <div class="p-2">
            @include('errors.any')
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="bg-light p-2 border rounded">
                    <p class="small">
                        <span class="fw-600"><i>Info: </i></span> O formulário de avaliação da capacidade de parceiro abaixo, tem uma funcionalidade que grava as respostas temporariamente, permitindo uma alteração / revisão futura até a submissão da avaliação. Feita a submissão, não será possível rever ou alterar as repostas indicadas (apenas visualização).
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert-warning p-2 border rounded">
                    <p class="small">
                        <span class="fw-600"><i>Nota: </i></span> Por questões técnicas serão apenas salvas respostas temporárias com opção de resposta do tipo múltipla e/ou única escolha. Respostas do tipo (texto) só serão salvas na submissão do relatório.
                    </p>
                </div>
            </div>
        </div>

        <div class="border-0">
            <form action="" method="POST">
                @csrf

                @foreach ($assessmentSurvey->groupBy('category.name') as $category => $questions)
                    <div class="bg-light p-2 rounded mb-0 border-button">
                        <h5 class="m-0"> <small class="text-muted">Categoria:</small> {{ $category }}</h5>
                    </div>
                    <div class="pl-3 pr-3 pt-2 mb-2">
                        @foreach ($questions as $index => $item)
                        <div class="mb-5">
                            <div class="">
                                <h6>{{ ++$index }}. {{ $item->question->title }}</h6>
                            </div>
                            <div class="mb-3">
                                @if ($item->question->format == 'bool')
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio"
                                            id="customRadioInline1_{{ $item->question->id }}"
                                            name="answer[radio][question][{{ $item->question->id }}]"
                                            value="1"
                                            class="custom-control-input cursor-pointer"
                                            {{ $item->value == '1' ? 'checked' : '' }}
                                            {{ $item->question->required == true ? 'required' : null }}
                                            wire:click="saveNonMultipleOptionAnswer('{{ $item->question->id }}', '{{  1 }}')"
                                            >

                                        <label class="custom-control-label cursor-pointer" for="customRadioInline1_{{ $item->question->id }}">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio"
                                            id="customRadioInline_{{ $item->question->id }}"
                                            name="answer[radio][question][{{ $item->question->id }}]"
                                            value="0"
                                            class="custom-control-input cursor-pointer"
                                            {{ $item->value == '0' ? 'checked' : null }}
                                            {{ $item->question->required == true ? 'required' : null }}
                                            wire:click="saveNonMultipleOptionAnswer('{{ $item->question->id }}', '{{  0 }}')"
                                            >

                                        <label class="custom-control-label cursor-pointer" for="customRadioInline_{{ $item->question->id }}">Não</label>
                                    </div>
                                    @if (in_array("temp_answer_question_id_".$item->question->id."", $temp_saved_values))
                                        <div class="pt-1 pb-1" wire:transition.slide.down>
                                            <small class="text-success fw-400">Resposta Salva temporariamente</small>
                                        </div>
                                    @endif
                                @elseif($item->question->format == 'list')
                                    @if ($item->question->multiple)
                                        <div>
                                            Escolha multipla
                                        </div>
                                        @foreach ($item->question->options as $key => $optionItem)
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                @if (in_array($optionItem, Yaml::parse($item->value ?? "") ?? [] ))

                                                    <input type="checkbox"
                                                        id="input_{{ $item->question->id.$key }}"
                                                        name="answer[checkbox][question][{{ $item->question->id }}][]"
                                                        class="custom-control-input cursor-pointer"
                                                        value="{{ $optionItem }}"
                                                        wire:model="answer_multiple_values.{{ $item->question->id.$key }}"
                                                        wire:click="saveMultipleValueAnswer('{{ $item->question->id }}', '{{  $optionItem }}', {{ true }})"
                                                        checked
                                                       {{ $item->question->required == true && $item->question->is_outro_available == false ? 'required' : null }}
                                                    >
                                                @else
                                                <input type="checkbox"
                                                        id="input_{{ $item->question->id.$key }}"
                                                        name="answer[checkbox][question][{{ $item->question->id }}][]"
                                                        class="custom-control-input cursor-pointer"
                                                        value="{{ $optionItem }}"
                                                        wire:model="answer_multiple_values.{{ $item->question->id.$key }}"
                                                        wire:click="saveMultipleValueAnswer('{{ $item->question->id }}', '{{  $optionItem }}')"
                                                       {{ $item->question->required == true && $item->question->is_outro_available == false ? 'required' : null }}
                                                    >
                                                @endif
                                                <label class="custom-control-label cursor-pointer text-muted" for="input_{{ $item->question->id.$key }}">
                                                    {{ $optionItem }}
                                                </label>
                                            </div>
                                        @endforeach
                                            @if ($item->question->is_outro_available)
                                                <div class="w-100 mt-2">
                                                    <input
                                                        id="custom_field_min_length"
                                                        type="text"
                                                        name="answer[checkbox][outra][{{ $item->question->id }}]"
                                                        value="{{ $item->outro_value }}"
                                                        placeholder="Outro/a"
                                                        class="w-50 from-control border-top-0 border-left-0 border-right-0 border-bottom bg-light"
                                                    >
                                                </div>
                                            @endif
                                        @if (in_array("temp_answer_question_id_".$item->question->id."", $temp_saved_values))
                                            <div class="pt-1 pb-1" wire:transition.slide.down>
                                                <small class="text-success fw-400">Resposta Salva temporariamente</small>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-sm text-black-50">
                                            <small>Apenas uma opção</small>
                                        </div>
                                        @foreach ($item->question->options as $key => $optionItem)
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio"
                                                    id="input_{{ $item->question->id.$key }}"
                                                    name="answer[radio][question][{{ $item->question->id }}]"
                                                    class="custom-control-input cursor-pointer"
                                                    value="{{ $optionItem }}"
                                                    wire:click="saveNonMultipleOptionAnswer('{{ $item->question->id }}', '{{  $optionItem }}')"
                                                    {{ $optionItem === $item->value ? 'checked' : '' }}
                                                    {{ $item->question->required == true && $item->question->is_outro_available == false ? 'required' : null }}
                                                >
                                                <label class="custom-control-label cursor-pointer text-muted" for="input_{{ $item->question->id.$key }}">
                                                    {{ $optionItem }}
                                                </label>
                                            </div>
                                        @endforeach
                                            @if ($item->question->is_outro_available)
                                                <div class="w-100 mt-2">
                                                    <label for="">Outra:</label>
                                                    <input
                                                        id="custom_field_min_length"
                                                        type="text"
                                                        name="answer[radio][outra][{{ $item->question->id }}]"
                                                        value="{{ $item->outro_value}}"
                                                        placeholder="Outro/a"
                                                        class="w-50 from-control border-top-0 border-left-0 border-right-0 border-bottom bg-light"
                                                    >
                                                </div>
                                            @endif
                                        @if (in_array("temp_answer_question_id_".$item->question->id."", $temp_saved_values))
                                            <div class="pt-1 pb-1" wire:transition.slide.down>
                                                <small class="text-success fw-400">Resposta Salva temporariamente</small>
                                            </div>
                                        @endif
                                    @endif
                                @elseif($item->question->format == 'text' || $item->question->is_outro_available)
                                    <input
                                        type="text"
                                        placeholder="digite a resposta"
                                        name="answer[text][question][{{ $item->question->id }}]"
                                        value="{{ $item->value}}"
                                        class="w-75 from-control border-top-0 border-left-0 border-right-0 border-bottom bg-light"
                                        {{ $item->question->required == true ? 'required' : null }}
                                    >
                                @elseif($item->question->format == 'int')
                                    <input
                                        id="custom_field_min_length"
                                        type="text"
                                        size="15"
                                        name="answer[text][question][{{ $item->question->id }}]"
                                        value="{{ $item->value}}"
                                        class="from-control border-top-0 border-left-0 border-right-0 border-bottom bg-light"
                                        {{ $item->question->required == true ? 'required' : null }}
                                    >
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endforeach

                @if ($assessmentSurvey->count() > 0)
                    @if ($partnerAssessment->is_submited)
                        <div class="p-2 alert-danger rounded border-danger">
                            Essa avaliação ja foi submetida, apenas visualização.
                        </div>
                    @else
                        <div class="text-right pt-3">
                            <button class="btn btn-default btn-primary border-bottom">Submeter Avaliação</button>
                        </div>
                    @endif
                @endif
            </form>
        </div>

    </div>
</div>
