<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(auth()->user()->can('view', $user)){}else{
            return abort(401);
        }
        $user->issues;
        $user->issues_assigned_to_me;
        // return $user;

        return view('account.page', compact('user'));
    }


}
