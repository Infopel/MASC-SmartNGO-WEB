<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

trait UserRegister
{

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // return "Os dados chegrama aqui com sucesso";
        // return $request;
        $this->validator($request->all())->validate();

        $user = $this->createUser($request->all());

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        // return $user;
        $email = $user['email'] ?? 'admin@example.com';
        try {
            Mail::to(''. $email .'')->send(new \App\Mail\UserWelcome($user));
            $email_status = true;
        } catch (\Throwable $th) {
            //throw $th;
            $email_error = "Encontramos um erro! RF003. Não foi possível enviar dados para o email (${email}) do Usuário.";
            $email_status = false;
        }
        if($email_status){
            return redirect()->route('users.index', ['user' => $user->id])->with('success', __('lang.notice_user_successful_create', ['user' => $user['login']]));
        }else{
            return redirect()->route('users.index', ['user' => $user->id])->with('error', $email_error);
        }
    }
}
