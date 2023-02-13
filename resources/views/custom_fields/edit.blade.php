@extends('layouts.main', ['title' =>  'Editar '.$custom_field->name.' - '.__('lang.label_custom_field_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">
                    {{-- session rows --}}
                    <div class="w-100">
                        @if (session('success'))
                            <div class="ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-success">
                                <i class="icon-checkmark"></i>
                                {{ session('success') }}
                            </div>
                        @elseif(session('erros'))
                            <div class="ml-0 p-2 alert alert-danger">
                                <i class="icon-warning2"></i>
                                {{ session('erros') }}
                            </div>
                        @endif
                    </div>
                    {{-- /session rows --}}

                    <div class="">
                        <h5>
                            <a href="{{ route('custom_fields.index') }}">
                            {{ __('lang.label_custom_field_plural') }}</a> »
                            {{ $label }}</a> »
                            {{ $custom_field->name }}
                        </h5>
                    </div>

                    <div class="">
                        <form action="{{ route('custom_fields.update', ['custom_field' => $custom_field]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="custom_field[type]" value="{{ $custom_field->type }}">
                            <input type="hidden" name="custom_field[field_format]" value="{{ $custom_field->field_format }}">
                            <div class="">
                                <custom-fields :custom_field="{{ $custom_field }}" :is_extra_options="false" :is_edit="true"></custom-fields>
                            </div>
                            @can('editar_campos_personalizados', App\Models\User::class)
                                <div class="col pl-0 pt-3 pr-2">
                                    <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __("lang.button_update") }}</button>
                                </div>
                            @endcan
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
