@extends('layouts.main', ['title' => __('lang.button_edit') .' '. $issue->tracker['name'].' #'.$issue->id.': '.$issue->subject])
@section('content')
    <div class="row m-0 p-2">
        <div class="col-md-12">
            <div class="row">
                {{-- sessions alerts --}}
                @include('errors.any')
                {{-- sessions alerts --}}
            </div>
            <div class="row">
                <div class="col-md-12 mt-2">
                    <form action="{{ route('issues.update', ['issue' => $issue->id]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        >
                        @csrf
                        @livewire('issues-project', ['project_id' => $issue->project->id], $issue->toArray())
                        <div class="mt-3 row">
                            <button type="submit" class="p-2 mr-2" style="line-height: 0.5 !important;">{{ __('lang.button_update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
