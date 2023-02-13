@extends('layouts.main', ['title' => __('New - Solicitação de Fundos')])
@section('content')
    @livewire('solicitacao-fundos-view', $project)
@endsection
