<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @isset($title)
            {{ $title }} |
        @endisset
        {{ config('app.name') }}
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/lang.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
	<!-- Global stylesheets -->
	<link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">

    <!-- Theme JS files -->
    <script src="{!!url('js/core/libraries/jquery.min.js')!!}"></script>

    {{-- <script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script> --}}
    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
    <script type="text/javascript" src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/notifications/jgrowl.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/daterangepicker.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/pickers/anytime.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.date.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/picker.time.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/pickers/pickadate/legacy.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pages/picker_date.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/plugins/forms/selects/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/forms/styling/uniform.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/pages/datatables_advanced.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
	<!-- /theme JS files -->

</head>

<body>
    <div id="app">
        @include('layouts.top_bar')
        @include('layouts.header')
        @include('layouts.nav-bar')

        {{-- content --}}
        @yield('content')
        {{-- /content --}}

        {{-- footer --}}
        <div class="footer- ml-3 mr-3 p-2 border-top text-center">
            <div class="f-note text-black-50 mb-2">
                © 2018-{{ date('Y') }} SGMP<br>Developed by <b><a class="text-black-50" href="">Edilson D Mucanze</a></b>
            </div>
        </div>
    </div>
    <input type="hidden" name="tz" id="tz">
    <script src="{{ asset('js/main.js') }}" defer></script>
</body>
</html>
