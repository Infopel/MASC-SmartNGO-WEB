<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SGMP 500 error</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="/js/lang.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
	<!-- Global stylesheets -->
    <link href="{{ asset('css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.7.15/c3.min.css" class=""> --}}

    <!-- Theme JS files -->
    <script src="{!!url('js/core/libraries/jquery.min.js')!!}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> --}}

    <script type="text/javascript" src="{{ asset('js/core/libraries/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/tables/datatables/datatables.min.js') }}"></script>

    {{-- <script type="text/javascript" src="{{ asset('js/plugins/visualization/d3/d3.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('js/plugins/visualization/c3/c3.min.js') }}"></script> --}}

    <script type="text/javascript" src="{{ asset('js/plugins/notifications/jgrowl.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/ui/moment/moment.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script> --}}
    {{-- https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js --}}
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
    <!-- /theme JS files -->
    <link href="{{ asset('css/quick.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
    @livewireStyles
</head>

<body>
    <div id="app">

        <div>
            <h1>Internal error</h1>
            <p>An error occurred on the page you were trying to access.<br>
            If you continue to experience problems please contact your administrator for assistance.</p>
            <p>If you are the administrator, check your log files for details about the error.</p>
            <p><a href="javascript:history.back()">Back</a></p>
            <p><a href="mailto:edilsonhmberto@gmail.com">edilsonhmberto@gmail.com</a></p>
        </div>
        {{-- /content --}}

        {{-- footer --}}
        <div class="footer- ml-3 mr-3 p-2 border-top text-center">
            <div class="f-note text-black-50 mb-2">
                © 2018-{{ date('Y') }} SGMP<br>Desenvolvido Por <b><a class="text-black-50" href="">INFOPEL</a></b>
            </div>
        </div>

        @livewire('quick')

    </div>

    <input type="hidden" name="tz" id="tz">
    <script src="{{ asset('js/main.js') }}" defer></script>

    @yield('scripts')
    @livewireScripts

    <script>
        // $(function () {
        //     $('[data-toggle="tooltip"]').tooltip()
        // })
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5f5f3afbf0e7167d001014c9/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
