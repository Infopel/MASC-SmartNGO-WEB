@extends('layouts.main', ['title' => __('lang.label_issue_status_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session rows --}}
                    <div class="">
                        @include('errors.any')
                    </div>
                    {{-- /session rows --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_issue_status_plural') }}</h5>
                        </div>
                        <div class="text-lowercase mr-2">
                            <a href="{{ route('issue_statuses.new') }}" class="text-success">
                                <i class="icon-plus2"></i>
                                <span>{{ __('lang.label_issue_status_new') }}</span>
                            </a>
                        </div>
                    </div>

                    <div class="row m-0">
                        <div class="table-responsive">
                            <table class="table border table-sm table-striped table-hover nowrap">
                                <thead class="table-active">
                                    <th>{{ __('lang.label_issue_status') }}</th>
                                    <th class="text-center">{{ __('lang.field_is_closed') }}</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data['issues_status'] as $issue_status)
                                        <tr>
                                            <td class="p-0 pl-2 pr-2">
                                                <a href="{{ route('issue_statuses.edit', ['id' => $issue_status->id]) }}">{{ $issue_status->name }}</a>
                                            </td>
                                            <td class="text-center p-0 pl-2 pr-3">
                                                @if ($issue_status->is_closed)
                                                    <i class="icon-checkmark-circle text-success"></i>
                                                @endif
                                            </td>
                                            <td class="text-right p-0 pl-2 pr-2">
                                                <a class="" href="{{ route('issue_statuses.remove', ['id' => $issue_status->id]) }}" onclick="event.preventDefault(); document.getElementById('remove_i_status_{{ $issue_status->id }}').submit();">
                                                    <i class="icon-trash"></i>
                                                    {{ __('lang.button_delete') }}
                                                </a>
                                                <form id="remove_i_status_{{ $issue_status->id }}" action="{{ route('issue_statuses.remove', ['id' => $issue_status->id ]) }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" class="d-none" name="i_status_id" value="{{ $issue_status->id }}">
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
