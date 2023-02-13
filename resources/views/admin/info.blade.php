@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8">
            <div class="row">
                <div class="card-block p-3">
                    <h5>{{ __('lang.label_information_plural') }}</h5>
                    <p class="fw-500">SGMP 0.4.6.stable</p>
                    <div class="bg-light">
                        <div class="text-black-50">
<pre class>
Environment:
    SGMP version                   0.4.6.stable
    PHP version                    7.3 (2019-11-21) [i386-mingw32]
    Laravel version                6.1^
    Environment                    production
    Database adapter               Mysql2
SCM:
    Git                            2.19.2
    Filesystem
SGMP plugins:
    no plugin installed
</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
@endsection
