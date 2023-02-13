@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="card-block p-3 rounded" style="min-height:70vh">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h4>Minha Pagina</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="border p-2">
                        <h5>
                            <a href="">{{ __('lang.label_assigned_to_me_issues') }}</a>
                            ({{ $user->issues_assigned_to_me->count() }})
                        </h5>
                        <div class="table-responsive">
                            <table class="table border table-sm table-hover table-striped text-center">
                                <thead class="table-active">
                                    <th>#</th>
                                    <th>{{ __('lang.label_project') }}</th>
                                    <th>{{ __('lang.field_type') }}</th>
                                    <th>{{ __('lang.label_status') }}</th>
                                    <th>{{ __('lang.field_title') }}</th>
                                </thead>

                                <tbody>
                                    @foreach ($user->issues_assigned_to_me as $issue)
                                        @if ($issue->project !== null)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">{{ $issue->id }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('projects.overview', ['project_identifier' => $issue->project['identifier']]) }}">
                                                        {{ $issue->project['name'] }}
                                                    </a>
                                                </td>
                                                <td> {{ $issue->tracker['name'] }} </td>
                                                <td> {{ $issue->status['name'] }} </td>
                                                <td>
                                                    <a href="{{ route('issues.show', ['issue' => $issue['id']]) }}">
                                                        {{ $issue['subject'] }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if ($user->issues_assigned_to_me->count() == 0)
                            <div class="alert-warning rounded p-1 text-center border text-black-50">
                                {{ __('lang.label_no_data') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border p-2">
                        <h5>
                            <a href="">{{ __('lang.label_reported_issues') }}</a>
                            ({{ $user->issues->count() }})
                        </h5>

                        <div class="table-responsive">
                            <table class="table border table-sm table-hover table-striped text-center">
                                <thead class="table-active">
                                    <th>#</th>
                                    <th>{{ __('lang.label_project') }}</th>
                                    <th>{{ __('lang.field_type') }}</th>
                                    <th>{{ __('lang.label_status') }}</th>
                                    <th>{{ __('lang.field_title') }}</th>
                                </thead>

                                <tbody>
                                    @foreach ($user->issues as $issue)
                                        @if ($issue->project !== null)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('issues.show', ['issue' => $issue->id]) }}">{{ $issue['id'] }}</a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('projects.overview', ['project_identifier' => $issue->project['identifier']]) }}">
                                                        {{ $issue->project['name'] }}
                                                    </a>
                                                </td>
                                                <td> {{ $issue->tracker['name'] }} </td>
                                                <td> {{ $issue->status['name'] }} </td>
                                                <td>
                                                    <a href="{{ route('issues.show', ['issue' => $issue['id']]) }}">
                                                        {{ $issue['subject'] }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($user->issues->count() == 0)
                            <div class="alert-warning rounded p-1 text-center border text-black-50">
                                {{ __('lang.label_no_data') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
