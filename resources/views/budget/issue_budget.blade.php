@extends('layouts.main', ['title' => __("lang.project_module_budget").' '.$issue->subject])
@section('content')
    @include('errors.any')
    @livewire('budget', $issue, ['url_new_budget' => $issue->url_new_budget()])
@endsection
