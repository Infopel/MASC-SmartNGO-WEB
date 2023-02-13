@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session rows --}}
                    <div class="w-100">
                        @if (session('status'))
                            <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                <i class="icon-checkmark"></i>
                                {{ session('status') }}
                            </div>
                        @elseif(session('erros'))
                            <div class="ml-0 p-2 alert alert-danger">
                                <i class="icon-warning2"></i>
                                {{ session('erros') }}
                            </div>
                        @endif
                    </div>
                    {{-- /session rows --}}

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_group_plural') }}</h5>
                        </div>
                        <div class="text-lowercase ">
                            <a href="{{ route('groups.new') }}" class="text-success">
                                <i class="icon-plus2"></i>
                                <span>{{ __('lang.label_group_new') }}</span>
                            </a>
                        </div>
                    </div>
                    <fieldset class="border p-3 pt-0">
                        <legend class="pl-2 pr-2 p-0 m-0 w-auto">Filstros</legend>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="">Situação</label>
                                <select name="" class="form-control form-control-sm pr-3">
                                    <option value="">Activo</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-striped table-hover border nowrap">
                            <thead class="table-active text-center">
                                <th>{{ __('lang.label_group') }}</th>
                                <th>{{ __('lang.label_user_plural') }}</th>
                                <th style="min-width: 80px;"></th>
                            </thead>
                            <tbody>
                                @foreach ($data['groups'] as $group)
                                <tr class="{{ $group->status == 1 ? '' : "text-black-50" }}">
                                    @if ($group->default)
                                        <td  class="p-0 pl-2 pr-2">
                                            <a disabled href="#">
                                                <i>{{ $group->lastname }}</i>
                                            </a>
                                        </td>
                                        <td class="p-0 pl-2 pr-2"></td>
                                        <td class="p-0 pl-2 pr-2"></td>
                                    @else
                                        <td class="p-0 pl-2 pr-2">
                                            <a href="{{ route('groups.edit', ['group' => $group->id]) }}">
                                                {{ $group->lastname }}
                                            </a>
                                        </td>
                                        <td class="p-0 pl-2 pr-2 text-center">{{ $group->_users }}</td>
                                        <td class="p-0 pl-2 pr-2 text-right">
                                            <a class="" href="{{ route('groups.remove', ['group' => $group->id]) }}" onclick="event.preventDefault(); document.getElementById('remove_group_{{ $group->id }}').submit();">
                                                <i class="icon-trash"></i>
                                                {{ __('lang.button_delete') }}
                                            </a>
                                            <form id="remove_group_{{ $group->id }}" action="{{ route('groups.remove', ['group' => $group->id ]) }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" class="d-none" name="group_id" value="{{ $group->id }}">
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
