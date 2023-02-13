@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session --}}
                        @include('errors.any')
                        <div class="w-100">
                            @if (session('isRemoveTrue'))
                                <div class="alert alert-warning">
                                    {{ session('isRemoveTrue')['msg'] }}
                                    <div>
                                        <h6>{{ __('lang.button_delete').' '.__('lang.label_tracker') }}: <b>{{ session('isRemoveTrue')['tracker_name'] }}</b><h6>
                                        <form method="POST" action='{{ route('tracker.remove', ['tracker'=> session('isRemoveTrue')['tracker_id'] ]) }}'>
                                            @csrf
                                            <input name="tracker" value="{{ session('isRemoveTrue')['tracker_id'] }}" type="hidden">
                                            <div class="text-left">
                                                <button type="submit" class="btn btn-danger">SIM TENHO</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    {{-- /session --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_tracker_plural') }}</h5>
                        </div>
                        @can('gerir_tipos_tarefas', App\Models\User::class)
                            <div class="text-lowercase mr-2">
                                <a href="{{ route('tracker.new') }}" class="text-success">
                                    <i class="icon-plus2"></i>
                                    <span>{{ __('lang.label_tracker_new') }}</span>
                                </a>
                            </div>
                        @endcan
                        {{-- <div class="text-lowercase ">
                            <a href="{{ route('tracker.new') }}" class="text-slate-700">
                                <i class="icon-power2 text-warning"></i>
                                <span>{{ __('lang.field_summary') }}</span>
                            </a>
                        </div> --}}
                    </div>

                    <form action="">
                        <div class="row m-0">
                            <div class="table-responsive">
                                <table class="table border table-sm table-striped table-hover nowrap">
                                    <thead class="table-active">
                                        <th>{{ __('lang.label_tracker') }}</th>
                                        <th></th>
                                        @can('gerir_tipos_tarefas', App\Models\User::class)
                                        <th></th>
                                        @endcan
                                    </thead>

                                    <tbody>
                                        @foreach ($data['trackers'] as $tracker)
                                            <tr>
                                                <td class="p-0 pl-2 pr-2">
                                                    <a href="{{ route('tracker.edit', ['tracker' => $tracker->id]) }}">{{ $tracker->name }}</a>
                                                </td>
                                                @if ($tracker->workflows)
                                                    <td class="p-0"></td>
                                                @else
                                                    <td class="text-center p-0 pl-2 pr-3">
                                                        <i class="icon-warning2 text-warning"></i>
                                                        {{ __('lang.text_tracker_no_workflow') }}
                                                        {{-- (<a href="{{ route('workflows.edit', ['tracker' => $tracker->id]) }}">{{ __('lang.button_edit') }}</a>) --}}
                                                    </td>
                                                @endif
                                                @can('gerir_tipos_tarefas', App\Models\User::class)
                                                    <td class="p-0 pr-3 pl-2 text-right text-nowrap">
                                                        <a href="{{ route('tracker.remove-request', ['tracker' => $tracker->id ]) }}">
                                                            <i class="icon-trash"></i>
                                                            {{ __('lang.button_delete') }}
                                                        </a>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
