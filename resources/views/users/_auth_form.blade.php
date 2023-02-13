<div class="col-md-12">
    <fieldset class="mb-3 tabular bg-light border p-3 pt-0">
        <legend class="pl-2 pr-2 p-0 m-0 w-auto">{{ __('lang.label_authentication') }}</legend>
        <div class="mb-3">
            Alteração de senha do usuario.
        </div>

        @if (Route::is('app.minha-conta_senha'))
            <p class="col-md-8">
                <label for="user_last_password" class="float-left">{{ __('lang.field_password') }}<span class="text-danger"> *</span></label>
                <input size="25" type="password" name="user[old_password]" id="user_last_password" class="my_input">
                <em class="info">Indique a senha anterior.</em>
            </p>
        @endif

        <p class="col-md-8">
            <label for="user_password" class="float-left">{{ __('lang.field_new_password') }}<span class="text-danger"> *</span></label>
            <input size="25" type="password" name="user[password]" id="user_password" class="my_input">
            <em class="info">deve ter ao menos 8 caracteres.</em>
        </p>
        <p class="col-md-8">
            <label for="user_password_confirmation" class="float-left">{{ __('lang.field_password_confirmation') }}<span class="text-danger"> *</span></label>
            <input size="25" type="password" name="user[password_confirmation]" id="user_password_confirmation" class="my_input">
        </p>
    </fieldset>
</div>
