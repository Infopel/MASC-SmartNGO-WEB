@extends('layouts.main')
@section('content')
    {{-- @livewire('activity-plan-approvement-component') --}}

    @include('errors.any')

    <div class="p-2 bg-white m-1">
        <div class="p-2 pl-3 pr-3">
            <h2 class="m-0" style="font-size: 100% !important;">Plano de Aprovação PFE (Programatico, Financiero, Executivo)</h2>
        </div>
        <div class="col-md-12 m-0 p-0 mb-4" style="min-height: 80vh;">
            <div>
                <div class="mt-3">
                    <nav>
                        <div class="nav nav-tabs mb-0" id="nav-tab" role="tablist">
                            @foreach ($workflows as $key => $workflow)
                                <a class="nav-item nav-link link-option {{ $key == 0 ? 'show active' : null }}" id="nav-info-{{ str_replace(' ', '', $workflow->description) }}" data-toggle="tab" href="#nav-{{ str_replace(' ', '', $workflow->description) }}" role="tab" aria-controls="nav-{{ str_replace(' ', '', $workflow->description) }}" aria-selected="true" wire:click="toogleTab('resumo')">
                                    {{ $workflow->description }}
                                </a>
                            @endforeach
                        </div>
                    </nav>
                </div>

                <div class="tab-content" id="nav-tabContent">
                    @foreach ($workflows as $key => $workflow)
                        <div class="tab-pane fade {{ $key == 0 ? 'show active' : null }}" id="nav-{{ str_replace(' ', '', $workflow->description) }}" role="tabpanel" aria-labelledby="nav-info-{{ str_replace(' ', '', $workflow->description) }}">
                            <div class="p-2 border">
                                 <h4>{{ $workflow->description }}</h4>
                                <div class="mt-4 p-2 w-full">
                                    @foreach ($PFEProjects->whereHas('approvement_flow', function($query)use($workflow){
                                        $query->where('id', $workflow->id);
                                    })->with('approvement_flow')->get() as $item)
                                    <div class="">
                                        <h5>{{ $item->project->name }}</h5>
                                    </div>
                                    <div class="pl-4 mb-3 pb-3 border-bottom">
                                        {{-- <div class="">Actividades</div> --}}
                                        <div class="d-flex pl-2 row">
                                            @foreach ($item->project->issues_workflow as $issue)
                                                <div class="row m-2 my-shadow" style="width:32%">
                                                    <div class="border p-2 pl-3 pr-3 rounded w-full" style="width:100%">
                                                        <div class="d-block pb-2">
                                                            <div class="">
                                                                <span class="small text-grey-400">Actividade</span>
                                                            </div>
                                                            <a href="{{ $issue->route }}" style="font-size: 16px; font-weight: 500;">{{ $issue->subject }}</a>
                                                        </div>
                                                        <div class="border-top pb-2 pt-2">
                                                            <div class="d-flex">
                                                                <div class="d-flex flex-grow-1">
                                                                    <div class="bg-slate-400 mr-2 opacity-75 small pl-1 pr-1">
                                                                        N# Indicadores: <b>{{ $issue->indicators->count() }}</b>
                                                                    </div>
                                                                    <div class="bg-danger-300 mr-2 opacity-75 small pl-1 pr-1">
                                                                        Status: Pendente
                                                                    </div>
                                                                </div>

                                                                <div class="">
                                                                    <form action="{{ $issue->route }}" class="d-flex">
                                                                        <button class="bg-success-300 border-0 small pl-2 pr-2 rounded">
                                                                            Aprovar
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            {{-- <form action="/workflow_p2f/initialize" method="post">
                @csrf
                <button type="submit"class="btn bg-success bg-tint-200 btn-sm pl-3 p-2 pr-3 border box-shadow">Inicializar</button>
            </form> --}}
        </div>
    </div>
@endsection
