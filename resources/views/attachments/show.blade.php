@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12 bg-white">
            <div class="p-2 pt-3">
                <div class="d-flex">
                    <h5 class="flex-grow-1">
                        <span class="text-black-50">{{ __('lang.project_module_documents') }}:</span>
                        <span>Documents</span>
                    </h5>
                    <div class="">
                        <a href="" class="btn btn-light btn-sm">
                            <i class="icon-pencil5"></i>
                            <span>{{ __('lang.button_edit') }}</span>
                        </a>
                        <a href="" class="btn btn-light btn-sm btn-outline-success">
                            <i class="icon-plus2"></i>
                            <span>{{ __('lang.label_new') }}</span>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive nowrap mt-3">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <th>#</th>
                                    <th>{{ __('lang.project_module_documents') }}</th>
                                    <th>{{ __('lang.field_filesize') }}</th>
                                    {{-- <th>{{ __('lang.field_type') }}</th> --}}
                                    <th>{{ __('lang.label_added_by') }}</th>
                                    <th>{{ __('lang.field_created_on') }}</th>
                                </thead>

                                <tbody>
                                    @foreach ($data['attachments'] as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                <a href="{{ route('attachments.getDocument', ['attachment' => $item->attach_id, 'filename' => $item->filename]) }}">{{ $item->filename }}</a>
                                            </td>
                                            <td>{{ $item->filesize }} kb</td>
                                            {{-- <td>{{ $item->content_type }}</td> --}}
                                            <td>{{ $item->author_firstname.' '.$item->author_lastname }}</td>
                                            <td>{{ $item->created_on }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="font-size:95%">
                            <h4 class="text-black">{{ $data['attachments'][0]['title'] }}</h4>
                            <p class="text-black-50" >
                                {!! $data['attachments'][0]['description'] !!}
                                {{-- {!! nl2br(e($data['attachments'][0]['description'])) !!} --}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
