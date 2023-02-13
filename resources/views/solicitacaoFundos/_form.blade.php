@extends('layouts.main', ['title' => __('Formulario de Solicitação de Fundos')])
@section('content')
<div class="setp-container step-info-content d-flex justify-content-center w-100">
    <div class="col-md-9 p-0 mb-2 mt-2">
        {{-- session rows --}}
        <div class="w-100">
            @if ($errors->any())
                <div class="alert alert-danger p-2 m-0">
                    <ul class="m-0 list-unstyled pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        {{-- /session rows --}}
    </div>
</div>
    @livewire('form-solicitacao-fundos', $project, $requisicaoFundos ?? null)
@endsection
