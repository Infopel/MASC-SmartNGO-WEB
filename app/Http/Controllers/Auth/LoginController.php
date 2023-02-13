<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->status) {
            Auth::logout($request);
            return redirect()->back()
                ->withInput(['login' => $user->login])
                ->withErrors([
                   "login" => __('lang.notice_account_locked'),
                ]);
        }
        $this->store_auth_time($user);
    }

    /**
     * Actualizar o hora de login assim que auth o user
     * @return Query $user
     * @param App\Models\User::class
     */
    public function store_auth_time(User $user)
    {
        try {
            $user->last_login_on =  now();
            $user->update();
        } catch (\Throwable $th) {
            // throw $th;
        }
    }

}
