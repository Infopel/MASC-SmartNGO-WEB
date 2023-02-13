@extends('layouts.main', ['title' => __('lang.label_news_plural')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 col-lg-12 bg-white p-3">
                    <div class="d-flex mb-0">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_news') }} - <span class="text-muted">{{ __('lang.label_news_plural') }}</span></h5>
                        </div>

                        <div class="">
                            @if ($project ?? false)
                                <a href="{{ route('project.new-news', ['project_identifier' => $project['identifier']]) }} " class="text-success">
                                    <i class="icon-plus-circle2"></i>
                                    <span>{{ __('lang.label_news_new') }}</span>
                                </a>
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
                                <div class="p-3 bg-light rounded mb-2">
                                    <div class="plan-title text-capitalize mb-2">
                                        @if (!request()->is('projects/*'))
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
                                        @else
                                            <h5 class="mb-0">
                                                @if ($item->project == null )
                                                    <a href="{{ route('news.show', ['news' => $item->id]) }}">
                                                        <span>{{ $item->title }}</span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('projects.news.show', ['project_identifier' => $item->project->identifier, 'news' => $item->id]) }}">
                                                        <span>{{ $item->title }}</span>
                                                    </a>
                                                @endif
                                            </h5>
                                        @endif

                                        <span class="text-lowercase text-black-50">
                                            {!! $item->summary !!}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-8 col-lg-9">

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
