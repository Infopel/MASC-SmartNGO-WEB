@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="card-block p-3 rounded">
            <div class="row mb-3" style="height:600px">
                <div class="col-md-12">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5>404</h5>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="alert-danger rounded p-1 border border-danger">
                            <i class="icon-warning2"></i>
                            {{ __('lang.notice_file_not_found') }}
                        </div>
                    </div>
                    <div class="mt-2">
                        <p><a href="javascript:history.back()">{{ __('lang.button_back') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
