@extends('layouts.main', ['title' => __('lang.label_spent_time').' Nova Entrada'])
@section('content')
    {{-- @include('errors.any') --}}
    <div class="w-100">
        @if (session('isRemoveTrue'))
            <div class="alert alert-warning">
                <h5>
                    <b>{{ session('isRemoveTrue')['msg'] }}</b>
                </h5>
                <div>
                    <h6>{{ __('lang.button_delete').' '.__('lang.label_spent_time') }} com Realizado: <b>{{ session('isRemoveTrue')['realizado'] }}</b>
                        <br>
                        Criado em: <b>{{ session('isRemoveTrue')['created_on'] }}</b>
                    <h6>
                    <form method="POST" action='{{ route('time_entries.issues.remove', ['time_entries_values'=> session('isRemoveTrue')['time_entries_value_id'] ]) }}'>
                        @csrf
                        <input name="time_entries_values" value="{{ session('isRemoveTrue')['time_entries_value_id'] }}" type="hidden">
                        <div class="text-left">
                            <button type="submit" class="btn btn-sm btn-danger">SIM TENHO</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
    {{-- {{ dd($customized_id) }} --}}
    @livewire('time-entries', $issue, $timelog_activities, $despesasRealizadas, $type, $customized_id)
@endsection
