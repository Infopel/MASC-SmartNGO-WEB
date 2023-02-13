<div class="col-md-6">
    <fieldset class="mb-3 tabular bg-light border-top border-bottom p-3 pt-0">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">Informações</legend>

        <p class="">
            <label for="my_input" class="float-left">Usuário :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('nome') is-invalid @enderror" type="text" name="user[login]"
                placeholder="{{ __('lang.label_user') }}" {{ $user ? 'disabled' : null }} value="{{ $user ? $user->login : '' }}">
            <br>
            @error('nome')
                <span class="required-feedback text-danger-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>
        <p class="">
            <label for="my_input" class="float-left">{{ __('lang.field_firstname') }} :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('nome') is-invalid @enderror" type="text" name="user[firstname]"
                placeholder="{{ __('lang.field_firstname') }}" value="{{ $user ? $user['firstname'] : '' }}">
            <br>
            @error('nome')
                <span class="required-feedback text-danger-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>
        <p class="">
            <label for="my_input" class="float-left">{{ __('lang.field_lastname') }} :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('nome') is-invalid @enderror" type="text" name="user[lastname]"
                placeholder="{{ __('lang.field_lastname') }}" value="{{ $user ? $user['lastname'] : '' }}">
            <br>
            @error('nome')
                <span class="required-feedback text-danger-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>
        <p class="">
            <label for="my_input" class="float-left">{{ __('lang.field_mail') }} :<span class="text-danger"> *</span></label>
            <input size="25" class="my_input @error('nome') is-invalid @enderror " type="text" name="user[email]"
                placeholder="{{ __('lang.field_mail') }}" value="{{ $user ? $user['email_address'] : '' }}">
            <br>
            @error('nome')
                <span class="required-feedback text-danger-600" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </p>

        <hr class="m-2">

        {{-- Campos personalizados --}}
        @include('layouts.custom_fields_inputs', ['custom_fields' => $custom_fields])
        {{-- / Campos personalizados --}}

        @can('update_auth', Auth::user())
            <p>
                <label for="isAdmin" class="">Administrador:<span class="text-danger"> *</span></label>
                <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                    <input name="user[isAdmin]" type="hidden" value="0">
                    <input style="margin:0px !important" type="checkbox" name="user[isAdmin]" id="isAdmin" value="1" {{$user ? $user['admin'] == 1 ? 'checked' : '' : '' }}>
                </label>
            </p>
        @endcan
    </fieldset>

    @can('update_auth', Auth::user())
        @if (Route::is('users.edit') || Route::is('users.new'))
            <fieldset class="mb-3 tabular bg-light border-top border-bottom p-3 pt-0">
                <legend class="pl-2 pr-2 p-0 m-0 w-auto">{{ __('lang.label_authentication') }}</legend>

                <p class="">
                    <label for="my_input">{{ __('lang.field_password') }} :</label>
                    <input size="25" class="my_input @error('nome') is-invalid @enderror" type="text" name="user[password]"
                        placeholder="{{ __('lang.field_password') }}">
                    <br>
                    @error('nome')
                        <span class="required-feedback text-danger-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </p>
                <p class="">
                    <label for="my_input">{{ __('lang.field_password_confirmation') }} :</label>
                    <input size="25" class="my_input @error('nome') is-invalid @enderror" type="text" name="user[password_confirmation]"
                        placeholder="{{ __('lang.field_password_confirmation') }}">
                    <br>
                    @error('nome')
                        <span class="required-feedback text-danger-600" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </p>
                <p>
                    <label for="isGen_password" class="">Gerar senha</label>
                    <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                        <input name="user[isGen_password]" type="hidden" value="0">
                        <input style="margin:0px !important" type="checkbox" name="user[isGen_password]" id="isGen_password" value="1">
                    </label>
                </p>

                <p>
                    <label for="must_change_passwd" class="">
                        É necessário alterar sua senha na próxima vez que tentar acessar sua conta :
                    </label>
                    <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50 float-left" id="">
                        <input name="user[must_change_passwd]" type="hidden" value="0">
                        <input style="margin:0px !important" type="checkbox" name="user[must_change_passwd]" id="must_change_passwd" value="1" {{ $user ? $user['passwd_changed_on'] != null ? 'checked' : '' : '' }}>
                    </label>
                </p>

            </fieldset>
        @endif
    @endcan
</div>
{{--  --}}
<div class="col-md-6 mb-2">
    {{-- field 1 --}}
    <fieldset class="mb-3 bg-light border-top border-bottom p-3 pt-0">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">Notificações por e-mail</legend>

        <div class="">
            <select name="user[mail_notification]" class="my_input p-1 select-searchs">
                <option value="all" {{ $user ? $user['mail_notification'] == 'all' ? 'selected="selected"' : '' : '' }}>
                    {{ __('lang.label_user_mail_option_all') }}
                </option>
                <option value="selected" {{ $user ? $user['mail_notification'] == 'selected' ? 'selected="selected"' : '' : '' }}>
                    {{ __('lang.label_user_mail_option_selected') }}
                </option>
                <option value="only_my_events" {{ $user ? $user['mail_notification'] == 'only_my_events' ? 'selected="selected"' : '' : '' }}>
                    {{ __('lang.label_user_mail_option_only_my_events') }}
                </option>
                <option value="only_assigned" {{ $user ? $user['mail_notification'] == 'only_assigned' ? 'selected="selected"' : '' : '' }}>
                    {{ __('lang.label_user_mail_option_only_assigned') }}
                </option>
                <option value="only_owner" {{ $user ? $user['mail_notification'] == 'only_owner' ? 'selected="selected"' : '' : '' }}>
                    {{ __('lang.label_user_mail_option_only_owner') }}
                </option>
                <option value="none" {{ $user ? $user['mail_notification'] == 'none' ? 'selected="selected"' : '' : '' }}>
                    {{ __('lang.label_user_mail_option_none') }}
                </option>
            </select>
        </div>

        <div class="">
            <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50 float-left" id="">
                <input name="pref[no_self_notified]" type="hidden" value="0">
                <input style="margin:0px !important" type="checkbox" name="pref[no_self_notified]" value="1" {{ $user ?? $user['user_preferences']['no_self_notified'] == '1' ? 'checked' : '' }}>
                 Eu não quero ser notificado de minhas próprias modificações
            </label>
        </div>

    </fieldset>
    {{-- /field 1 --}}

    {{-- field 2 --}}
    <fieldset class="tabular bg-light border-top border-bottom p-3 pt-0">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">Preferências</legend>

        <p>
            <label for="hide_mail" class="">Ocultar meu e-mail:<span class="text-danger"> *</span></label>
            <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                <input style="margin:0px !important" type="checkbox" name="user[hide_mail]" id="hide_mail" value="1" {{ $user ? $user['hide_mail'] == '1' ? 'checked' : '' : '' }}>
                <input name="user[hide_mail]" type="hidden" value="0">
            </label>
        </p>

        {{-- <p>
            <label for="my_input">Fuso-horário</label>
            <select name="pref[time_zone]" id="my_input" class="p-1 select-search">
                <option value="BI" name="tipoDoc">Projecto</option>
                <option value="BI" name="tipoDoc">Actividade</option>
            </select>
        </p> --}}
        <p>
            <label for="my_input">Visualizar comentários</label>
            <select name="pref[comments_sorting]" class="my_input p-1 select-searchs">
                <option value="asc" {{ $user ? $user['user_preferences']['comments_sorting'] == 'asc' ? 'selected="selected"' : '' : ''}}>{{ __('lang.label_chronological_order') }}</option>
                <option value="desc" {{ $user ? $user['user_preferences']['comments_sorting'] == 'desc' ? 'selected="selected"' : '' : '' }}>{{ __('lang.label_reverse_chronological_order') }}</option>
            </select>
        </p>
        {{-- <p> --}}
            {{-- <label for="warn_on_leaving_unsaved" class="float-left">Alertar-me ao sair de uma página sem salvar o texto:<span class="text-danger"> *</span></label> --}}
            <label style="margin:0px !important; width:auto !important;" class="text-left font-weight-normal text-black-50" id="">
                {{-- <input style="margin:0px !important" type="checkbox" name="pref[warn_on_leaving_unsaved]" id="warn_on_leaving_unsaved" value="1" {{ $user ? $user['user_preferences']['warn_on_leaving_unsaved'] == '1' ? 'checked' : '' : ''}}> --}}
            {{-- </label> --}}
        {{-- </p> --}}
    </fieldset>
    {{-- /field 2 --}}
</div>
