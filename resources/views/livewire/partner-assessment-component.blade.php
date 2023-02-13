<div class="row m-0">
    <div class="col-md-12 p-0">
        <div class="d-flex">
            <div class="flex-grow-1">
                {{-- Actualização --}}
            </div>
            <div>
                <div class="text-lowercase ">
                    <a href="#" onclick="return false;" wire:click="modalCreateAssessment()" class="text-success border btn btn-sm btn-light rounded-0">
                        <i class="icon-plus2"></i>
                        <span>{{ __('Novo Avaliação') }}</span>
                    </a>
                </div>
            </div>
        </div>
        {{-- Flash alerts --}}
        @include('errors.any')
        <div class="mt-1 mb-3">
            <div class="table-responsive">
                <table class="table table-sm table-hover table-striped border" style="font-size: 93%">
                    <thead class="table-active">
                        <th>Index</th>
                        <th>Descrição</th>
                        <th>Criado por</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th class="text-center">Avaliado</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($partnerAssessments as $index => $item)
                            <tr>
                                <td>
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <a href="{{ route('partners.survey', [
                                        'partner' => $partner->id,
                                        'partnerAssessment' => $item->id
                                        ]) }}">
                                        {{ $item->assessment->description }}
                                    </a>
                                </td>
                                <td>
                                    {{ $item->author->full_name }}
                                </td>
                                <td>
                                    {{ $item->created_on }}
                                </td>
                                <td>
                                    {{ $item->updated_on }}
                                </td>
                                <td class="text-center">
                                    @if ($item->is_submited)
                                        <i class="icon-checkmark-circle text-success"></i>
                                    @else
                                        <i class="icon-checkbox-unchecked text-danger"></i>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    {{ __('lang.label_no_data') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($modal_create_assessment)
        <div class="fade in modal show overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 pl-4 pr-4">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            <span class="text-muted">Nova Avaliação</span>
                        </h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent="createPartnerAssessmet" method="POST">
                        <div class="modal-body mt-0 pt-0">
                            <div class="mt-2">
                                <label for="new_assessment" class="mr-2">
                                    <input type="radio" name="assessment" wire:click="toogleAssessment({{ true }})" value="new_assessment" id="new_assessment">
                                    Novo Modelo
                                </label>
                                <label for="use_assessment" class="mr-2">
                                    <input type="radio" name="assessment" checked wire:click="toogleAssessment({{ false }})" value="use_assessment" id="use_assessment">
                                    Usar Modelo
                                </label>
                            </div>
                            <div class="bg-light border mt-0 p-2">
                                <div class="tabulars">
                                    @if ($isNewAssessment)
                                        <p class="pl-2 pr-2">
                                            <label for="assignable" class="">
                                                {{ __('lang.field_description') }}<span class="text-danger"> *</span>
                                            </label>
                                            <input type="text" class="my_input p-1 w-50" wire:model="description" placeholder="{{ __('lang.field_description') }}">
                                            @error('type')
                                                <br>
                                                <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </p>
                                    @else
                                        <p class="pl-2 pr-2">
                                            <label for="assignable" class="">
                                                Modelo de Avaliação<span class="text-danger"> *</span>
                                            </label>
                                            <select name="assessment" id=""  class="my_input p-1" wire:model="selectedAssessment">
                                                <option value="">Selecione um modelo</option>
                                                @foreach ($assessments as $item)
                                                    <option value="{{ $item->id }}">{{ $item->description }}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                </div>

                                <div class="p-2">
                                    <h6>
                                        Categorias de Avaliaçãos
                                    </h6>
                                    <ul>
                                        @foreach ($questionsCategories as $category)
                                            <li>{{ $category->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="alert-success p-3 border text-sm">
                                    Esse formulário de criação de avaliação ao ser submetido vai incluir todas categorias e as perguntas do modelo avaliação.
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer p-1">
                            <button type="submit">{{ __('lang.button_add') }}</button>
                            <button type="button" wire:click="closeModal">{{ __('lang.button_cancel') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in"></div>
        <div class="fade modal-backdrop show"></div>
    @endif

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
