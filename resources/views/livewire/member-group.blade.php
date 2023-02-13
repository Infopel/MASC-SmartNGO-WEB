<div>
    <!-- Button trigger modal -->
    <a href="#" wire:click="showModal" class="text-success">
        <i class="icon-plus2"></i>
        <span>{{ __('lang.label_user_new') }}</span>
    </a>

    @if ($showModal)
        <div wire:init="loadComponent" class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header p-2 pl-4 pr-4">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">
                            {{ __('lang.label_user_new') }}</h5>
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
                        <th>Usuário</th>
                        <th class="text-right">-</th>
                    </thead>

                    <tbody>
                        @foreach ($membersGroup as $member)
                            <tr wire:transition.slide.down>
                                <td class="p-0 pr-2 pl-2">
                                    <a href="{{ route('users.show', ['user' => $member['user']['id']]) }}">
                                        {{ $member['user']['firstname'].' '.$member['user']['lastname'] }}
                                    </a>
                                </td>
                                <td class="p-0 pr-2 pl-2 text-right">
                                    <a href="#" wire:click="removeMember({{ $member['group_id']}}, {{ $member['user']['id'] }})">
                                        <i class="icon-trash" style="font-size: 90%"></i>
                                        {{ __('lang.button_delete') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if ($membersGroup == [])
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
