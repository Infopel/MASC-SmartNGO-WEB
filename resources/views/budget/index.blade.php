@extends('layouts.main')
@section('content')
    @include('errors.any')
    @livewire('budget', $project, ['url_new_budget' => $project->url_new_budget()])
@endsection
