@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                @if ($news->project !== null ? $news->project->identifier == 5 : false)
                    <div class="col-md-12">
                        <div class="pt-1 pb-1 pl-3 pr-3 alert alert-danger text-center">
                            <i class="icon-lock2" style="font-size:90%"></i>
                            {{ __('lang.text_project_closed') }}
                        </div>
                    </div>
                @endif
                <div class="col-md-12 col-lg-12 bg-white p-3">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_news') }} - <span class="text-muted">{{ __('lang.label_news_plural') }}</span></h5>
                        </div>

                        <div class="">
                            @if ($news->project ?? false)
                                @if ($news->project['status'] !== 5)
                                    <a href="{{ route('project.new-news', ['project_identifier' => $news->project['identifier']]) }} " class="text-success">
                                        <i class="icon-plus-circle2"></i>
                                        <span>{{ __('lang.label_news_new') }}</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('news.create') }} " class="text-success">
                                    <i class="icon-plus-circle2"></i>
                                    <span>{{ __('lang.label_news_new') }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    <hr class="mt-0 mb-3">

                    {{-- error fontEnd handler --}}
                    @include('errors.any')
                    {{-- / error fontEnd handler --}}

                    <div class="row">
                        <div class="col-md-4 col-lg-3 border-right">
                            @foreach ($newses as $item)
                                <div class="p-3 bg-light rounded mb-2 {{ $item->id == $news->id ? 'active-news' : '' }}">
                                    <div class="plan-title text-capitalize mb-2">
                                        @if ($item->project !== null )
                                            <h6 class="mb-0">
                                                <a href="{{ route('projects.overview', ['project_identifier' => $item->project->identifier]) }}" class="link-option">
                                                    <span>{{ $item['project']->name }}</span>
                                                </a>
                                            </h6>
                                        @endif
                                        <h5 class="mb-0">
                                            <a href="{{ route('news.show', ['news' => $item->id]) }}">
                                                <span>{{ $item->title }}</span>
                                            </a>
                                        </h5>
                                        <span class="text-lowercase text-black-50">
                                            {!! $item->summary !!}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-8 col-lg-9">
                            <div class="d-md-flex">
                                <div class="flex-grow-1">
                                    <h4>
                                        @if ($news->project !== null )
                                            <a href="{{ route('projects.news', ['project_identifier' => $news->project->identifier]) }}">{{ __('lang.label_news_plural') }}</a> » {{ $news->title }}
                                        @else
                                            {{ __('lang.label_news_plural') }} » {{ $news->title }}
                                        @endif
                                        <a href="{{ route('news.edit', ['news' => $news->id ]) }}" title="Editar">
                                            <i class="icon-pencil5"></i>
                                        </a>
                                    </h4>
                                </div>
                                <div class="d-block">
                                    {{ \Carbon\Carbon::parse($news->created_on)->diffForHumans() }}
                                </div>
                            </div>

                            <div class="mt-2 mb-2">
                                {!! $news->description !!}
                            </div>
                            <div>
                                <table>
                                    <tbody>
                                        @foreach ($news->attachments as $attachment)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('attachments.getDocument', ['attachment' => $attachment, 'filename' => $attachment->filename]) }}">{{ $attachment->filename }}</a>
                                                </td>
                                                <td class="pl-2 text-black-50">{{ $attachment->user->full_name }} - {{ $attachment->created_on }} </td>
                                                <td>
                                                    <a href="#">
                                                        <i class="icon-trash" style="font-size: 13px;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    @if (sizeof($newses) <= 0)
                        <div class="alert-warning p-1 text-center border">
                            {{ __('lang.label_no_data') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
