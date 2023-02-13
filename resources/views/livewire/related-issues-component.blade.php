<div class="">
    <hr class="m-1">
    <div class="d-flex">
        <p class="mb-1 flex-grow-1">
            <strong>Tarefas relacionadas</strong>
        </p>
        <div class="">
            <a href="#" class="link-option ml-2" onclick="return false;" wire:click="add_related_issue_form">
                @if ($add_related_issue)
                    <i class="icon-close2"></i>
                    <span>Canclar</span>
                @else
                    <i class="icon-plus2"></i>
                    <span>Adicionar</span>
                @endif
            </a>
        </div>
    </div>
    <div class="">
        <div class="">
            @forelse ($related_issues as $item)
                <li class='list-unstyled'>
                    <span style="font-size: 90%;" class="text-black-50 fw-600">{{ $item->relation_type }}: </span>
                    <span style="font-size: 90%;" class="text-black-50">{{ $item->issueTo->subject }}</span>
                    <a href="{{ route('issues.show', ['issue' => $item->issueTo->id]) }}" class="link-option">
                        {{ $item->issueTo->tracker->name.' #'.$item->issueTo->id }}
                    </a>
                </li>
            @empty
               <small class="text-muted">Nenhum tarefa relacionada.</small>
            @endforelse
        </div>

        <div class="mb-2">
             @if (session()->has('success'))
                <div class="alert alert-success p-1 mb-0">
                    {!! session('success') !!}
                </div>
            @elseif(session()->has('warning'))
                <div class="alert alert-warning p-1 mb-0">
                    {!! session('warning') !!}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger p-1 mb-0">
                    {!! session('error') !!}
                </div>
            @endif
        </div>
        @if ($add_related_issue)
            <div class="related_issues_form">
                <div class="form-inline">

                    <select name="related_issess" id="_related_issess" class="my_input p-1 pl-1 pr-3 mr-3" wire:model="relation_type">
                        <option value="_relaciondo">Relacionado a</option>
                        <option value="_antecede">Antecede</option>
                        <option value="_precede">Precede</option>
                    </select>
                    <label for="_issue_to" class="mr-2">{{ __('lang.label_issue') }}:</label>
                    <input type="text" class="my_input pl-3 pr-3 mr-1 w-50" placeholder="Pesquisar tarefa..." wire:model="search_issues" required>

                    <button class="btn-primary my_input pt-1 pb-1 mr-1" wire:click="addRelatedIssue">{{ __('lang.button_add') }}</button>
                    <button class="my_input pt-1 pb-1"  wire:click="add_related_issue_form">{{ __('lang.button_cancel') }}</button>
                </div>

                @if (sizeof($available_issues) > 0)
                    <div class="border p-2 bg-white my-shadow mt-1">
                        <span class="text-muted small">Resultado da pesquisa: </span>
                        @forelse ($available_issues as $_issue)
                            <li>
                                <a href="#relate_issue_to" onclick="return false" wire:click="relate_issue_to({{ $_issue->id }}, '{{ $_issue->subject }}')">
                                    {{ $_issue->id }} . {{ $_issue->subject }}
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </div>
                @endif
            </div>
        @endif
    </div>
    <hr class="mt-0 mb-0">
</div>
