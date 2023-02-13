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
                                <h5>{{ __('lang.label_my_account') }} -
                                    <a href="">{{ $user->full_name}}</a>
                                </h5>
                            </div>
                        </div>
                        <form action="{{ route('user.minha-update_senha') }}" method="POST">
                            @csrf
                            <div class="row">
                                @include('users._auth_form')
                            </div>
                            <div class="">
                                <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">Salvar</button>
                                <a href="{{ url()->previous() }}" class="p0-2 mr-2">{{ __('lang.button_cancel') }}</a>
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
