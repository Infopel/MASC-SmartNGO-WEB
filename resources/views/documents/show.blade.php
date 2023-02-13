@extends('layouts.main', ['title' => $document->title. ' - '. $document->project->name])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12 bg-white">
            <div class="p-2 pt-3">
                <div class="d-flex">
                    <h5 class="flex-grow-1">
                        <span class="text-black-50">{{ __('lang.project_module_documents') }}:</span>
                        <span>{{ $document->title }}</span>
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
                                    @foreach ($document['attachments'] as $key => $attachment)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>
                                                <a href="{{ route('attachments.getDocument', ['attachment' => $attachment->id, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                            </td>
                                            <td>{{ $attachment->filesize }} kb</td>
                                            {{-- <td>{{ $attachment->content_type }}</td> --}}
                                            <td>{{ $attachment->user->full_name }}</td>
                                            <td>{{ $attachment->created_on }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="font-size:95%">
                            <h4 class="text-black">{{ $document['title'] }}</h4>
                            <p class="text-black-50" >
                                {!! $document['description'] !!}
                                {{-- {!! nl2br(e($data['attachments'][0]['description'])) !!} --}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
