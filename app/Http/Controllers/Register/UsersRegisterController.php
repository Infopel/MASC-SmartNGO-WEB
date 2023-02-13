<?php

namespace App\Http\Controllers\Register;

use App\Models\User;
use App\Models\CustomValues;
use App\Models\EmailAddresses;
use App\Models\UserPreferences;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Register\UserRegister;

Class UsersRegisterController
{
    use UserRegister;

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['user']['isGen_password']){
            return Validator::make($data, [
                'user.login' => ['required', 'string', 'max:255', 'unique:users,login'],
                'user.firstname' => ['required', 'string', 'max:30'],
                'user.lastname' => ['required', 'string', 'max:150'],
                'user.email' => ['required', 'email', 'max:255', 'unique:email_addresses,address'],
            ], [
                'required' => __('lang.errors.messages.required'),
                'max' => __('lang.text_caracters_maximum'),
                'min' => __('lang.text_caracters_minimum'),
            ]);
        }else{
            return Validator::make($data, [
                'user.login' => ['required', 'string', 'max:255', 'unique:users,login'],
                'user.firstname' => ['required', 'string', 'max:30'],
                'user.lastname' => ['required', 'string', 'max:150'],
                'user.email' => ['required', 'email', 'max:255', 'unique:email_addresses,address'],
                'user.password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'required' => __('lang.errors.messages.required'),
                'confirmed' => __('lang.errors.messages.confirmation'),
                'max' => __('lang.text_caracters_maximum'),
                'min' => __('lang.text_caracters_minimum'),
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createUser(array $data)
    {
        // return $data;

        try {
            DB::beginTransaction();

            // Primeiro cadasteamos o usario
            $user = new User();
            $user->login = $data['user']['login'];
            $user->firstname = $data['user']['firstname'];
            $user->lastname = $data['user']['lastname'];
            $user->admin = $data['user']['isAdmin'];
            $user->language = 'pt-Br';
            $user->remember_token = null;
            $user->created_on = now();
            $user->updated_on = now();
            $user->type = 'User';
            $user->must_change_passwd = $data['user']['must_change_passwd'] ?? 0;

            if ($data['user']['isGen_password']) {
                $unhashed_password = Str::generatePassword();
                $user->password = Hash::make($unhashed_password);
            }else{
                $unhashed_password = $data['user']['password'];
                $user->password = Hash::make($data['user']['password']);
            }

            $user->save(); // Save data into database

            $user->email = $data['user']['email'];
            $user->unhashed_password = $unhashed_password;
            // Segundo -> Cadastramos o email do usario
            $email_addresses = new EmailAddresses();
            $email_addresses->user_id = $user->id;
            $email_addresses->address = $data['user']['email'];
            $email_addresses->is_default = true;
            $email_addresses->notify = true;
            $email_addresses->created_on = now();
            $email_addresses->updated_on = now();
            $email_addresses->save(); // Save data into database

            // Terceiro - Cadastramos os dados de todos os camopos personalidados
            $this->user_custom_fildes_values($data['custom_field_values'], $user->id);

            // Quarto - Cadastramos os dados -> user_preferences
            $user_preferences = new UserPreferences();
            $user_preferences->user_id = $user->id;
            $user_preferences->others = Yaml::dump($data['pref']);
            $user_preferences->hide_mail = $data['user']['hide_mail'];
            $user_preferences->time_zone = '';
            $user_preferences->save(); // Save data into database

            DB::commit();

            return $user;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    /**
     * Adicional user info and preferences
     */
    protected function user_custom_fildes_values($custom_field_values, $user)
    {
        foreach ($custom_field_values as $field => $value) {
            if(\is_array($value)){
                foreach($value as $user_cv_value){
                    // Performe save query
                    $custom_values = new CustomValues();
                    $custom_values->customized_type = 'Principal';
                    $custom_values->customized_id = $user;
                    $custom_values->custom_field_id = $field;
                    $custom_values->value = $user_cv_value;
                    $custom_values->save(); // Save data into database
                }
            }else{
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
