@extends('layouts.main', ['title' => $data['tracker'].' #'.$data['issue']['id'].': '.$data['issue']['subject'] ])
@section('content')
    <div class="row m-0 p-2">

        <div class="col-md-12">
            <div class="w-100">
                @if (session('isRemoveTrue'))
                    <div class="alert alert-warning">
                        {{ session('isRemoveTrue')['msg'] }}
                        <div>
                            <h6>{{ __('lang.button_delete').' '.__('lang.label_issue') }}: <b>{{ session('isRemoveTrue')['issue_subject'] }}</b><h6>
                            <form method="POST" action='{{ route('issue.remove', ['issue'=> session('isRemoveTrue')['issue_id'] ]) }}'>
                                @csrf
                                <div class="text-left">
                                    <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 bg-white p-3">

                    {{-- @if ($data['issue']['author_id'] === auth()->user()->id)
                        @if ($data['issue']['isInitApproval'] === 0)
                            @livewire('system-info-update-modal-component', $data['issue'], true, true)
                        @endif
                    @endif --}}

                    <div class="m-0">
                        {{-- sessions alerts --}}
                        @include('errors.any')
                        {{-- sessions alerts --}}
                        <div class="d-lg-flex">
                            <div class="flex-grow-1">
                                <h5>{{ $data['tracker'].' #'.$data['issue_id'] }}</h5>
                            </div>
                            <div class="d-lg-flex">
                                @if ($data['projecto']['type'] !== "PDE")
                                    @can('edit_issues', [ App\Models\Issues::class, $_project['project']])
                                        <a href="{{ route('issues.budget', ['issue' => $data['issue']['id']]) }}" class="link-option text-danger ml-2">
                                            <i class="icon-coins" style="font-size:97%"></i>
                                            <span>{{ __('lang.project_module_budget') }}</span>
                                        </a>
                                    @endcan
                                @endif
                                @isset($data['issues'][0]->approvement_workflow_requests[0])
                                    @if (!$data['issues'][0]->approvement_workflow_requests[0]->is_approved)
                                        @if (auth()->user()->id === 6  || $data['issues'][0]->author_id === auth()->user()->id )
                                            @can('edit_issues', [ App\Models\Issues::class, $_project['project']])
                                                <a href="{{ route('issues.edit', ['issue' => $data['issue']['id']]) }}" class="link-option ml-2">
                                                    <i class="icon-pencil5" style="font-size:95%"></i>
                                                    <span>{{ __('lang.button_edit') }}</span>
                                                </a>
                                            @endcan
                                        @endif
                                    @else
                                        @if (auth()->user()->id === 6)
                                            <a href="{{ route('issues.edit', ['issue' => $data['issue']['id']]) }}" class="link-option ml-2">
                                                <i class="icon-pencil5" style="font-size:95%"></i>
                                                <span>{{ __('lang.button_edit') }}</span>
                                            </a>
                                        @endif
                                    
                                    @endif
                                @endisset
                                
                                @if ($data['projecto']['type'] !== "PDE")
                                    @if ($data['issues'][0]->approvement_workflow_requests->count() >= 3)
                                        @can('log_time', [App\Models\Issues::class, $_project['project']])
                                            <a href="{{ route('time_entries.issues', ['issue' => $data['issue']['id']]) }}" class="link-option ml-2">
                                                <i class="icon-calendar2" style="font-size:95%"></i>
                                                <span>{{ __('lang.button_log_time') }}</span>
                                            </a>
                                        @endcan
                                    @endif
                                @endif
                                @if ($data['issue']['tracker_id'] == 10)
                                    @can('log_time', [App\Models\Issues::class, $_project['project']])
                                        <a href="{{ route('time_entries.issues', ['issue' => $data['issue']['id']]) }}" class="link-option ml-2">
                                            <i class="icon-calendar2" style="font-size:95%"></i>
                                            <span>{{ __('lang.button_log_time') }}</span>
                                        </a>
                                    @endcan
                                @endif

                                @if ($data['issue']['is_aproved'] || $data['issue']['status_id'] == 2)
                                    @can('add_issue_watchers', [App\Models\Issues::class, $_project['project']])
                                        <a href="{{ route('issue.self_watcher', ['watchable_id' => $data['issue_id'], 'watchable_type' => 'Issue' ]) }}" class="link-option ml-2" onclick="event.preventDefault(); document.getElementById('self_watcher-form').submit();">
                                            @if (!$data['is_watcher'])
                                                <i class="icon-star-empty3" style="font-size:95%"></i>
                                                <span>{{ __('lang.button_watch') }}</span>
                                            @else
                                                <i class="icon-star-full2" style="color:#f7e752"></i>
                                                <span>{{ __('lang.button_unwatch') }}</span>
                                            @endif
                                        </a>
                                        <form id="self_watcher-form" action="{{ route('issue.self_watcher', ['watchable_id' => $data['issue_id'], 'watchable_type' => 'Issue' ]) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @endcan
                                    @can('copy_issues', [App\Models\Issues::class, $_project['project']])
                                        <a href="" class="link-option ml-2">
                                            <i class="icon-copy2" style="font-size:95%"></i>
                                            <span>{{ __('lang.button_copy') }}</span>
                                        </a>
                                    @endcan
                                @endif
                                {{--!!dd(auth()->user()->id === 6  || $data['issues'][0]->author_id === auth()->user()->id); !!--}}
                                @isset($data['issues'][0]->approvement_workflow_requests[0])
                                    @if (!$data['issues'][0]->approvement_workflow_requests[0]->is_approved)
                                        @if ($data['issues'][0]->author_id === auth()->user()->id)
                                            <a href="{{ route('issue.delete-request', ['issue' => $data['issue_id']]) }}" class="link-option ml-2">
                                                <i class="icon-trash" style="font-size:95%"></i>
                                                <span>{{ __('lang.button_delete') }}</span>
                                            </a>
                                        @else
                                            @can('delete_issues', [App\Models\Issues::class, $_project['project']])
                                                <a href="{{ route('issue.delete-request', ['issue' => $data['issue_id']]) }}" class="link-option ml-2">
                                                    <i class="icon-trash" style="font-size:95%"></i>
                                                    <span>{{ __('lang.button_delete') }}</span>
                                                </a>
                                            @endcan
                                        @endif
                                    @endif
                                @endisset
                                
                                <a href="#" x-data="{ issueMenuOpen: false }" class="position-relative ml-2">
                                    <i class="icon-menu7" style="font-size:98%" x-on:click="issueMenuOpen = !issueMenuOpen"></i>
                                    <div
                                        class="position-absolute bg-white text-nowrap border shadow-sm rounded-sm pt-2 pb-2 link-option ml-2"
                                        style="right: 0; top: 24px; z-index: 5;"
                                        x-show="issueMenuOpen"
                                        x-on:click.away="issueMenuOpen = !issueMenuOpen"
                                    >
                                        <h6 class="dropdown-header pt-1 mt-0">Actualizar Estado da tarefa</h6>
                                        <ul class="list-unstyled p-0 m-0" style="font-size: 95%">
                                            <li class="dropdown-item pr-2 pl-2 pb-1 pt-1">
                                                <i class="icon-checkmark-circle text-success" style="font-size: 95%"></i> <span>Nova  Tarefa</span>
                                            </li>
                                            <li class="dropdown-item pr-2 pl-2 pb-1 pt-1">
                                                <i class="icon-null" style="font-size: 95%"></i> <span>Validado</span>
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="p-3" style="background:#ffffdd; font-size: 94%;">

                            <div class="mb-3">
                                <div class="pl-3 pr-3">
                                    @foreach ($data['issues'] as $issue)
                                        <ul class="list-unstyled mb-1" style="list-style:none; line-height: 1;">
                                            <li>
                                                {{-- @if (false) --}}
                                                @if ($issue->id == $data['issue_id'])
                                                    <span class="h5">{{ $issue->subject }} </span>
                                                @else
                                                    <a href="{{ route('issues.show', ['issue' => $issue->id]) }}" class="link-option">
                                                        {{ $issue->tracker.' #'.$issue->id }}
                                                    </a>
                                                    <span style="font-size: 93%;" class="text-black-50">{{ $issue->subject }}</span>
                                                @endif

                                                @if (isset($issue['child']))
                                                    @foreach ($issue['child'] as $sub_issue)
                                                        @include('issues.sub_tree', ['subIssues' => $issue['child']])
                                                    @endforeach
                                                @endif
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                                <div class="">
                                    {!! __('lang.label_added_time_by', [
                                        'author' => '<a href='.$data['issue']['user_path'].'>'.$data['issue']['author_firstname'].' '.$data['issue']['author_lastname'].'</a>',
                                        'time'=> '<a href='.'/users'.'>'.$data['issue']['created_on'].'</a>'
                                        ])
                                    !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.field_status') }}:</div>
                                        <div class="flex-grow-1">{{ $data['issue']['issue_status'] }}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.field_priority') }}:</div>
                                        <div class="flex-grow-1">{{ $data['issue']['issue_priority'] }}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.label_attribute_of_assigned_to', ['name' => ':']) }}</div>
                                        <div class="flex-grow-1">
                                            @isset ($data['issue']['assigned_to'])
                                                <a href="{{ route('users.show', ['user' => $data['issue']['assigned_to']['id'] ]) }}">{{ $data['issue']['assigned_to']->full_name }}</a>
                                            @endisset
                                        </div>
                                    </div>
                                </div>
                                {{-- Column --}}
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.field_start_date') }}</div>
                                        <div class="">{{ $data['issue']['issue_start_at'] }}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.field_due_date') }}:</div>
                                        <div class="">{{ $data['issue']['issue_end_at'] }}</div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.field_done_ratio') }}:</div>
                                        <div class="d-flex">
                                            <div class="progress mt-1 mr-2" style="width:100px; height:15px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $data['issue']['done_ratio'] }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            {{ $data['issue']['done_ratio'] }}%
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="flex-grow-1 fw-700">{{ __('lang.field_estimated_hours') }}:</div>
                                        <div class="fw-500">{{ $data['issue']['estimated_hours'] }} H</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach ($custom_field_values as $key => $custom_values)
                                    <div class="col-md-4">
                                        <div class="d-flex">
                                            <div class="indicators_value">
                                                <span class="fw-700">{{ $key }}:</span>
                                            </div>
                                            <div class="indicators_value ml-2">
                                                @foreach ($custom_values['values'] as $custom_value)
                                                    @isset($custom_value['is_selected'])
                                                        @if ($custom_value['is_selected'])
                                                            <span>{{ $custom_value['value'] }}</span>
                                                        @endif
                                                    @else
                                                        <span>{{ $custom_value['value'] }}</span>
                                                    @endisset
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{--!!dd()!!--}}
                            @if ($data['issue']['tracker_id'] != 10)
                                {{-- Beneficiarios --}}
                                <div class="">
                                    <hr class="m-1">
                                    <div class="d-flex">
                                        <p class="mb-1 flex-grow-1">
                                            <span class="fw-700">{{ __('Beneficiarios') }}</span>
                                        </p>
                                    </div>

                                    <div class="table-responsive nowrap">
                                        <table class="table table-sm table-hover table-borderless" style="font-size: 90%">
                                            <thead class="border-0">
                                                <th class="border-0 fw-600">{{ __('lang.field_category') }}</th>
                                                <th class="border-0 fw-600 text-center">{{ __('Faixa Étaria') }} (Anos)</th>
                                                <th class="border-0 fw-600 text-center">{{ __('Meta') }}</th>
                                                <th class="border-0 fw-600 text-center">{{ __('Realizado') }}</th>
                                                <th class="border-0 fw-600">{{ __('Realizado em') }}</th>
                                            </thead>

                                            <tbody>
                                                @forelse ($data['issue']['beneficiarios'] as $item)
                                                    <tr>
                                                        <td class="p-0 pr-2 pl-2">{{ $item['type'] }}</td>
                                                        <td class="p-0 pr-2 pl-2 text-center">{{ $item['faixa_etaria'] }}</td>
                                                        <td class="p-0 pr-2 pl-2 text-center">{{ $item['meta'] }}</td>
                                                        <td class="p-0 pr-2 pl-2 text-center">{{ $item['realizado'] }}</td>
                                                        <td class="p-0 pr-2 pl-2">{{ $item['reported_on'] }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">{{ "Nenhum beneficiario adicionado." }}</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- / Beneficiarios --}}

                                {{-- Issue Indicators --}}
                                <div style="overflow-x: auto">
                                    <hr class="m-1">
                                    <div class="d-flex">
                                        <p class="flex-grow-1">
                                            <span> {{ __('Indicadores') }} </span>
                                        </p>
                                    </div>
                                    <table>
                                        <thead style="width: 500px; height: 450%;">
                                            <th class=" border-0 fw-600 text-center" >Indicadores</th>
                                            <th class="border-0 fw-600 text-center">Meta</th>
                                            <th class="border-0 fw-600 text-center">Fonte de Verificação</th>
                                        </thead>
                                        <tbody>
                                            @forelse ($indicators as $key => $indicator)
                                                <tr>
                                                    <td class="p-0 pr-2 pl-2">{{ $indicator->indicator_field['name'] }}</td>
                                                    <td>{{ $indicator->indicator_field['indicator_issue_values']['meta'] }}
                                                        <table>
                                                            {{-- <th width="10%" class="border-0 fw-600"></th> --}}
                                                            <th width="10%" class="border-0 fw-600">Meta Trimestre 1:</th>
                                                            <th width="10%" class="border-0 fw-600">Meta Trimestral 2:</th>
                                                            <th width="10%" class="border-0 fw-600">Meta Trimestral 3</th>
                                                            <th width="10%" class="border-0 fw-600">Meta Trimestral 4</th>
                                                            <tr>
                                                                <td>{{ $indicator->indicator_field['indicator_issue_values']['m_trim_01'] }}</td>
                                                                <td>{{ $indicator->indicator_field['indicator_issue_values']['m_trim_02'] }}</td>
                                                                <td>{{ $indicator->indicator_field['indicator_issue_values']['m_trim_03'] }}</td>
                                                                <td>{{ $indicator->indicator_field['indicator_issue_values']['m_trim_04'] }}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td class="p-0 pr-2 pl-2 text-center">{{  $indicator->indicator_field['indicator_issue_values']['fonte_ver']  }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">{{ "Nenhum beneficiario adicionado." }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                                {{-- /Issue Indicators --}}

                                {{-- Issue Description --}}
                                <div class="">
                                    <hr class="m-1">
                                    <div class="d-flex">
                                        <p class="mb-1 flex-grow-1">
                                            <span class="fw-500">{{ __('lang.field_description') }}</span>
                                        </p>
                                    </div>
                                    <div class="">
                                        {{-- {!! nl2br(e($data['issue']['description'])) !!} --}}
                                        {!! $data['issue']['description'] !!}
                                    </div>
                                    <hr class="m-1">
                                </div>
                                {{-- /Issue Description --}}
                            @endif

                            {{-- Issue Documentos de suporte --}}
                            <div class="">
                                <div class="d-flex">
                                    <p class="mb-1 flex-grow-1">
                                        <strong>{{ __('Documentos de suporte') }}</strong>
                                    </p>
                                </div>
                                <div class="table-responsive nowrap">
                                    <table class="table table-sm table-hover" style="font-size: 90%">
                                        <thead>
                                            <th>{{ __('lang.field_filename') }}</th>
                                            <th>{{ __('lang.field_filesize') }}</th>
                                            <th>{{ __('lang.field_downloads') }}</th>
                                            <th>{{ __('lang.label_added_by') }}</th>
                                            <th>{{ __('lang.field_created_on') }}</th>
                                        </thead>

                                        <tbody>
                                            @forelse ($data['issue']['attachments'] as $key => $attachment)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('attachments.getDocument', ['attachment' => $attachment->id, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                                    </td>
                                                    <td>{{ $attachment->filesize }} kb</td>
                                                    <td>{{ $attachment->downloads }}</td>
                                                    <td>{{ $attachment->user->full_name }}</td>
                                                    <td>{{ $attachment->created_on }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">{{ "Nunhum documento de suporte adicionado." }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- /Issue Documentos de suporte --}}

                             @livewire('sub-issues-component', ['issue' => $data['issue'], 'issues_info' => $data['issues_info']])
                            {{-- Tarefas relacionadas --}}
                             @livewire('related-issues-component', ['issue' => $data['issue']])
                        </div>

                    <div class="m-0 mt-3">
                        <span class="h5">{{ __('lang.label_history') }}</span>
                        <div class="note-history d-none">
                            <div class="border-bottom">
                                {!! __('lang.label_updated_time_by', ['author' => '<a href="#">'.$data['issue']['author_firstname'].' '.$data['issue']['author_lastname'].'</a>', 'time'=> '<a href="#">'.$data['issue']['updated_on'].'</a>']) !!}
                            </div>
                        </div>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($data['journals'] as $key => $journals)
                            <div class="mb-3" id="change-{{ ++$i }}">
                                <div class="border-bottom d-flex" id="note-{{ $i }}">
                                    <div class="flex-grow-1">
                                        {!! __('lang.label_updated_time_by', [
                                                'author' => '<a href="#">'.$journals[0]['firstname'].' '.$journals[0]['lastname'].'</a>',
                                                'time'=> '<a href="#">'.$journals[0]['created_on'].'</a>'
                                            ])
                                        !!}
                                    </div>
                                    <div class="fw-500">
                                        <a href="" >
                                            #{{ $i }}
                                        </a>
                                    </div>
                                </div>
                                @foreach ($journals as $key => $journal)
                                    <div class="text-black-50" id="details">
                                        @if ($journal['prop_key'] == null && $journal['notes'] !== null)
                                            <div class="journal-{{ ++$key }}">
                                                <div class="d-flex mt-1">
                                                    <div class="flex-grow-1">
                                                        <p class="mb-2">
                                                            {!! __('lang.text_user_wrote', [
                                                                'value' => '<b>' . $journal['firstname'].' '.$journal['lastname'] . '</b>'
                                                            ]) !!}
                                                        </p>
                                                    </div>
                                                    <div class="">
                                                        <a href="#" wire:click="test" class="ml-1" title="{{ __('lang.button_reply') }}">
                                                            <i class="icon-comment" style="font-size: 90%"></i>
                                                        </a>
                                                        <a href="#" class="ml-1" title="{{ __('lang.button_edit') }}">
                                                            <i class="icon-pencil5" style="font-size: 90%"></i>
                                                        </a>
                                                        <a href="#" class="ml-1" title="{{ __('lang.button_delete') }}">
                                                            <i class="icon-trash" style="font-size: 90%"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <blockquote>{!! $journal['notes']!!}</blockquote>
                                            </div>
                                        @else
                                            <ul class="pl-4 m-0">
                                                <li>
                                                    <p class="m-0">
                                                        {!! $journal['action'] !!}
                                                    </p>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    </div>

                </div>
                <div class="col-md-4 bg-secondary">
                    <div class="row h-100" >
                        @include('issues._asideOptions')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
