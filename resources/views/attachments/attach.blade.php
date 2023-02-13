@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2 main-row-content">
        <div class="col-md-12 bg-white p-3">

            @include('errors.any')

            <div class="d-md-flex mb-0">
                <div class="flex-grow-1">
                    <h5>{{ $attachment->filename }}</h5>
                </div>
                <div class="">
                    <a href="{{ $attachment->download_link }}" class="text-success">
                        <i class="icon-plus-circle2"></i>
                        <span>{{ __('lang.button_download') }}</span>
                    </a>
                </div>
            </div>


            <hr class="mt-0 mb-3">
            @if ($attachment->content_type == "image/jpeg" || $attachment->content_type == "image/jpg" || $attachment->content_type == "image/png")
                <img src="{{ asset('storage/'.$attachment->disk_directory . '/' . $attachment->disk_filename) }}" alt="{{ $attachment->filename }}" style="width:inherit">
            @else
                <div class="alert-warning p-1 text-center border">
                    {!! __('lang.label_no_preview_alternative_html',
                        [
                            'link' => '<a target="_blank" href="'.$attachment->download_link.'">download</a>'
                        ])
                    !!}
                </div>
            @endif
        </div>
    </div>
@endsection
