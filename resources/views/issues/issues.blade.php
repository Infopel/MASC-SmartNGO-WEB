@extends('layouts.main', ['title' => $notFound ?? 'Tarefas'])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                @include('errors.any')
                @if ($notFound ?? false)
                    <div class="w-100 bg-white p-2">
                        <h4>404</h4>
                        <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-danger">
                            <i class="icon-exclamation"></i>
                            {{ $notFound }}
                        </div>
                        <p><a href="javascript:history.back()">Back</a></p>
                    </div>
                @else
                    @isset($_project['status'])
                        @if ($_project['status'] == 5)
                            <div class="col-md-12">
                                <div class="pt-1 pb-1 pl-3 pr-3 alert alert-danger text-center">
                                    <i class="icon-lock2" style="font-size:90%"></i>
                                    {{ __('lang.text_project_closed') }}
                                </div>
                            </div>
                        @endif
                    @endisset
                    <div class="col-md-9 bg-white p-3">
                        <div class="m-0">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h5>{{ $data['tracker'] ? $data['tracker']['name'] : 'Tarefas' }}</h5>
                                </div>
                                {{-- <div class="text-lowercase ">
                                    <a href="" class="text-success">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('lang.label_issue_new') }}</span>
                                    </a>
                                </div> --}}
                            </div>

                            <div class="mb-0">
                                @include('issues.filters')
                               {{-- @include('issues.options') --}} 
                            </div>
                        </div>
                        <div class="m-0">
                            <div class="table-responsive">
                                @if(isset(request()->query_id) || isset(request()->col))
                                    <table class="table table-sm table-hover table-striped border datatable-show-all1" style="font-size: 92%">
                                        <thead class="nowrap bg-slate-600" style="padding: 0 0 0 0" >
                                            <th>#</th>
                                            @foreach ($data['table']['thead'] as $item)
                                                <th title="{{ $item }}">{{ $item }}</th>
                                            @endforeach
                                        </thead>

                                        <tbody>
                                            @foreach ($data['issues'] as $issue)
                                                <tr>
                                                    <td class="p-0 pr-2 pl-2">
                                                        <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">{{ $issue->id }}</a>
                                                    </td>
                                                    @foreach ($data['table']['rows'] as $key => $column)
                                                        @if ($column == 'subject')
                                                            <td class="p-0 pr-2 pl-2" title="{{ $data['table']['thead'][$key] }}">
                                                                <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">{{ $issue->$column }}</a>
                                                            </td>
                                                        @else
                                                            <td class="p-0 pr-2 pl-2" title="{{ $data['table']['thead'][$key] }}">{{ $issue->$column }}</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table class="table table-striped border table-sm table-hover datatable-show-all1s" style="font-size: 93%">
                                        <thead class="nowrap bg-slate-600">
                                            <th>#</th>
                                            <th>{{ __('lang.field_project') }}</th>
                                            <th>{{ __('lang.field_tracker') }}</th>
                                            <th>{{ __('lang.label_status') }}</th>
                                            <th>{{ __('lang.field_priority') }}</th>
                                            <th>{{ __('lang.field_subject') }}</th>
                                            <th>{{ __('lang.field_assigned_to') }}</th>
                                            <th class="text-center">{{ __('lang.field_is_aproved') }}</th>
                                            <th>{{ __('lang.field_updated_on') }}</th>
                                            <th>-</th>
                                        </thead>

                                        <tbody>
                                            @foreach ($data['issues'] as $issue)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">
                                                            {{ $issue->id }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('projects.overview', ['project_identifier' => $issue['project']['identifier']]) }}">
                                                            {{ $issue['project']['name'] }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $issue->tipo }}</td>
                                                    <td>
                                                        @if ($issue->status_id)
                                                            {{ __('lang.label_open_issues') }}
                                                        @else
                                                            {{ __('lang.label_closed_issues') }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $issue->priority }}</td>
                                                    <td style="max-width: 520px">
                                                        <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">
                                                            {{ $issue->subject }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        {{ $issue->assined_to ? $issue->assined_to['firstname'].' '.$issue->assined_to['lastname'] : null}}
                                                    </td>
                                                    <td class="text-center text-success">
                                                        @if ($issue->is_aproved)
                                                            <i class="icon-checkmark-circle"></i>
                                                        @endif
                                                    </td>
                                                    <td style="min-width:150px">{{ $issue->updated_at }}</td>
                                                    <td>
                                                        <a href="">
                                                            <i class="icon-stacks3"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif

                            </div>
                            <div class="">

                            </div>
                            <div class="pt-2 pagination-sm">
                                <span class="text-black-50">
                                    ({{ $data['issues']->count() }}-{{ $data['issues']->lastItem() }}/{{ $data['issues']->total() }})
                                </span>
                                {{ $data['issues']->links() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 bg-secondary">
                        <div class="row h-100" >
                            @include('issues._asideOptions')
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
