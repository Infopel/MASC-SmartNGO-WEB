@extends('layouts.main', ['title' => __('Solicitação de Fundos')])
@section('content')
    <div class="row m-0 mt-2">
        <div class="col-md-9 m-auto shadow-sm">
            <div class="mt-2 mb-2">
                @include('errors.any')
            </div>
            <div class="p-0">
                <nav>
                  <div class="nav nav-tabs pb-0 mb-1" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link link-option active" id="nav-Solicitacao" data-toggle="tab" href="#nav-ResumoSolicitacao" role="tab" aria-controls="nav-ResumoSolicitacao" aria-selected="true">Resumo da Solicitação</a>

                     <a class="nav-item nav-link link-option" id="nav-Pagamento" data-toggle="tab" href="#nav-ModeloPagamento" role="tab" aria-controls="nav-ModeloPagamento" aria-selected="true">Output. Pedido de Pagamento</a>
                  </div>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12 bg-white p-3" style="min-height: 70vh">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-ResumoSolicitacao" role="tabpanel" aria-labelledby="nav-Solicitacao">
                            <div class="m-auto">
                                @include('solicitacaoFundos.exports.resumo')

                                <div class="md-10 p-0 mt-2 m-auto align-items-end d-flex justify-content-end">
                                    <a href="{{ route('reports_files.projects.export_resumo_solicitacao_fundos', [
                                        'project_identifier' => $data['solicitacao']->project->identifier,
                                        'requestNum' => $data['solicitacao']->num_requisicao,
                                        'requestID' => $data['solicitacao']->id,
                                        'type' => "resumoSolicitacao"
                                    ]) }}" class="btn btn-sm btn-secondary border shadow-sm mt-3">Baixar Arquivo</a>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-ModeloPagamento" role="tabpanel" aria-labelledby="nav-Pagamento">
                            <div class="m-auto">
                                @include('solicitacaoFundos.exports.pagamento')

                                <div class="md-10 p-0 mt-2 m-auto align-items-end d-flex justify-content-end">
                                    <a href="{{ route('reports_files.projects.export_resumo_solicitacao_fundos', [
                                        'project_identifier' => $data['solicitacao']->project->identifier,
                                        'requestNum' => $data['solicitacao']->num_requisicao,
                                        'requestID' => $data['solicitacao']->id,
                                        'type' => "modeloPagamento"
                                    ]) }}" class="btn btn-sm btn-secondary border shadow-sm mt-3">Baixar Arquivo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
