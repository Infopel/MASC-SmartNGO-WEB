@extends('layouts.main', ['title' => __('lang.label_file_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 col-lg-12 bg-white p-3">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_file_plural') }}</h5>
                        </div>
                    </div>
                    <hr class="mt-0 mb-3">

                    {{-- error fontEnd handler --}}
                    @include('errors.any')
                    {{-- / error fontEnd handler --}}

                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-stripped">
                            <thead>
                                <th>Arquivo</th>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>Nome</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
