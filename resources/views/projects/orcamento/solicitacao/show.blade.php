@extends('layouts.main', ['title' => __('Solicitação de Fundos')])
@section('content')

    {{-- {{ dd([
        $issue, $project
    ]) }} --}}
    @livewire('aprovacao-fundos', $issue, $project)
@endsection
