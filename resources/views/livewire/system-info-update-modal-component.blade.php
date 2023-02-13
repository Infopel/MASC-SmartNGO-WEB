<div class="">
    @if ($show_notification)
        {{-- Component de notificacao de novas atulizacoes --}}
        <div class="fade in modal show text-capitalize overflow-auto rounded" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4 bg-slate-700 rounded-0">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            <span class="">
                                Notificação de Atualização
                            </span>
                        </h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-3 bg-light ">
                        <div class="text-center pb-2">
                            <h5>Olá {{ auth()->user()->full_name }}!</h5>
                        </div>
                        <div class="rounded shadow-sm bg-white border-bottom border-danger p-2">
                            <span>
                                O modulo de <i>aprovação e solicitação de fundos</i> <b>foi atualizado</b>. Notamos que esta tarefa não foi inicializada para o processo de aprovação. Desculpe-nos pelos constrangimentos. Para iniciar o processo de solicitação de fundos nessa tarefa por favor click no botão abaixo.
                            </span>
                        </div>

                        <div class="rounded shadow-sm bg-white border border-success p-1 mt-2 small">
                            <span>
                                Caso a solicitação não seja efetuada, essa mensagem vai permanecer por 15 dias.
                            </span>
                        </div>

                        @if ($with_form)
                            <form action="{{ route('orcamento.projecto.solicitacao-fundos.issue_init_request', [
                                'project_identifier' => $issue['project']->identifier,
                                'issue' => $issue['id']
                            ]) }}" method="POST">
                                @csrf
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary shadow-sm">{{ __('lang.button_submit') }}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    <div class="modal-footer p-1">
                        <button type="button" wire:click="closeModal">{{ __('lang.button_close') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade in"  wire:click="closeModal"></div>
        <div class="fade modal-backdrop show"  wire:click="closeModal"></div>
    @endif

</div>
