@extends('layouts.main', ['title' => __('Solicitação de Fundos')])
@section('content')
    @livewire('solicitacao-fundos', $project)
@endsection

