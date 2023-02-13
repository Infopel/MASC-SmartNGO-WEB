<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'INFOPEL') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/auth/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <div class="row m-0 n-header border-bottom my-shadow">
            <div class="navbar navbar-light text-white col-md-12 top-header">
                <div class="">
                    <div class="lc-header p-o mr-auto" style="padding:0px !important">
                        <div class="text-white">
                            <div class="container-fluid">

                                
                              <a class="navbar-brand fw-600 m-0 text-white " style="font-size: 215%"  href="{{ url('/') }}"><img src="images/nav_masc.png"  alt="Logo"  style="width:100px; height: 65px; " class="mr-2">{{ $settings['app_short_name'] ?? 'INFOEPL-APP' }}
                                 
                                </a>  
                            </div> 
                           
                        </div>
                        <small style="font-size: 90%">{{ $settings['app_title'] }}</small>

                    </div>
                </div>
            </div>
        </div>

        <main class="py-4">
            @yield('content')
        </main>

        {{-- footer --}}
        <div class="footer- ml-3 mr-3 p-2 border-top text-center">
            <div class="f-note text-black-50 mb-2">
                © 2018-{{ date('Y') }} {{ $settings['app_short_name'] ?? 'INFOEPL-APP' }}<br>Desenvolvido Por <b><a class="text-black-50" href="">INFOPEL</a></b>
            </div>
        </div>
    </div>
</body>
</html>
