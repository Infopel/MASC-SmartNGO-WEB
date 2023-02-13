<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Relatorio'}}</title>


    <style>
        .border {
            border: 1px solid !important;
        }

        .border-top {
        border-top: 1px solid !important;
        }

        .border-right {
            border-right: 1px solid !important;
        }

        .border-bottom {
            border-bottom: 1px solid !important;
        }

        .border-left {
        border-left: 1px solid !important;
        }

        .border-0 {
            border: 0 !important;
        }

        .border-top-0 {
            border-top: 0 !important;
        }

        .border-right-0 {
            border-right: 0 !important;
        }

        .border-bottom-0 {
            border-bottom: 0 !important;
        }

        .border-left-0 {
            border-left: 0 !important;
        }

        .border-primary {
            border-color: #3490dc !important;
        }

        .border-secondary {
            border-color: #6c757d !important;
        }

        .border-success {
            border-color: #38c172 !important;
        }

        .border-info {
            border-color: #6cb2eb !important;
        }

        .border-warning {
            border-color: #ffed4a !important;
        }

        .border-danger {
            border-color: #e3342f !important;
        }

        .border-light {
            border-color: #f8f9fa !important;
        }

        .border-dark {
            border-color: #343a40 !important;
        }

        .border-white {
            border-color: #fff !important;
        }
        .p-2 {
            padding: 0.5rem !important;
        }
        .table {
            border-collapse: collapse !important;
        }

        .table td,
        .table th {
            background-color: #fff !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }
        .text-justify {
            text-align: justify !important;
        }

        .text-wrap {
            white-space: normal !important;
        }

        .text-nowrap {
            white-space: nowrap !important;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }
        .page_break { page-break-before: always; }
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; }
    </style>
</head>
<body>

    <div>
        <center style="color:#121517">
            <img src="{{ asset('images/client_logo.png') }}" style="margin-top: 0px; width: 100px !important;height: 100px !important;" alt="logo">
            <h3 style="color:#27343a; margin-top: -8px; margin-bottom:-5px;">
                {{ $application['app_client_name'] }}
            </h3>
            {{-- <p>{{ $header->getCLIENTE_ENDERECO() }}</p> --}}
        </center>
    </div>

    <div>
        @yield('content')
    </div>
</body>
</html>
