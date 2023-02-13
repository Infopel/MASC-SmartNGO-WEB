@extends('layouts.main', ['title' => $questionnaireCategory->name.' '.__('Modelos de Avaliação')])
@section('content')
    @include('errors.any')
    @livewire('questions-builder', ['questionnaireCategory' => $questionnaireCategory], ['question' => []])
@endsection
