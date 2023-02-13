@extends('layouts.app')

@section('content')
<div class="container">
    <div class='d-flex justify-content-center mt-1'>
        <img
            src='images/logo_masc.png'
            alt=''
            width='150'
            class="rounded"
        />
    </div>
    <div id="login-form" class="justify-content-center mt-2">
        <h4>{{ $settings['app_short_name'] ?? 'GESPRO' }}</h4>
        <hr class="m-0 mb-2">
        <form action="{{ route('login') }}" accept-charset="UTF-8" method="post">
            @csrf
            {{-- <input type="hidden" name="back_url" value="http://18.219.77.220/"> --}}

            <label for="email" class="p-0">{{ __('auth.username') }}</label>
            <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>
            @error('login')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror



            <label for="password" class="mt-3">
                {{ __('auth.password') }}
                <a class="lost_password" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            </label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            {{-- <input type="submit" name="send-login" value="Login" tabindex="5" id="login-submit"> --}}

            <button type="submit" class="btn btn-dark w-100">{{ __('Login') }}</button>
        </form>
    </div>

</div>
@endsection
