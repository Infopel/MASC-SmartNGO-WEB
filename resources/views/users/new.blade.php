@extends('layouts.main')
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
                    </div>
                    {{-- /session rows --}}

                    <h5><a href="{{ route('users.index') }}">{{ __('lang.label_user_plural') }}</a> » {{ __('lang.label_user_new') }}</h5>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            @include('users._form', ['custom_fields' => $custom_fields, 'is_desabled' => false])
                            <div class="pl-3 w-100">
                                <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                                    <input style="margin:0px !important" type="checkbox" name="send_information" id="send_information" value="1" class="styled">
                                    Enviar informação da nova conta para o usuário
                                </label>
                            </div>
                            <div class="pl-3 pt-2">
                                <input type="submit" class="mr-2" value="{{ __("lang.button_create") }}" name="submit"/>
                                <input type="submit" class="mr-2" value="{{ __("lang.button_create_and_continue") }}" name="submit"/>
                            </div>
                            {{-- <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Criar e Continuar</button> --}}
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
