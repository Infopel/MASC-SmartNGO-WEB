@extends('layouts.main', ['title' => $question->title.' - '.$questionnaireCategory->name])
@section('content')
    @include('errors.any')
    @livewire('questions-builder', ['questionnaireCategory' => $questionnaireCategory], ['question' => $question], true)
@endsection
