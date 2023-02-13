@extends('layouts.main', ['title' =>  __('lang.label_custom_field_new') .' - '.__('lang.label_custom_field_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- session rows --}}
                    <div class="w-100">

                        @if ($errors->any())
                            <div class="alert alert-danger p-2">
                                <ul class="m-0 list-unstyled pl-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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

                    @if (isset($_GET['type']) && $is_valid_type)

                        <div class="text-wrap">
                            <div class="">
                                <h5>
                                    <a href="{{ route('custom_fields.index') }}">
                                    {{ __('lang.label_custom_field_plural') }}</a> »
                                    {{ $label }}</a> »
                                    {{ __('lang.label_custom_field_new') }}
                                </h5>
                            </div>

                            <div class="">
                                <form action="{{ route('custom_fields.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="custom_field[type]" value="{{ $type }}">
                                    <div class="">
                                        @if ($type == 'IssueCustomField')
                                            <custom-fields
                                                :is_edit='false'
                                                :is_extra_options="true"
                                                :issues_type="{{ $extra_options['issues_type'] }}"
                                                :roles="{{ $extra_options['roles'] }}"
                                                :projects="{{ $extra_options['projects'] }}
                                                ">
                                            </custom-fields>
                                        @else
                                            <custom-fields :is_extra_options="false" :is_edit='false'></custom-fields>
                                        @endif
                                    </div>
                                    <div class="col pl-0 pt-3 pr-2">
                                        <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __('lang.button_save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-wrap">
                            <div class="">
                                <h5>
                                    <a href="{{ route('custom_fields.index') }}">{{ __('lang.label_custom_field_plural') }}</a> »
                                    {{ __('lang.label_custom_field_new') }}
                                </h5>
                            </div>
                        </div>


                        <form action="{{ route('custom_fields.new') }}" method="GET">
                            {{-- @csrf --}}
                            <div class="">
                                @include('custom_fields._type')
                            </div>
                            <div class="col pl-0 pt-3 pr-2">
                                <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __('lang.label_next') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    <div class="col-lg-3 col-md-4">
        @include('admin._menu')
    </div>
    </div>
@endsection
