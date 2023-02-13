<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="">
        <div class="d-flex">
            <div class="flex-grow-1">
                <h6 class="text-black-50">
                    {{ __('lang.label_issue_watchers') }} ({{ sizeof($watchers) }})
                </h6>
            </div>
            <div class="">
                <a href="#" wire:click="showModal" class="link-option">Adicionar</a>
            </div>
        </div>

        {{-- Issues watchers --}}
        <div class="">
            <ul class="list-unstyled">
                @foreach ($watchers as $watcher)
                    <li class="pl-2 pr-2 link-option" wire:transition.slide.down>
                        <a href="{{ route('users.show', ['user' => $watcher['user']['id']]) }}" class="mr-2">
                            {{ $watcher->user->full_name }}
                        </a>
                        @can('delete_issue_watchers', [App\Models\Issues::class, $project])
                            <a href="#" wire:click="removeWatcher({{ $watcher['id'] }})" class="link-option">
                                <i class="icon-trash" style="font-size:95%"></i>
                            </a>
                        @endcan
                    </li>
                @endforeach
            </ul>
        </div>
        {{-- /Issues watchers --}}
    </div>

    @if ($showModal)
        <div class="fade in modal show text-capitalize overflow-auto" wire:transition.slide.down style="display:block">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 pl-4 pr-4">
                        <h5 class="modal-title uppercase" id="exampleModalCenterTitle">{{ __('lang.permission_add_issue_watchers') }}</h5>
                        <button type="button" class="close" wire:click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="pl-3 pr-3 pt-2 mb-2">
                        <input type="text" name="username" wire:model="search_user" class="border form-control form-control-sm" id="search_user" autocomplete="off">
                        <span>Procurando por: {{ $search_user }}</span>
                    </div>
                    <form wire:submit.prevent="add_watchers" method="POST">
                        <div class="modal-body mt-0 pt-0">
                            <div class="bg-light border p-2">
                                <div class="users">
                                    <div class="objects-selection">
                                        @foreach ($users as $user)
                                            <label class="mb-0">
                                                <input type="checkbox" name="user_ids[]" wire:model="selected_users" value="{{ $user->id }}"> {{ $user->full_name }}
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

    <div wire:loading id="loading-indicator">
        <i class="icon-spinner spinner"></i>
        <span>Carregando...</span>
    </div>
</div>
