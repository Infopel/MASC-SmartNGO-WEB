<div>
    <!-- Button trigger modal -->
    @can('manage_members', [\App\Models\Projects::class, $project])
        <a href="#" wire:click="showModal" class="text-success">
            <i class="icon-plus2"></i>
            <span>{{ __('lang.label_user_new') }}</span>
        </a>
        @include('errors.any')
    @endcan

    @if ($showModal)
        <div wire:init="loadComponent" class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">{{ __('lang.label_user_new') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="pl-3 pr-3 pt-2 mb-2">
                        <input type="text" name="username" wire:model="username" class="border form-control form-control-sm" id="q-username" autocomplete="off">
                        <span>Procurando por: {{ $username }}</span>
                    </div>

                    <form wire:submit.prevent="addMembers" method="POST">
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
                            <fieldset class="box bg-light p-2 mt-2 text-capitalize border">
                                <legend class="text-capitalize w-auto pt-0 pb-0 pl-2 pr-3 mb-0"><i class="icon-checkmark5 text-success"></i>Papéis</legend>
                                <div class="roles-selection">
                                    @foreach ($roles as $role)
                                        <label class="floating">
                                            <input type="radio" name="membership[role_ids]" wire:model='membership_role_id' value="{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>

                            @if ($error_role_null)
                                <div class="mt-3 ml-0 pt-1 pb-1 pl-3 pr-3 alert alert-danger">
                                    <i class="icon-warning2"></i>
                                    Selecione um Papél
                                </div>
                            @endif
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

    <!-- User Members Table -->
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm border table-striped">
                    <thead class="table-active">
                        <th>Usuário / Grupo</th>
                        <th>Papéis</th>
                        <th>-</th>
                    </thead>
                    <tbody>
                        @forelse ($membersProjects as $member)
                            <tr wire:transition.slide.down>
                                <td class="p-0 pr-2 pl-2">
                                    <a href="{{ route('users.show', ['user' => $member['user']['id']]) }}">
                                        {{ $member['user']['full_name'] }}
                                    </a>
                                </td>
                                <td class="p-0 pr-2 pl-2">
                                    @foreach ($member['project_roles'] as $memberRole)
                                        <span>{{ $memberRole->role->name ?? '' }}</span> |
                                    @endforeach
                                </td>
                                <td class="p-0 pr-2 pl-2">
                                    @can('manage_members', [\App\Models\Projects::class, $project])
                                        <a href="#" wire:click="removeMember({{ $member['id']}}, {{ $member['user']['id'] }})">
                                            <i class="icon-trash" style="font-size: 90%"></i>
                                            {{ __('lang.button_delete') }}
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="p-0 pr-2 pl-2 text-center" colspan="3">
                                    {{ __('lang.label_no_data') }}
                                </td>
                            </tr>
                        @endforelse

                        @if ($membersProjects == [])
                            <tr>
                                <td colspan="3 text-center">
                                    <div class="alert-warning p-1 text-center border">
                                        {{ __('lang.label_no_data') }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / user Members Table -->

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
