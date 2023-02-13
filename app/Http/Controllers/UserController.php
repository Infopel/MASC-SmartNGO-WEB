<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Members;
use App\Models\Projects;
use App\Models\GroupUsers;
use App\Models\CustomFields;
use App\Models\CustomValues;
use App\Models\EmailAddresses;
use App\Models\UserPreferences;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Events\UserPasswordUpdateEvent;
use App\Notifications\UserNotification;
use App\Http\Controllers\Helpers\CustomFieldsHelper;
use App\Http\Controllers\Register\UsersRegisterController;

class UserController extends Controller
{
    use CustomFieldsHelper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ver_usuarios', User::class)) {
            abort(401);
        }

        $users = User::select('*', 'users.id', 'users.created_on', 'users.updated_on')
            ->with('email')
            ->where('login', '!=', null)
            ->where('firstname', '!=', null)
            ->where('type', 'User')
            ->get();

        $data = array(
            'users' => $users
        );

        // return $data;
        return view('users.index', ['data' => $data]);
    }

    /**
     * Conta do usuario / Perfil
     */

    public function minha_conta()
    {
        $user = Auth::user();
        $this->authorize('view', $user);

        $user->email_address = $user->email_address()->first()->address ?? null;
        $user->groups;
        $user->projects;
        $user->user_preferences;
        $user->custom_fields = $this->map_custom_fields_values($user->custom_values()->get());

        $_custom_fields = CustomFields::select('*')->where('type', 'UserCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label($user->id, $user->custom_values()->get(), $_custom_fields);

        // return $user;
        return view('users.edit_conta', compact('user', 'custom_fields'));
    }

    /**
     * Display New User creation form.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('cadastrar_usuarios', User::class)) {
            abort(401);
        }

        $user = [];
        $_custom_fields = CustomFields::select('*')->where('type', 'UserCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label(null, [], $_custom_fields);

        // return $user;

        return view('users.new', compact('user', 'custom_fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('cadastrar_usuarios', User::class)) {
            abort(401);
        }

        $register = new UsersRegisterController();
        return $register->register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user_details = [];
        foreach ($user->custom_values as $custom_value) {
            $user_details[Str::slug($custom_value->custom_field['name'])]['key'] = $custom_value->custom_field['name'];
            $user_details[Str::slug($custom_value->custom_field['name'])]['values'][] = $custom_value->value;
        }

        foreach ($user_details as $key => $value) {
            $user_details[$key] = array('name' => $value['key'], 'values' => implode(', ', $value['values']));
        }
        $user->user_details = $user_details;
        $user->last_login_on = utf8_encode(ucwords(\Carbon\Carbon::parse($user->last_login_on)->formatLocalized('%d %B %Y')));
        $user->created_on = utf8_encode(ucwords(\Carbon\Carbon::parse($user->created_on)->formatLocalized('%d %B %Y')));


        $user->custom_values->makeHidden(['custom_field', 'custom_field_id', 'customized_id', 'id']);
        // $user->user_details = [];
        foreach ($user->member_of as $member) {
            $member->_created_on = utf8_encode(ucwords(\Carbon\Carbon::parse($member->created_on)->formatLocalized('%d %B %Y')));
            $member->_time = $member->created_on->diffForHumans();
        }
        // return $user;
        return view('users.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (!auth()->user()->can('cadastrar_usuarios', User::class)) {
            abort(401);
        }

        $user->email_address = $user->email_address()->first()->address ?? null;
        $user->groups;
        $user->projects;
        $user->user_preferences;

        $_custom_fields = CustomFields::select('*')->where('type', 'UserCustomField')->get();
        $custom_fields = $this->custom_field_tag_with_label($user->id, $user->custom_values()->get(), $_custom_fields);

        $groups = User::select('id', 'lastname as name')
            // ->leftjoin('groups_users', 'groups_users.group_id', 'id')
            ->where('type', 'Group')
            ->where('status', true)
            ->get();

        $user->user_preferences = Yaml::parse($user->user_preferences()->select('others')->first()['others']);
        $user->hide_mail = $user->user_preferences()->select('hide_mail')->first()->hide_mail;

        $_role = [];
        $_project = [];
        $old_project = null;
        foreach ($user->projects as $project) {
            $roles = Roles::select('name')->where('id', $project->role_id)->first();

            if ($project->project_id == $old_project) {
                $__role = array(
                    $roles->name ?? null
                );
                $_role = \implode(', ', $__role);

                $_project[$project->identifier] = array(
                    'project_id' => $project->project_id,
                    'name' => $project->name,
                    'identifier' => $project->identifier,
                    'role_id' => $project->role_id,
                    'roles' => $_role,
                );
            } else {
                $__role = array($roles->name);
                $_role = \implode(', ', $__role);
                $_project[$project->identifier] = array(
                    'project_id' => $project->project_id,
                    'name' => $project->name,
                    'identifier' => $project->identifier,
                    'role_id' => $project->role_id,
                    'roles' => $_role,
                );
            }
            // $__role = [];
            $old_project = $project->project_id;
        }

        // return $groups;
        $user_groups = $user->user_groups->map(function ($group_id) {
            return $group_id['group_id'];
        });


        return view('users.edit', compact('user', 'groups', 'custom_fields', 'user_groups'));
    }

    /**
     * Map CustomValues
     */

    protected function map_custom_fields_values($custom_values)
    {
        $_custom_field = null;
        $_custom_values = [];
        foreach ($custom_values as $custom_value) {
            if ($custom_value->custom_field !== null) {
                $custom_value->custom_field->custom_value = $custom_value->custom_field->custom_values()->where('customized_id', $custom_value->customized_id)->get();

                $possible_values = str_replace('"', '', $custom_value->custom_field->possible_values);

                $custom_value->custom_field->_possible_values = Yaml::parse($possible_values);
                $custom_value->custom_field->_format_store = Yaml::parse($custom_value->custom_field->format_store);
                $_custom_field[$custom_value->custom_field->id] = $custom_value->custom_field;
            }
        }
        // return null;
        return $_custom_field;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'user.firstname' => ['required', 'string', 'max:30'],
            'user.lastname' => ['required', 'string', 'max:150'],
            'user.email' => ['required', 'email', 'max:255'],
            'user.password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'required' => __('lang.errors.messages.required'),
            'confirmed' => __('lang.errors.messages.confirmation'),
            'max' => __('lang.text_caracters_maximum'),
            'min' => __('lang.text_caracters_minimum'),
        ]);

        // return $request;
        $pass_changed = false;
        try {
            DB::beginTransaction();
            // Primeiro cadasteamos o usario
            $user->firstname = $request['user']['firstname'];
            $user->lastname = $request['user']['lastname'];
            $user->must_change_passwd = $request['user']['must_change_passwd'] ?? 0;
            $user->mail_notification = $request['user']['mail_notification'];
            if ($request->has('user.isAdmin')) {
                $user->admin = (int) $request['user']['isAdmin'];
            }
            $user->updated_on = now();

            if (isset($request['user']['password']) && Auth::user()->admin) {
                if ($request['user']['password'] !== null) {
                    $pass_changed = true;
                    $unhashed_password = $request['user']['password'];
                    $user->password = Hash::make($request['user']['password']);
                }
                if ($request['user']['isGen_password'] == 1) {
                    $pass_changed = true;
                    $unhashed_password = Str::generatePassword();
                    $user->password = Hash::make($unhashed_password);
                }
            }

            $user->update();
            $user->email = $request['user']['email'];
            $user->unhashed_password = $unhashed_password ?? null;

            $email_addresses = EmailAddresses::where('user_id', $user->id)->first();

            if ($email_addresses) {
                $email_addresses->address = $request['user']['email'];
                $email_addresses->updated_on = now();
                $email_addresses->update();
            } else {
                $email_addresses = new EmailAddresses();
                $email_addresses->user_id = $user->id;
                $email_addresses->address = $request['user']['email'];
                $email_addresses->is_default = true;
                $email_addresses->notify = true;
                $email_addresses->updated_on = now();
                $email_addresses->created_on = now();
                $email_addresses->save();
            }

            $this->user_custom_fildes_values($request['custom_field_values'], $user->id);

            // Remover as preferencias e cadastradas
            UserPreferences::where('user_id', $user->id)->delete();
            // Quarto - Cadastramos os dados -> user_preferences
            $user_preferences = new UserPreferences();
            $user_preferences->user_id = $user->id;
            $user_preferences->others = Yaml::dump($request['pref']);
            $user_preferences->hide_mail = $request['user']['hide_mail'];
            $user_preferences->time_zone = '';
            $user_preferences->save(); // Save data into database

            DB::commit();
            // Mandar Email de Actualização de senha

            if ($pass_changed) {
                return $this->password_updated($user);
            }
            return back()->with('success', __('lang.notice_account_updated'));
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', __('Encontramos um erro!. Erro RF002'));
            throw $th;
        }
        // return $request;
    }

    /**
     * Adicional user info and preferences
     */
    protected function user_custom_fildes_values($custom_field_values, $user)
    {
        foreach ($custom_field_values as $field => $value) {
            if (\is_array($value)) {

                CustomValues::where('customized_type', 'Principal')
                    ->where('customized_id', $user)
                    ->where('custom_field_id', $field)
                    ->delete();

                foreach ($value as $user_cv_value) {
                    if ($user_cv_value !== null) {
                        // Performe save query
                        $custom_values = new CustomValues();
                        $custom_values->customized_type = 'Principal';
                        $custom_values->customized_id = $user;
                        $custom_values->custom_field_id = $field;
                        $custom_values->value = $user_cv_value;
                        $custom_values->save(); // Save data into database
                    }
                }
            } else {
                // Performe save query
                $custom_values = CustomValues::where('customized_type', 'Principal')
                    ->where('customized_id', $user)
                    ->where('custom_field_id', $field)
                    ->first();

                if ($custom_values) {
                    $custom_values->value = $value;
                    $custom_values->update(); // Save data into database
                } else {
                    $custom_values = new CustomValues();
                    $custom_values->customized_type = 'Principal';
                    $custom_values->customized_id = $user;
                    $custom_values->custom_field_id = $field;
                    $custom_values->value = $value;
                    $custom_values->save(); // Save data into database
                }
            }
        }
    }


    /**
     * Lock Users
     * @param App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function lookUser(User $user)
    {
        if (!auth()->user()->can('bloquear_desbloquar_usuarios', User::class)) {
            abort(401);
        }

        try {
            $user->status = 3;
            $user->updated_on = now();
            $user->update();
            return back()->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', __('Encontramos um erro!. Erro RF002'));
        }
    }

    /**
     * Unlock Users
     * @param App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function unlockUser(User $user)
    {
        if (!auth()->user()->can('bloquear_desbloquar_usuarios', User::class)) {
            abort(401);
        }

        try {
            $user->status = 1;
            $user->updated_on = now();
            $user->update();
            return back()->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', __('Encontramos um erro!. Erro RF002'));
        }
    }

    /**
     * Unlock Users
     * @param App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function activateUser(User $user)
    {
        if (!auth()->user()->can('bloquear_desbloquar_usuarios', User::class)) {
            abort(401);
        }

        try {
            $user->status = true;
            $user->updated_on = now();
            $user->update();
            return back()->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', __('Encontramos um erro!. Erro RF002'));
        }
    }

    /**
     * Updated UserGroups
     */
    public function updateGroups(Request $request, User $user)
    {
        // return $request;
        // $user_groups = GroupUsers::where('user_id', $user->id)->delete();
        // return back();
        try {
            DB::beginTransaction();
            // Remover users group gravados
            $user_groups = GroupUsers::where('user_id', $user->id)->delete();
            // Cadastrar Groups Users
            foreach ($request->user['group_ids'] as $group) {
                if ($group !== null) {
                    $new_groups = new GroupUsers();
                    $new_groups->group_id = $group;
                    $new_groups->user_id = $user->id;
                    $new_groups->save(); // Save data into database
                }
            }
            DB::commit();
            return back()->with('success', __('lang.notice_successful_update'));
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
            return back()->with('status', __('Ocorreu um erro na actualização de dados.'));
        }
    }


    public function minha_conta_senha()
    {
        $this->authorize('update_auth_pass', auth()->user());

        $user = Auth::user();
        $user->email_address = $user->email_address()->first()->address ?? null;
        // return $user;
        return view('account.password_change', compact('user'));
    }

    public function update_auth_pass(Request $request)
    {
        $user =  Auth::user();

        $this->authorize('update_auth_pass', auth()->user());

        $request->validate([
            'user.old_password' => 'required|password:web',
            'user.password' => 'required|confirmed|min:8',

        ], [
            'required' => __('lang.errors.messages.required'),
            // 'unique' => __('lang.errors.messages.taken'),
            'unique' => __('lang.notice_new_password_must_be_different'),
            'confirmed' => __('lang.errors.messages.confirmation'),
            'min' => __('lang.text_caracters_minimum'),
            'password' => __('lang.notice_account_wrong_password'),
        ], [
            'user.password' => __('lang.field_new_password'),
            'user.old_password' => __('lang.field_password')
        ]);

        // return $request;

        try {
            $user->password = Hash::make($request->user['password']);
            $user->updated_on = now();
            $user->update();
            $user->email_address;
            $user->unhashed_password = $request->user['password'];
            event(new UserPasswordUpdateEvent($user));
            return back()->with('success', __('lang.notice_account_password_updated'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', __('lang.errors.unknown' . ' ' . $th->getMessage()));
        }
    }

    public function admin_update_user_auth_pass(User $user, Request $request)
    {
        // $this->authorize('update', $user);

        if (!auth()->user()->can('alterar_senha_de_usuarios', User::class)) {
            abort(401);
        }

        $request->validate([
            'user.password' => 'required|confirmed|min:8',
        ], [
            'required' => __('lang.errors.messages.required'),
            'unique' => __('lang.notice_new_password_must_be_different'),
            'confirmed' => __('lang.errors.messages.confirmation'),
            'min' => __('lang.text_caracters_minimum'),
            'password' => __('lang.notice_account_wrong_password'),
        ], [
            'user.password' => __('lang.field_new_password'),
        ]);

        try {
            $user->password = Hash::make($request->user['password']);
            $user->updated_on = now();
            $user->update();
            $user->email_address;
            $user->unhashed_password = $request->user['password'];

            // return $user;
            event(new UserPasswordUpdateEvent($user));
            return back()->with('success', __('lang.notice_account_password_updated'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', __('lang.errors.unknown => ' . $th->getMessage()));
        }
    }

    /**
     * Request delete resource confirmation
     */
    public function delete_request(User $user)
    {
        if (!auth()->user()->can('remover_usuarios', User::class)) {
            abort(401);
        }

        return back()->with('isRemoveTrue', [
            'msg' => __('lang.text_are_you_sure'),
            'user_id' => $user->id,
            'user_name' => $user->firstname . ' ' . $user->lastname,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!auth()->user()->can('remover_usuarios', User::class)) {
            abort(401);
        }

        try {
            $user->delete();
            return back()->with('success', __('lang.notice_successful_delete'));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', __('Encontramos um erro!. Erro RF002'));
        }
    }


    /**
     * Password updated
     */
    public function password_updated($user)
    {
        // return $user;
        $email = $user['email'] ?? 'admin@example.com';
        try {
            Mail::to('' . $email . '')->send(new \App\Mail\UserWelcome($user));
            $email_status = true;
        } catch (\Throwable $th) {
            // throw $th;
            $email_error = "Encontramos um erro! RF003. Não foi possível enviar dados para o email (${email}) do Usuário.";
            $email_status = false;
        }
        if ($email_status) {
            return redirect()->route('users.index', ['user' => $user->id])->with('success', __('lang.notice_account_updated'));
        } else {
            return redirect()->route('users.index', ['user' => $user->id])->with('error', $email_error);
        }
    }
}
