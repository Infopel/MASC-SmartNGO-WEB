<div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- Actions Notifications --}}
                    @include('errors.any')
                    {{-- /Actions Notifications --}}

                    <div class="d-flex border-bottom pb-1 mb-1">
                        <div class="flex-grow-1">
                            <h5>{{ __('Fluxo de Aprovação') }}</h5>
                        </div>
                        <div class="text-lowercase form-group ml-sm-1 mr-sm-1 mb-2">
                            <a href="#" onclick="return false;" wire:click="show_new_modal_create_flow()" class="text-success border btn btn-sm btn-light rounded-0">
                                <i class="icon-plus2"></i>
                                <span>{{ __('Novo Fluxo de Aprovacao') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="p-0">
                        <h6 class="fw-600 text-muted mt-1">Filtros</h6>
                        <div class="filtros">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <div class="form-group mb-2 w-50">
                                        <div class="input-group input-group-sm mr-sm-1">
                                            <div class="input-group-prepend bg-white">
                                                <div class="input-group-text bg-white rounded-0 border-right-0">
                                                    <i wire:loading.class="d-none" wire:target="search" class="icon-search4 mr-0 pt-1" style="font-size: 96%"></i>
                                                    <i wire:loading wire:target="search" class="icon-spinner2 spinner mr-0 pt-1" style="font-size: 96%"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="search[issue]" wire:model="search" class="form-control form-control-sm border-left-0 rounded-0" placeholder="Pesquisar">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-inline">
                                    <div class="form-group ml-sm-1 mr-sm-1 mb-2 border-success">
                                        {{-- <label for="">Fluxo de Aprovação</label> --}}
                                        <select name="filter['status']" wire:model="flowType" class="custom-select custom-select-sm rounded-0">
                                            @foreach ($approvementFlows as $key => $flow)
                                                <option value="{{ $flow->tagCode }}">{{ $flow->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group ml-sm-1 mr-sm-1 mb-2">
                                        <select name="filter['status']" wire:model="status" class="custom-select custom-select-sm rounded-0">
                                            <option value="active" selected>Activo</option>
                                            <option value="inactive">Inativo</option>
                                            <option value="deleted">Excluído</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-lowercase ">
                                    <a href="#" onclick="return false;" wire:click="show_modal_create_flow()" class="text-success border btn btn-sm btn-light rounded-0">
                                        <i class="icon-plus2"></i>
                                        <span>{{ __('Adicionar processo') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-2">
                        <table class="table table-sm table-hover table-striped mb-3" style="font-size: 93%">
                            <thead class="table-active">
                                <th>ID</th>
                                <th>Descrição</th>
                                <th class="text-nowrap">Trigger (ID)</th>
                                <th>Papel</th>
                                <th>Activo</th>
                                <th>Conteudo de Eamil</th>
                                {{-- <th>Cadastrado por</th> --}}
                                <th>Cadastrado em</th>
                                <th>
                                    {{ $status == 'deleted' ? 'Deletado em' : 'Atualizado em' }}
                                </th>
                                <th>Ultimo Passo</th>
                                <th>-</th>
                            </thead>
                            <tbody>
                                @forelse ($approvement_flows as $item)
                                    <tr class="{{ $item->deleted_at !== null ? 'text-danger' : null}}">
                                        <td class="p-1 pl-2 pr-2">
                                            {{ $item->id }}
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-nowrap">
                                            {{ $item->description }}
                                        </td>
                                        <td class="p-1 pl-2 pr-2">
                                            <i style="font-size: 95%">
                                                {{ $item->trigger ?? 'NULL' }}
                                            </i>
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-nowrap">
                                            {{ $item->role->name }}
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-center">
                                            @if ($item->is_active)
                                                <i class="icon-checkmark-circle text-success"></i>
                                            @endif
                                        </td>
                                        <td class="p-1 pl-2 pr-2 text-center">
                                            <a href="#" onclick="return false;" wire:click="edit({{ $item->id }}, {{ true }})">
                                                <i class="icon-mail-read text-primary"></i>
                                            </a>
                                        </td>
                                        {{-- <td class="p-0 pl-2 pr-2">
                                            {{ $item->author->full_name }}
                                        </td> --}}

                                        @if (in_array($item->id, $enable_delete_on))
                                            <td class="" colspan="3">
                                                <div class="form-inline">
                                                    <span class="ml-3 mr-3">
                                                        <span class="text-danger">
                                                            {{ __('lang.text_are_you_sure') }}
                                                        </span>
                                                        <button class="btn btn-sm btn-danger ml-1 border-top-success-800 shadow-sm"
                                                            wire:click="delete({{ $item->id }}, {{ true }})">
                                                            Delete
                                                        </button>

                                                        <button class="btn btn-sm btn-light border ml-1 shadow-sm"
                                                            wire:click="cancel_delete_request()">
                                                            Cancelar
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                        @else
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                {{ $item->created_on }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                {{ $item->updated_on }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-center">
                                                @if ($item->is_flow_end)
                                                    <i class="icon-checkmark-circle text-success"></i>
                                                @endif
                                            </td>
                                        @endif

                                        @if($item->deleted_at !== null)
                                            <td></td>
                                        @else
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                <a href="#" onclick="return" wire:click="edit({{ $item->id }})"
                                                    title="Editar"
                                                    class="mr-2">
                                                    <i class="icon-pencil5"></i>
                                                </a>
                                                <a href="#" onclick="return" wire:click="delete({{ $item->id }}, {{ false }})"
                                                    title="Remover"
                                                    class="mr-2 text-danger">
                                                    <i class="icon-trash"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center">
                                            {{ __('lang.label_no_data') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mb-2">
                        <h5>Modelos de decisao</h5>
                        <table class="table table-sm table-hover table-striped mb-3" style="font-size: 93%">
                            <thead class="table-active">
                                <th>ID</th>
                                <th>Titulo</th>
                                <th class="text-nowrap">Associaddo a</th>
                                <th>Validação Positiva (Sim)</th>
                                <th>Validação Negativa (Não)</th>
                                <th>Cadastrado por</th>
                                <th>Cadastrado em</th>
                                <th>-</th>
                            </thead>
                            <tbody>
                                @forelse ($workflow_decision_trees as $workflow_decision)
                                    <tr>
                                        <td>{{ $workflow_decision->id }}</td>
                                        <td class="text-nowrap">{{ $workflow_decision->title }}</td>
                                        <td class="text-nowrap">{{ $workflow_decision->approvement_flow->description }}</td>


                                        @if (in_array($workflow_decision->id, $enable_delete_decision_tree_on))
                                            <td class="" colspan="4">
                                                <div class="form-inline">
                                                    <span class="ml-3 mr-3">
                                                        <span class="text-danger">
                                                            {{ __('lang.text_are_you_sure') }}
                                                        </span>
                                                        <button class="btn btn-sm btn-danger ml-1 border-top-success-800 shadow-sm"
                                                            wire:click="delete_decision_tree({{ $workflow_decision->id }}, {{ true }})">
                                                            Delete
                                                        </button>

                                                        <button class="btn btn-sm btn-light border ml-1 shadow-sm"
                                                            wire:click="cancel_delete_request()">
                                                            Cancelar
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                        @else
                                            <td class="text-nowrap">
                                                {{ $workflow_decision->wf_positive_decision()['description'] ?? null }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                {{ $workflow_decision->wf_negative_decision()['description'] ?? "Fechar processo" }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                {{ $workflow_decision->author->full_name }}
                                            </td>
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                {{ $workflow_decision->created_on }}
                                            </td>
                                        @endif

                                        @if($workflow_decision->deleted_at !== null)
                                            <td></td>
                                        @else
                                            <td class="p-0 pl-2 pr-2 text-nowrap">
                                                <a href="#" onclick="return" wire:click="delete_decision_tree({{ $workflow_decision->id }}, {{ false }})"
                                                    title="Remover"
                                                    class="mr-2 text-danger">
                                                    <i class="icon-trash"></i>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            Esse fluxo não tem nenhum modelo de decisão associado nos seus processos.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            {{-- Modal - Adicionar Novo Intem do Fluxo --}}
            @if ($show_form_modal)
                <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content p-3">

                            <div class="modal-header p-2 pl-4 pr-4">
                                <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                                    <span class="text-muted">
                                        Formulario - Criar novo Fluxo
                                    </span>
                                </h5>
                                <button type="button" class="close" wire:click="closeModal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            @if ($is_edit)
                                <form wire:submit.prevent="update_approvement_flow" method="POST">
                            @else
                                <form wire:submit.prevent="store_approvement_flow" method="POST">
                            @endif
                                    <div class="modal-body mt-3 pt-0">
                                        <div class="bg-light border p-2">
                                            <div class="tabular">
                                                <p>
                                                    <label for="assignable" class="">
                                                        {{ __('Fluxo de Aprovação') }}<span class="text-danger"> *</span>
                                                    </label>
                                                    <select name="" id="" class="my_input p-1" wire:model="type">
                                                        <option value="">Nenhum</option>
                                                        {{-- <option value="Issue" selected>Atividade/Tarefa</option> --}}
                                                        @foreach ($approvementFlows as $key => $flow)
                                                            <option value="{{ $flow->tagCode }}">{{ $flow->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('type')
                                                        <br>
                                                        <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </p>

                                                <p class="">
                                                    <label for="my_input">Descrição da fase:<span class="text-danger"> *</span></label>
                                                    <input size="100" class="my_input" type="text"
                                                        name="flow[description]"
                                                        wire:model="description"
                                                        placeholder="Descrição">
                                                    @error('description')
                                                        <br>
                                                        <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </p>

                                                <p>
                                                    <label class="">
                                                        {{ __('lang.field_active') }}<span class="text-danger"> *</span>
                                                    </label>
                                                    <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                                                        <input name="flow[is_active]" type="checkbox" value="0" wire:model="is_active">
                                                    </label>
                                                </p>

                                                <p>
                                                    <label class="">
                                                        {{ __('Fase') }}<span class="text-danger"> *</span>
                                                    </label>
                                                    <select name="" id="" class="my_input p-1" wire:model="trigger">
                                                        <option value="initial_flow">Inicio do Fluxo</option>
                                                        <option value="processs_flow">Processo</option>
                                                        <option value="output_flow">Ultimo Fase</option>
                                                    </select>
                                                </p>

                                                <p>
                                                    <label class="">
                                                        {{ __('lang.label_role') }}<span class="text-danger"> *</span>
                                                    </label>
                                                    <select name="" id="" class="my_input p-1" wire:model="role_id">
                                                        <option value="">Selecione o Papél</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                        <br>
                                                        <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </p>
                                                <p>
                                                    <label for="assignable" class="">
                                                        {{ __('Usar modelo de decisão') }}<span class="text-danger"> *</span>
                                                    </label>

                                                    <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="use_decision_tree_no"> Não
                                                        <input name="flow[use_decision_tree]" id="use_decision_tree_no" type="radio" value="0" wire:model="use_decision_tree">
                                                    </label>

                                                    <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="use_decision_tree_yes"> SIM
                                                        <input name="flow[use_decision_tree]" id="use_decision_tree_yes" type="radio" value="1" wire:model="use_decision_tree">
                                                    </label>
                                                </p>
                                                @if ($use_decision_tree !== "1")
                                                    <p class="" wire:transition.slide.down>
                                                        <label for="on_approve">Avançar p/ ao aprovar</label>
                                                        <select name="" id="flow_approve_goto" class="my_input p-1" wire:model="flow_approve_goto">
                                                            <option value="terminate_workflow" selected="selected">Terminar Fluxo</option>
                                                            @foreach ($approvement_flows as $flow)
                                                                <option value="flow_{{ $flow->id }}">{{ $flow->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </p>
                                                    <p class="" wire:transition.slide.down>
                                                        <label for="on_approve">Avançar p/ ao reprovar</label>
                                                        <select name="" id="not_approved_goto" class="my_input p-1" wire:model="not_approved_goto">
                                                            <option value="terminate_workflow" selected="selected">Terminar Fluxo</option>
                                                            @foreach ($approvement_flows as $flow)
                                                                <option value="flow_{{ $flow->id }}">{{ $flow->description }}</option>
                                                            @endforeach
                                                        </select>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($use_decision_tree)
                                            <div class="mt-2" wire:transition.slide.down id="decision_tree">
                                                <fieldset class="bg-light border p-2">
                                                    <legend class="p-2 w-auto">Modelos de decisao</legend>
                                                    <div class="tabular bordedr-b">
                                                        <p class="">
                                                            <label for="decision_tree_title">Titulo:<span class="text-danger"> *</span></label>
                                                            <input size="100" class="my_input" type="text" id="decision_tree_title"
                                                                name="flow[decision_tree_title]"
                                                                wire:model="decision_tree_title"
                                                                placeholder="Titulo">
                                                            @error('decision_tree_title')
                                                                <br>
                                                                <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </p>
                                                    </div>
                                                    <div class="tabular bordedr-b">
                                                        <p>
                                                            <label for="">Validação Positiva (Sim)</label>
                                                        </p>
                                                        <p class="">
                                                            <label for="decision_tree_positive_goto">Avançar para:<span class="text-danger"> *</span></label>
                                                            <select name="" id="decision_tree_positive_goto" class="my_input p-1" wire:model="decision_tree_positive_goto">
                                                                <option value="terminate_workflow" selected="selected">Terminar Fluxo</option>
                                                                @foreach ($approvement_flows as $flow)
                                                                    <option value="flow_{{ $flow->id }}">{{ $flow->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </p>
                                                    </div>
                                                    <div class="tabular bordedr-b">
                                                        <p>
                                                            <label class="text-danger" for="">Validação Negativa (Não)</label>
                                                        </p>
                                                        <p class="">
                                                            <label for="decision_tree_negative_goto">Avançar para:<span class="text-danger"> *</span></label>
                                                            <select name="" id="decision_tree_negative_goto" class="my_input p-1" wire:model="decision_tree_negative_goto">
                                                                <option value="terminate_workflow" selected="selected">Terminar Fluxo</option>
                                                                @foreach ($approvement_flows as $flow)
                                                                    <option value="flow_{{ $flow->id }}">{{ $flow->description }}</option>
                                                                @endforeach
                                                            </select>
                                                        </p>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        @endif

                                        <div class="mt-2">
                                            <fieldset class="bg-light border p-2">
                                                <legend class="p-2 w-auto">Notificação por Email</legend>
                                                <div class="tabular bordedr-b">
                                                    <p>
                                                        <label for="email_content" class="float-left">Email: Conteudo de Aprovação</label>
                                                        <textarea name="flow[email_content]" cols="30" rows="6"
                                                            wire:model.lazy="email_notification_content" class="my_input">{{ $email_notification_content }}</textarea>
                                                    </p>
                                                    <p>
                                                        <label for="unapproval_email_content_id" class="float-left">Email: Conteudo de Reprovação</label>
                                                        <textarea name="flow[unapproval_email_content]" cols="30" rows="6"
                                                            wire:model.lazy="unapproval_email_content" class="my_input">{{ $email_notification_content }}</textarea>
                                                    </p>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-1">
                                        @if (!$is_email_conent_view)
                                            @if ($is_edit)
                                                <button type="submit" class="border btn-sm btn-success">{{ __('lang.button_update') }}</button>
                                            @else
                                                <button type="submit" class="border btn-sm btn-success">{{ __('lang.button_add') }}</button>
                                            @endif
                                        @endif
                                        <button type="button" class="border btn-sm btn-light" wire:click="closeModal">{{ __('lang.button_cancel') }}</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade in"></div>
                <div class="fade modal-backdrop show"></div>
            @endif

            {{-- Modal - Adicionar Novo Intem do Fluxo --}}
            @if ($show_form_modal_flow)
                <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content p-3">

                            <div class="modal-header p-2 pl-4 pr-4">
                                <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                                    <span class="text-muted">
                                        Formulario - Criar novo Fluxo de Aprovação
                                    </span>
                                </h5>
                                <button type="button" class="close" wire:click="closeNewModal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            @if ($is_edit)
                                <form wire:submit.prevent="update_type_approvement_flow" method="POST">
                            @else
                                <form wire:submit.prevent="store_type_approvement_flow" method="POST">
                            @endif
                                    <div class="modal-body mt-3 pt-0">
                                        <div class="bg-light border p-2">
                                            <div class="tabular">
                                                <p class="">
                                                    <label for="my_input">Descrição do Fluxo de Aprovação:<span class="text-danger"> *</span></label>
                                                    <input size="100" class="my_input" type="text"
                                                        name="flow[description]"
                                                        wire:model="description"
                                                        placeholder="Descrição">
                                                    @error('description')
                                                        <br>
                                                        <span class="required-feedback text-danger-600 fw-300" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-1">
                                        @if (!$is_email_conent_view)
                                            @if ($is_edit)
                                                <button type="submit" class="border btn-sm btn-success">{{ __('lang.button_update') }}</button>
                                            @else
                                                <button type="submit" class="border btn-sm btn-success">{{ __('lang.button_add') }}</button>
                                            @endif
                                        @endif
                                        <button type="button" class="border btn-sm btn-light" wire:click="closeNewModal">{{ __('lang.button_cancel') }}</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade in"></div>
                <div class="fade modal-backdrop show"></div>
            @endif

            <div wire:loading wire:target="closeNewModal, store_approvement_flow, show_modal_create_flow" id="loading-indicator">
                <i class="icon-spinner spinner"></i>
                <span>Carregando...</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
