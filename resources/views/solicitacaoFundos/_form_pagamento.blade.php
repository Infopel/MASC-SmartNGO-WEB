@extends('layouts.main', ['title' => __('New - Solicitação de Fundos')])
@section('content')

<main class="bg-white mt-1">
    <div class="steps-content p-2 flex-grow-1" x-data="app()" x-cloak>

        <form action="{{ route('orcamento.projecto.solicitacao_fundos.validation', [
                'project_identifier' => $project['identifier'],
                'requestNum' => request()->frNum,
                'approvementFlow' => request()->fsfID,
                'isApproveAction' => true,
                ]) }}"
                method="POST">
            @csrf

            <div class="setp-container step-info-content d-flex justify-content-center w-100">
                <div class="col-md-9 p-0 mb-2 mt-2">
                    <div class="mb-2 border-bottom">
                        <h5 class="text-slate-600">
                            Formulário de Processamento de Pagamento de solicitação de fundos
                        </h5>
                    </div>
                    {{-- session rows --}}
                    @include('errors.any')
                    {{-- /session rows --}}
                    <div class="">
                        <div class="small text-uppercase fw-700 text-muted" x-text="`Passos: ${step+1} de 3`"></div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <div x-show.transition.in="step === 0">
                                <div class="fw-700 text-slate-800">Informações Base</div>
                            </div>

                            <div x-show.transition.in="step === 1">
                                <div class="fw-700 text-slate-800">Verificação de Aprovação</div>
                            </div>

                            <div x-show.transition.in="step === 2">
                                <div class="fw-700 text-slate-800">Dados Bancarios</div>
                            </div>
                        </div>
                        <div class="col-md-4 p-0">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" x-bind:style="'width: '+ parseInt(step / 2 * 100) +'%'" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" x-text="parseInt(step / 2 * 100) +'%'"></div>
                            </div>
                        </div>
                    </div>

                    <div x-show.transition.in="step === 0">
                        <div class="mb-3 mt-2 setp-container step-info-content d-flex w-100">
                            <div class="border col-12 p-3 bg-white my-shadow">
                                <div class="p-1 border-bottom mb-3">
                                    <h5>Informações Base</h5>
                                </div>

                                <div class="form-group mb-2">
                                    <label>
                                        Requição:
                                    </label>
                                    <input type="text" value="{{ $flowSolicitacaoFundos->num_requisicao }}" disabled class="my_input">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="mb-0">Doador</label>
                                    <small class="form-text text-muted mt-0 mb-1">Indique o nome do Doador do Orçamento para a realização do objectivo.</small>
                                    <input type="text" class="form-control" name="processarPagamento[doador]">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="mb-0">Pilar</label>
                                    <small class="form-text text-muted mt-0 mb-1"></small>
                                    <input type="text" class="form-control" name="requestFundos[author]" disabled value='{{ $project->parent->name }}'>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="mb-0">Projecto</label>
                                    <small class="form-text text-muted mt-0 mb-1"></small>
                                    <input type="text" class="form-control" name="requestFundos[author]" disabled value='{{ $project->name }}'>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1" class="mb-0">Data</label>
                                    <small class="form-text text-muted mt-0 mb-1">Data de processamento do pagamento</small>
                                    <input type="text" class="my_input" name="processarPagamento[data]" value='{{ now() }}'>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show.transition.in="step === 1">
                        <div class="mb-3 mt-2 setp-container step-info-content d-flex w-100">
                            <div class="border col-12 p-3 bg-white my-shadow">
                                <div class="p-1 border-bottom mb-3">
                                    <h5>Detalhes do Pagamento</h5>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1" class="mb-0">Descrição/Objectivo</label>
                                    <small class="form-text text-muted mt-0 mb-1">Objectivo a realizar com fundo solicitado.</small>
                                    {{-- <textarea name="requestFundos[ocs]" id="" rows="7" class="my_input w-100" >{{ $flowSolicitacaoFundos->solicitacao->objectivo }}</textarea> --}}

                                    <div class="border p-2 bg-light" style="min-height: 120px">
                                        {{ $flowSolicitacaoFundos->solicitacao->objectivo }}
                                    </div>

                                </div>
                                <div class="mb-2">
                                     <label for="exampleInputEmail1" class="mb-0">Tipo de Pagamento</label>
                                     <small class="form-text text-muted mt-0 mb-1">Selecione o tipo de pagamento e preencha os campos necessarios.</small>

                                     <div class="row p-0 m-0">
                                         <div class="custom-control custom-radio mr-3">
                                            <input type="radio" id="check_trans_number" name="processarPagamento[paymentType]" checked class="custom-control-input" value="cheque">
                                            <label class="custom-control-label" for="check_trans_number">Cheque</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-2">
                                            <input type="radio" id="customRadio2" name="processarPagamento[paymentType]" class="custom-control-input" value="transferencia">
                                            <label class="custom-control-label" for="customRadio2">Transferência</label>
                                        </div>
                                     </div>
                                     <input type="text" name="processarPagamento[check_trans_number]" class="form-control mt-2" placeholder="Número do cheque">
                                </div>
                            </div>
                        </div>
                    </div>

                     <div x-show.transition.in="step === 2">
                        <div class="mb-3 mt-2 setp-container step-info-content d-flex w-100">
                            <div class="border col-12 p-3 bg-white my-shadow">
                                 <div class="p-1 border-bottom mb-3">
                                    <h5>Dados Bancarios</h5>
                                </div>

                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1" class="mb-0">Nome do Banco</label>
                                    <small class="form-text text-muted mt-0 mb-1">Indique o nome do banco</small>
                                    <input type="text" class="form-control w-50" name="processarPagamento[nome_banco]">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1" class="mb-0">Número de Conta</label>
                                    <small class="form-text text-muted mt-0 mb-1">Indique o número de conta</small>
                                    <input type="text" class="form-control w-50" name="processarPagamento[num_conta]">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1" class="mb-0">NIB</label>
                                    <small class="form-text text-muted mt-0 mb-1">Indique o NIB da Conta</small>
                                    <input type="text" class="form-control w-50" name="processarPagamento[nib]">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="exampleInputEmail1" class="mb-0">Valor Total</label>
                                    <small class="form-text text-muted mt-0 mb-1">Valor solicitado pelo requerente</small>
                                    <input type="text" class="form-control w-50" name="processarPagamento[valor]" value="{{ number_format(($flowSolicitacaoFundos->solicitacao->valor_estimado), 2) }} MZN" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mt-3 mb-3">
                            <button
                                type="button"
                                class="btn btn-light border rounded-2 fw-600 text-black-50"
                                x-show="step > 0"
                                x-on:click="step--">
                                Anterior
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary border rounded-2 my-shadow fw-600"
                                x-show="step < 2"
                                x-on:click="step++">
                                Proximo Passo
                            </button>
                            <button
                                type="submit"
                                x-show="step === 2"
                                class="btn btn-success border rounded-2 my-shadow fw-600">
                                Submeter
                            </button>
                        </div>
                    </div>

                </div>


            </div>
        </form>
    </div>
</main>

@section('scripts')
    <script>
        function app(){
           return{
                step: 0,
           }
        }
    </script>
@endsection

@endsection
