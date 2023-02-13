<div class="">
    <hr class="m-1">
    <div class="d-flex">
        <p class="mb-1 flex-grow-1">
            <strong>{{ __('lang.label_subtask_plural') }}</strong>
        </p>
        <div class="">
            <a href="#" class="link-option ml-2" onclick="return false;" wire:click="toogle_sub_issue_form">
                @if ($showSubIssuesForm)
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

        @if ($showSubIssuesForm)
            <div class="related_issues_form">
                <div class="form-inline">

                    <select name="selectedTracker" id="_selectedTracker" class="my_input p-1 pl-1 pr-3 mr-3" wire:model="selectedTracker">
                        <option value="_">Selecione o tipo</option>
                        @foreach ($projectTracker as $tracker)
                           <option value="{{ $tracker->tracker->id ?? ''}}">{{ $tracker->tracker->name ?? ''}}</option>
                        @endforeach
                    </select>
                    <label for="_issue_to" class="mr-2">{{ __('lang.label_issue') }}:</label>
                    <input type="text" class="my_input pl-3 pr-3 mr-1 w-50" placeholder="Pesquisar tarefa..." wire:model="searchIssue" required>

                    <button class="btn-primary my_input pt-1 pb-1 mr-1" wire:click="addSubIssueFromExistingIssue" {{ $disabledAddButton ? "disabled" : null }}>{{ __('lang.button_add') }}</button>

                    <a href="{{ route('projects.issues.new', [
                        'project_identifier' => $project['identifier'],
                        'parent_id' => $issue['id'],
                        'tracker_id' => $issue['tracker_id']
                        ]) }}" class="btn btn-light my_input pt-1 pb-1"  >{{ __('lang.button_create') }}</a>
                </div>

                @if (sizeof($projectIsses) > 0)
                    <div class="border p-2 bg-white my-shadow mt-1">
                        <span class="text-muted small">Resultado da pesquisa: </span>
                        @forelse ($projectIsses as $_issue)
                            <li class="pl-2 list-unstyled">
                                <a href="#relate_issue_to" class="p-2 cursor-pointer " onclick="return false" wire:click="addSubIssueFromExistingIssue({{ $_issue->id }}, '{{ $_issue->subject }}')">
                                    {{ $_issue->id }} . {{ $_issue->subject }}
                                </a>
                            </li>
                        @empty
                        @endforelse
                    </div>
                @endif
            </div>
        @endif

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

        <div class="sub-tasks">
            @forelse ($issues_info as $_issue)
                <li class='list-unstyled'>
                    <a href="{{ route('issues.show', ['issue' => $_issue['id']]) }}" class="link-option">{{ $_issue['tracker'].' #'.$_issue['id'] }}</a>
                    <span style="font-size: 90%;" class="text-black-50">{{ $_issue['subject'] }}</span>
                </li>
                @isset($issue['child'])
                    @include('issues.sub_tasks_tree', ['subIssues' => $_issue['child']])
                @endisset

                @empty
                    <small class="text-muted">Nenhum subtarefa adicionada.</small>
            @endforelse
        </div>

    </div>
    <hr class="mt-0 mb-0">
</div>
