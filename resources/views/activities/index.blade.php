@extends('layouts.main')
@section('content')
    <div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8">
            <div class="row h-100">
                <div class="card-block p-3" style="min-height:75vh">
                    <div class="mb-3">
                        <h4 class="m-0">{{ __('lang.label_activity') }}</h4>
                        <span class="small text-black-50">
                            {{-- <i>De 29 Nov 2019 a 28 Dez {2019}</i> --}}
                        </span>
                    </div>

                    <div class="my_timeline mt-2">

                        @foreach ($activities['issues'] as $key => $issues_activitys)
                            <div class="">
                                <div class="text-left bg-white timeline-date text-muted p-0 m-0 mb-1 small">

                                    <h5 class="text-semibold"><i class="icon-history position-left"></i> {{ $key }}</h5>
                                </div>
                                @foreach ($issues_activitys as $issues_activity)
                                    <div class="">
                                        <div class="my_timeline-container left">
                                            <div class="my_timeline-icon">
                                                {{-- <i class="icon-add-to-list position-left text-success m-0"></i> --}}
                                                <i class="icon-checkmark-circle position-left text-success m-0"></i>
                                            </div>
                                            <div class="my_timeline-content">
                                                <div class="d-flex border-bottom">
                                                    <div class="">
                                                        <h6 class="mb-0">
                                                            {{ $issues_activity['tracker']['name'] }}
                                                            <a href="{{ route('issues.show', ['issue' => $issues_activity['id']]) }}">
                                                                # {{ $issues_activity['id'] }}
                                                                ({{ $issues_activity['status']['name'] }})
                                                                {{ $issues_activity['subject'] }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div class="flex-grow-1 text-right">
                                                        <h6 class="small text-black-50 fw-500">
                                                            {{ $issues_activity['_time'] }}
                                                        </h6>
                                                    </div>
                                                </div>
                                                <span style="font-size: 97%;" class="fw-300">
                                                    <a href="{{ route('users.show', ['user' => $issues_activity['author']['id'] ]) }}" class="link-option fw-400">
                                                        {{ $issues_activity['author']['full_name'] }}
                                                    </a>
                                                </span>
                                                <div class="small min-l-h text-black-50" style="line-height:1.3">
                                                    {{ $issues_activity['project']['name'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @if ($activities['issues'] == [])
                        <div class="alert-warning rounded p-1 text-center border text-black-50">
                            {{ __('lang.label_no_data') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="row h-100">
                <div class="pl-3 card-block w-100 border-left aside-panel">
                    <div class="pl-3">
                        <form id="activity_scope_form" action="#" accept-charset="UTF-8" method="get">
                            @csrf
                            <h3>Atividade</h3>
                            <ul class="list-unstyled">
                                <li class="m-0">
                                    <input type="checkbox" name="show_issues" id="show_issues" value="1" checked="checked">
                                    <label for="show_issues" class="m-0">
                                        <a href="#?show_issues=1">Atividades</a>
                                    </label>
                                </li>
                                <li>
                                    <input type="checkbox" name="show_changesets" id="show_changesets" value="1">
                                    <label for="show_changesets" class="m-0">
                                        <a href="#?show_changesets=1">Conjunto de alterações</a>
                                    </label>
                                </li>
                                <li>
                                    <input type="checkbox" name="show_news" id="show_news" value="1">
                                    <label for="show_news" class="m-0">
                                        <a href="#?show_news=1">Notícias</a>
                                    </label>
                                </li>
                                <li>
                                    <input type="checkbox" name="show_documents" id="show_documents" value="1">
                                    <label for="show_documents" class="m-0">
                                        <a href="#?show_documents=1">Documentos</a>
                                    </label>
                                </li>
                                <li>
                                    <input type="checkbox" name="show_wiki_edits" id="show_wiki_edits" value="1">
                                    <label for="show_wiki_edits" class="m-0">
                                    <a href="#?show_wiki_edits=1">Edições Wiki</a>
                                    </label>
                                </li>
                                <li>
                                    <input type="checkbox" name="show_time_entries" id="show_time_entries" value="1">
                                    <label for="show_time_entries" class="m-0">
                                        <a href="#?show_time_entries=1">Tempos gastos</a>
                                    </label>
                                </li>
                            </ul>
                            <p>
                                <input type="submit" name="submit" value="Aplicar" class="button-small">
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
