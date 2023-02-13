<div class="card-block w-100 p-3 border-left aside-panel">
    @isset ($data['projecto'])
        <div class="d-none">
            <h5 class="text-black-50">
                {{ __('lang.label_issue_plural') }}
            </h5>
            <ul class="list-unstyled">
                <li class="pl-2 pr-2 link-option">
                    <a href="{{ route('projects.issues.tracking', ['project_identifier' => $data['projecto']['identifier'], 'set_filter' => 1]) }}">Todas tarefas</a>
                </li>
                <li class="pl-2 pr-2 link-option">
                    <a href="">Resumo</a>
                </li>
                <li class="pl-2 pr-2 link-option">
                    <a href="">Importar</a>
                </li>
            </ul>
        </div>
        @if(sizeof($data['queries']['userQueries']) > 0)
            {{-- User Queries --}}
            <div class="">
                <h5 class="text-black-50">
                    {{ __('lang.label_my_queries') }}
                </h5>
                <ul class="list-unstyled">
                    @foreach ($data['queries']['userQueries'] as $item)
                        <li class="pl-2 pr-2 link-option">
                            <a href="{{ route('projects.issues.tracking', ['project_identifier' => $data['projecto']['identifier'], 'query_id' => $item->id])}}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- /User Queries --}}

        @if(sizeof($data['queries']['publicQueries']) > 0)
            {{-- Default projects/issues Queries --}}
            <div class="">
                <h5 class="text-black-50">
                    {{ __('lang.label_query_plural') }}
                </h5>
                <ul class="list-unstyled">
                    @foreach ($data['queries']['publicQueries'] as $item)
                        <li class="pl-2 pr-2 link-option">
                            <a href="{{ route('projects.issues.tracking', ['project_identifier' => $data['projecto']['identifier'], 'query_id' => $item->id])}}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            {{-- /Default projects/issues Queries --}}
        @endif
    @else
        <div class="d-none">
            <h5 class="text-black-50">
                {{ __('lang.label_issue_plural') }}
            </h5>
            <ul class="list-unstyled">
                <li class="pl-2 pr-2 link-option">
                    <a href="{{ route('issues.index', ['set_filter' => 1]) }}">Todas tarefas</a>
                </li>
                <li class="pl-2 pr-2 link-option">
                    <a href="">Resumo</a>
                </li>
                <li class="pl-2 pr-2 link-option">
                    <a href="">Importar</a>
                </li>
            </ul>
        </div>
    @endisset

    @isset($data['watchers'])
        @can('view_issue_watchers', [App\Models\Issues::class, $_project['project']])
            @livewire('watchers', $data['watchers'], $issue->project, $data['issue']['id'])
        @endcan
    @endisset

    <div class="">
        <div class="">
            <div class="my_timeline mt-2" style="background: none">
                <div class="">
                    <div class="text-left text-black-50 p-0 m-0 mb-1 small" style="background: none">
                        <h5 class="text-semibold">
                            <i class="icon-history position-left" style="background: #e7eaec; z-index: 1;"></i>
                            FLUXO DE PLANIFICAÇÃO DE ACTIVIDADES
                        </h5>
                    </div>
                </div>
                @foreach ($issue->approvement_workflow_requests ?? [] as $index => $flow_step)
                <div class="">
                    <div class="my_timeline-container left" style="background: none">
                        <div class="my_timeline-icon border-0" style="background: none">
                            <i class="icon-arrow-right13 position-left text-success m-0"></i>
                        </div>
                         <div class="my_timeline-content" style="background: none">
                            <div class="d-flex border-bottom" style="background: none">
                                <h6 class="mb-0">
                                    <span class=fw-600>Fase: </span>
                                    {{ $flow_step->approvement_flow->description }}
                                </h6>
                            </div>
                            <div class="">
                                <div class=" min-l-h text-black-50" style="line-height:1.3">
                                    @if ($flow_step->is_approved)
                                        <div class="mt-2">
                                            <table class="table table-sm borderless border-0 w-auto" style="font-size: 85%">
                                                <tbody>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Aprovado por:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-500 text-capitalize">
                                                            {{ $flow_step->approvedBy->full_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-500">Categoria:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-500">
                                                            {{ $flow_step->role->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-500">Data de Aprovação:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-500 text-muted">
                                                            <i>{{ $flow_step->approved_on }}</i>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-500">Status:</td>
                                                        <td class="p-0 pl-2 pr-2 border-top-0 fw-500 text-success">
                                                            Aprovado
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @elseif(!$flow_step->is_rejected)
                                        @if (sizeOf($issue->approvement_workflow_requests->toArray()) == 1)
                                            @can('can_approve_flow', [App\Models\Issues::class, $issue, $flow_step->approvement_flow->role])
                                                <form action="{{ route('IssueFlowApproveRequest.request', [
                                                    'issue' => $issue->id, 'approvement' => $flow_step->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar">Submeter</button>
                                                
                                                        @if ($flow_step->comments !== null)
                                                            <div class="mb-2">
                                                                <label for="approve_decision_model">
                                                                    Esta actividade foi reprovada devido:
                                                                    {{ $flow_step->comments}}
                                                                    
                                                                </label>
                                                            </div>
                                                        @endif
                                                </form>
                                            @elsecan('edit_issues', [ App\Models\Issues::class, $_project['project']])
                                                <div class="text-center text-warning">
                                                    <small>{{ 'Não tem permissão para fazer essa aprovação! - Apenas Visualização' }}</small>
                                                </div>
                                            @endcan
                                            
                                            
                                        @else
                                            @can('can_approve_flow', [App\Models\Issues::class, $issue, $flow_step->approvement_flow->role]) 
                                                <div class="mt-2">
                                                    @if ($flow_step->approvement_flow->decision_tree !== null)
                                                        <div class="alert alert-warning border-danger-200 mb-2 opacity-50">
                                                            Por favor avaliar o modelo de decisao para aprovação.
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <h6>
                                                                <span class="fw-600">Por favor avalie:</span> {{ $flow_step->approvement_flow->decision_tree->title }}
                                                            </h6>
                                                            
                                                            <div clas="mb-3">
                                                                <table class="table table-sm borderless border-0 w-auto" style="font-size: 85%">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Ao aprovar passa para:</td>
                                                                            <td class="p-0 pl-2 pr-2 border-top-0 fw-500 text-capitalize">
                                                                                {{ $flow_step->approvement_flow->decision_tree->wf_positive_decision()->description ?? "Terminar fluxo"}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="p-0 pl-2 pr-2 border-right border-top-0 fw-600">Ao reprovar para:</td>
                                                                            <td class="p-0 pl-2 pr-2 border-top-0 fw-500 text-capitalize">
                                                                                {{
                                                                                    $flow_step->approvement_flow->decision_tree->wf_negative_decision()['description'] ?? "Terminar fluxo"
                                                                                }}
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="text-left">
                                                        <div class="d-flex">
                                                            @if ($flow_step->approvement_flow->trigger === 'initial_flow')
                                                                <form action="{{ route('IssueFlowApproveRequest.request', [
                                                                    'issue' => $issue->id, 'approvement' => $flow_step->id]) }}" method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar">Submeter</button>
                                                                    
                                                                </form>
                                                            @else
                                                                <form action="{{ route('IssueFlowUnApproveRequest.request', [
                                                                    'issue' => $issue->id, 'approvement' => $flow_step->id
                                                                    ]) }}" method="POST">
                                                                    @csrf
                                                                    @if ($flow_step->approvement_flow->decision_tree !== null)
                                                                        <button type="submit" class="mr-2 btn btn-s pt-1 pb-1 btn-light border">
                                                                            NAO
                                                                        </button>
                                                                    @else
                                                                        <button type="submit" class="mr-2 btn btn-s pt-1 pb-1 btn-light border mr-1">
                                                                            Reprovar
                                                                        </button>
                                                                        <label >Motivo da Reprovação</label>
                                                                        <textarea required name="reprovacao" id="" cols="15" rows="4" class="form-control"></textarea>
                                                                    @endif
                                                                </form>
                                                                <form action="{{ route('IssueFlowApproveRequest.request', [
                                                                        'issue' => $issue->id, 'approvement' => $flow_step->id
                                                                    ]) }}" method="POST">
                                                                    @csrf
                                                                    @if ($flow_step->approvement_flow->decision_tree !== null)
                                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600" value="aprovar">SIM</button>
                                                                    @else
                                                                        <button type="submit" class="btn btn-s pt-1 pb-1 btn-success border border-success shadow-sm fw-600 ml-2" value="aprovar">Aprovar</button>
                                                                    @endif
                                                                    
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                        @else 
                                            <div class="text-center text-warning">
                                                <small>{{ 'Não tem permissão para fazer essa aprovação! - Apenas Visualização' }}</small>
                                            </div>
                                        @endcan
                                                
                                        @endif
                                        
                                        
                                    @endif
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <ul class="list-unstyled">
            <li class="pl-2 pr-2 link-option">

            </li>
        </ul>
    </div>
</div>
