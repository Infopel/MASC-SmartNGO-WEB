@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="h-100">
                <div class="row h-100 rounded">
                    <div class="card-block p-3 rounded">
                        {{-- session rows --}}
                        @include('errors.any')
                        {{-- /session rows --}}

                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h5>{{ __('lang.label_my_account') }}</h5>
                            </div>
                            <div class="text-lowercase mr-2">
                                <a href="#" class="text-success">
                                    <i class="icon-mail-read"></i>
                                    <span>{{ __('lang.label_email_address_plural') }}</span>
                                </a>
                            </div>
                            <div class="text-lowercase ">
                                <a href="{{ route('app.minha-conta_senha') }}" class="text-slate-700">
                                    <i class="icon-lock2 text-warning"></i>
                                    <span>{{ __('lang.button_change_password') }}</span>
                                </a>
                            </div>
                        </div>

                        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                @include('users._form', ['custom_fields' => $custom_fields, 'is_desabled' => false])
                                <div class="pl-3 w-100">
                                    <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                                        <input style="margin:0px !important" type="checkbox" name="is_iva_valid" id="isAdmin" value="isIva" class="styled">
                                        Enviar informação da nova conta para o usuário
                                    </label>
                                </div>
                                <div class="p-2 pl-3">
                                    <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 border-left aside-panel">
                    <h5>Minha conta</h5>
                    <p>
                        Usuário: <strong><a class="user active" href="">{{ $user->login }}</a></strong><br>
                        Criado em: {{ $user->created_on ?: $user->updated_on }}
                    </p>
                    <p>
                        Chave de acesso criada
                        {{-- 21 dias atrás --}}
                        (<a rel="nofollow" data-method="post" href="#">Redefinir</a>)
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
