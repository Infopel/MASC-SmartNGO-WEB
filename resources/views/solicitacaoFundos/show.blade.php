@extends('layouts.main', ['title' => __('Solicitação de Fundos')])
@section('content')
    @livewire('budget-approvement-request', $project, $solicitacaoFundos)
@endsection
