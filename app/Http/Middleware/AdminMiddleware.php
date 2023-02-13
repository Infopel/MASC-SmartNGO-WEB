<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user =  Auth::user();
        if (Auth::check()) {
            if($user->admin){
                return $next($request);
            }else{
                // return $this->redirectTo();
                abort(401, 'This action is unauthorized.');
            }
        } else {
            return $this->redirectTo();
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return \back();
    }
}
