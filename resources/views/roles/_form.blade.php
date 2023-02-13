<div class="col-md-12 mb-3">
    <div class="bg-light p-2 border">
        <div class="tabular col-md-6">
            <p class="">
                <label for="my_input">{{ __('lang.label_role') }} :<span class="text-danger"> *</span></label>
                <input size="25" class="my_input @error('role.name') is-invalid @enderror" type="text" name="role[name]" placeholder="{{ __('lang.label_role') }}" value="{{ $role->name ?? null }}">
                <br>
                @error('role.name')
                    <span class="required-feedback text-danger-600 fw-300" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </p>

            <p>
                <label for="assignable" class="">{{ __('lang.field_assignable') }}<span class="text-danger"> *</span></label>
                <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                    <input name="role[assignable]" type="hidden" value="0">

                    @if ($role->assignable ?? 0)
                        <input style="margin:0px !important" type="checkbox" checked name="role[assignable]" id="assignable" value="1" >
                    @else
                        <input style="margin:0px !important" type="checkbox" name="role[assignable]" id="assignable" value="1" >
                    @endif

                </label>
            </p>

            <p>
                <label for="role_issues_visibility">{{ __('lang.field_issues_visibility') }}</label>
                <select name="role[issues_visibility]" class="my_input p-1 border" id='role_issues_visibility'>
                    <option {{ $role ? $role->issues_visibility == 'all' ? 'selected="selected"' : '' : null}} value="all">Todas as tarefas</option>
                    <option {{ $role ? $role->issues_visibility == 'default' ? 'selected="selected"' : '' : null}} value="default">Todas as tarefas não privadas</option>
                    <option {{ $role ? $role->issues_visibility == 'own' ? 'selected="selected"' : '' : null}} value="own">Tarefas criadas ou atribuídas ao usuário</option>
                    {{-- <option value="asc">{{ __('lang.label_chronological_order') }}</option> --}}
                </select>
            </p>

            <p>
                <label for="role_time_entries_visibility">{{ __('lang.field_time_entries_visibility') }}</label>
                <select name="role[time_entries_visibility]" class="my_input p-1 border" id="role_time_entries_visibility">
                    <option {{ $role ? $role->time_entries_visibility == 'all' ? 'selected="selected"' : '' : null}} value="all">
                        Todas as entradas de tempo
                    </option>
                    <option {{ $role ? $role->time_entries_visibility == 'own' ? 'selected="selected"' : '' : null}} value="own">
                        Entradas de tempo criadas pelo usuário
                    </option>
                </select>
            </p>

            <p>
                <label for="role_users_visibility">{{ __('lang.field_users_visibility') }}</label>
                <select name="role[users_visibility]" class="my_input p-1 border" id="role_users_visibility">
                    <option {{ $role ? $role->users_visibility == 'all' ? 'selected="selected"' : '' : null}} value="all">
                        Todos usuários ativos
                    </option>
                    <option {{ $role ? $role->users_visibility == 'members_of_visible_projects' ? 'selected="selected"' : '' : null}} value="members_of_visible_projects">
                        Membros de projetos visíveis
                    </option>
                </select>
            </p>

            <p>
                <label for="member_management" class="float-left">{{ __('lang.label_member_management') }}</label>
                <label class="block mb-0">
                    @if ($role->all_roles_managed ?? 1)
                        <input type="radio" name="role[all_roles_managed]" id="role_all_roles_managed_on" value="1" data-disables=".role_managed_role input" checked="checked">
                    @else
                        <input type="radio" name="role[all_roles_managed]" id="role_all_roles_managed_on" value="1" data-disables=".role_managed_role input">
                    @endif
                    Todas os papéis
                </label>
                <label class="block mb-0">
                    @if ($role->all_roles_managed ?? 1)
                        <input type="radio" name="role[all_roles_managed]" id="role_all_roles_managed_off" value="0" data-enables=".role_managed_role input">
                    @else
                        <input type="radio" name="role[all_roles_managed]" id="role_all_roles_managed_off" value="0" data-enables=".role_managed_role input" checked="checked">
                    @endif
                        Somente esses papéis:
                </label>

                <input type="hidden" name="role[managed_role_ids]" id="role_managed_role_ids_" value="">
                @foreach ($roles as $key => $_role)
                    <label class="block mb-0 role_managed_role" style="padding-left:2em;">
                        <input type="checkbox" {{ $_role->is_managed ? "Checked='checked'" : null }} name="role[managed_role_ids][]"  value="{{ $_role->id }}">
                        {{ $_role->name }}
                    </label>
                @endforeach
            </p>
        </div>
    </div>
</div>
