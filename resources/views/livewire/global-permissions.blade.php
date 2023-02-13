<div class="row m-0 p-2">
        <div class="col-lg-9 col-md-8 admin-container">
            <div class="row h-100 rounded">
                <div class="card-block p-3 rounded">

                    {{-- Actions Notifications --}}
                    @include('errors.any')
                    {{-- /Actions Notifications --}}
                    <div class="w-100">
                        @if (session('isRemoveTrue'))
                            <div class="alert alert-warning">
                                {{ session('isRemoveTrue')['msg'] }}
                                <div>
                                    <h6>{{ __('lang.button_delete').' '.__('lang.label_role') }}: <b>{{ session('isRemoveTrue')['role_name'] }}</b><h6>
                                    <form method="POST" action='{{ route('roles.remove', ['role'=> session('isRemoveTrue')['role_id'] ]) }}'>
                                        @csrf
                                        <input name="role" value="{{ session('isRemoveTrue')['role_id'] }}" type="hidden">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-danger">SIM TENHO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h5>{{ __('lang.label_role_and_global_permissions') }}</h5>
                        </div>
                        <div class="text-lowercase ">
                            <a href="#" onclick="return false;" wire:click="show_modal_create_group_role()" class="text-success border btn btn-sm btn-light rounded-0">
                                <i class="icon-plus2"></i>
                                <span>{{ __('Novo grupo') }}</span>
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
                                    <div class="form-group ml-sm-1 mr-sm-1 mb-2">
                                        <select name="search[ano]" wire:model="filter_by" class="custom-select custom-select-sm rounded-0">
                                            <option value="filter_users" selected>Filtrar usuários</option>
                                            <option value="filter_grupos" selected>Filtrar grupos</option>
                                            <option value="filter_user_by_permissions" selected>Filtrar por permissões</option>
                                        </select>
                                    </div>
                                    <div class="form-group ml-sm-0 mr-sm-0 mb-2">
                                        <select name="search[ano]" wire:model="group_role" class="custom-select custom-select-sm rounded-0">
                                            <option value="null" selected>Grupos de permissões</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->identifier }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="container_data_tabs">
                        <nav id="nav-container-tabs">
                            <div class="nav nav-tabs mb-1" id="nav-tab" role="tablist">
                                <a class="nav-item" id="nav-permission-name">
                                   <span class="text-back-50">Grupo:</span> <span class="text-back fw-600">{{ $selected_group_role['name'] ?? null }}</span>
                                </a>

                                <a class="nav-item nav-link link-option active" id="nav_group_users_roles" data-toggle="tab" href="#nav-users-roles" role="tab" aria-controls="nav-users-roles" aria-selected="true">
                                    Usuários
                                </a>

                                <a class="nav-item nav-link link-option" id="nav-permission" data-toggle="tab" href="#nav-group-permissions" role="tab" aria-controls="nav-group-permissions" aria-selected="false">
                                    Permissões
                                </a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-users-roles" role="tabpanel" aria-labelledby="nav_group_users_roles">
                                <div class="form-inline mb-2 mt-2">
                                    <div class="text-lowercase ">
                                        <a href="#" onclick="return false;" wire:click="show_modal_add_users()" class="text-success border btn btn-sm btn-light rounded-0">
                                            <i class="icon-plus2"></i>
                                            <span>{{ __('adicionar usuário') }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover table-striped" style="font-size: 94%">
                                        <thead class="table-active">
                                            <th>ID</th>
                                            <th>Usuário</th>
                                            <th>Nome</th>
                                            <th class="text-center">Grupo</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @if ($selected_group_role != null)
                                                @forelse ($selected_group_role->users as $user)
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2">{{ $user->id }}</td>
                                                        <td class="p-0 pl-2 pr-2">{{ $user->login }}</td>
                                                        <td class="p-0 pl-2 pr-2">{{ $user->full_name }}</td>
                                                        <td class="p-0 pl-2 pr-2 text-center">
                                                            <a href="#">{{ $selected_group_role['name'] }}</a>
                                                        </td>
                                                        <td class="p-0 pl-2 pr-2 text-right">
                                                            @if (in_array($user->id, $enable_delete_on))
                                                                <span class="ml-3 mr-3">
                                                                    <span class="text-danger">
                                                                        {{ __('lang.text_are_you_sure') }}
                                                                    </span>
                                                                    <button class="btn btn-sm btn-danger ml-1 border-top-success-800 shadow-sm"
                                                                        wire:click="remover_role_member({{ $selected_group_role->id }}, {{ $user->id }}, {{ true }})">Delete</button>

                                                                    <button class="btn btn-sm btn-light border ml-1 shadow-sm" wire:click="cancel_action()">Cancelar</button>
                                                                </span>
                                                            @endif
                                                            <a href="#" onclick="return;"
                                                                wire:click="remover_role_member({{ $selected_group_role->id }},{{ $user->id }}, {{ false }})">
                                                                <i class="icon-trash"></i>
                                                                remover
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="p-0 pl-2 pr-2 text-center" colspan="5">{{ __('lang.label_no_data') }}</td>
                                                    </tr>
                                                @endforelse
                                            @else
                                                <tr>
                                                    <td class="p-0 pl-2 pr-2 text-center" colspan="5">
                                                        Selecione um grupo de permissões para lista os usuários
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade  h-100" id="nav-group-permissions" role="tabpanel" aria-labelledby="nav-group-permissions">
                                <div class="form-inline mb-2 mt-2">
                                    @can('atualizar_permissoes', App\Models\Budgets::class)
                                        <div class="text-lowercase ">
                                            <a href="#" onclick="return false;" wire:click="show_modal_edit_group_role({{ $selected_group_role['id'] ?? null }})" class="text-success border btn btn-sm btn-light rounded-0">
                                                <i class="icon-pencil5"></i>
                                                <span>{{ __('Ediar Permissões') }}</span>
                                            </a>
                                        </div>
                                    @endcan
                                    @can('excluir_permissoes', App\Models\User::class)
                                        @if (in_array($selected_group_role['id'], $enable_delete_grupo_role))
                                            <span class="ml-3 mr-3">
                                                <span class="text-danger">
                                                    {{ __('lang.text_are_you_sure') }}
                                                </span>
                                                <button class="btn btn-sm btn-danger ml-1 border-top-success-800 shadow-sm"
                                                    wire:click="remover_grupo_role({{ $selected_group_role['id'] }}, {{ true }})">Delete</button>

                                                <button class="btn btn-sm btn-light border ml-1 shadow-sm" wire:click="cancel_action()">Cancelar</button>
                                            </span>
                                        @else
                                            <div class="text-lowercase ml-2">
                                                <a href="#" onclick="return false;" wire:click="remover_grupo_role({{ $selected_group_role['id'] }}, {{ false }})" class="text-danger border btn btn-sm btn-light rounded-0">
                                                    <i class="icon-trash"></i>
                                                    <span>{{ __('lang.button_delete') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                                <div class="bg-light p-2 h-100" style="min-height:60vh">
                                    <h4>Permissões</h4>
                                    <div id="permissions_list" class="objects-selection">

                                        @include('roles.global.allowed_permissions')


                                        <label class="floating">
                                            @if ($role_available_permissions == [])
                                                {{ __('lang.label_no_data') }}
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Modal - Adicionar usuarios --}}
            @if ($show_modal_add_users)
                <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header p-2 pl-4 pr-4">
                                <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                                    <span class="text-muted">Adicionar usuário a grupo de permissões:</span> <span class="">Administradores</span>
                                </h5>
                                <button type="button" class="close" wire:click="closeModal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="pl-3 pr-3 pt-2 mb-2">
                                <input type="text" name="username" wire:model="username" class="border form-control form-control-sm" id="q-username" autocomplete="off">
                                <span>Procurando por: {{ $username }}</span>
                            </div>

                            <form wire:submit.prevent="store_users_on_roles" method="POST">
                                <div class="modal-body mt-0 pt-0">
                                    <div class="bg-light border p-2">
                                        <div class="users">
                                            <div class="objects-selection">
                                                @foreach ($users as $user)
                                                    <label class="mb-0">
                                                        <input type="checkbox" name="user_ids[]" wire:model="selected_members_ids" value="{{ $user->id }}"> {{ $user->full_name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer p-1">
                                    <button type="submit">{{ __('lang.button_add') }}</button>
                                    <button type="button" wire:click="closeModal">{{ __('lang.button_cancel') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade in"></div>
                <div class="fade modal-backdrop show"></div>
            @endif
            {{-- Model - Adicionar Grupo de Permissoes --}}
            @if ($show_modal_create_group_role)
                <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">

                            <div class="modal-header p-2 pl-4 pr-4">
                                <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                                    {{ __('Criar novo grupo de permissões') }}</h5>
                                <button type="button" class="close" wire:click="closeModal">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="pl-3 pr-3 pt-2 mb-2">
                                <h5>Nome do grupo</h5>
                                <input type="text" size="50" name="grupo_name" wire:model="group_role_name" class="border form-control form-control-sm w-50" id="grupo_name" autocomplete="off">
                                @error('group_role_name') <small class="invalid-feedback d-inline">{{ $message }}</small> @enderror
                            </div>

                            <form wire:submit.prevent="store_global_role" method="POST">
                                <div class="modal-body mt-0 pt-0">
                                    <div class="bg-light border p-2">
                                        <div class="users">
                                            <div id="permissions_list_modal" class="objects-selection text-wrap">
                                                @include('roles.global.permissions')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer p-1">
                                    <div class="">
                                        <a href="#" onclick="checkAll('permissions', true); return false;">Marcar todos</a> |
                                        <a href="#" onclick="checkAll('permissions', false); return false;" wire:click="uncheckAll('permissions')">Desmarcar todos</a>
                                    </div>
                                    @if ($is_grupo_role_update)
                                        <button type="submit">{{ __('lang.button_update') }}</button>
                                    @else
                                        <button type="submit">{{ __('lang.button_add') }}</button>
                                    @endif
                                    <button type="button" wire:click="closeModal">{{ __('lang.button_cancel') }}</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade in"></div>
                <div class="fade modal-backdrop show"></div>
            @endif

            <div wire:loading id="loading-indicator">
                <i class="icon-spinner spinner"></i>
                <span>Carregando...</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            @include('admin._menu')
        </div>
    </div>
