@extends('layouts.main', ['title' => __('lang.label_issue_new')])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                {{-- sessions alerts --}}
                @include('errors.any')
                {{-- sessions alerts --}}
            </div>
            <div class="row">
                <div class="col-md-12 mt-0">
                    <form action="{{ route('projects.issues.store', ['project_identifier' => $_project['identifier']]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        {{-- <vue-editor></vue-editor> --}}
                        @livewire('issues-project', ['project_id' => $_project['id']], $issue)
                        {{-- <div class="mt-3 pl-2 row">
                            <button type="submit" class="btn btn-success btn-sm fw-600 pl-3 pr-3 pt-2 pb-2">{{ __('lang.button_create') }}</button>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
