<?php

namespace App\Http\Controllers\Api;
/*
use Validator;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    /**
     * User Register
     */
    /*public function register(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'login' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            // return response
            $response = [
                'success' => false,
                'message' => 'Validation Error.', $validator->errors(),
            ];
            return response()->json($response, 404);
        }

        // insert to DB
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $accessToken = $user->createToken('ApplicationName')->accessToken;

        // return response
        $response = [
            'success' => true,
            'message' => 'User registration successful',
            'accessToken' => $accessToken,
        ];
        return response()->json($response, 200);
    }

    /**
     * User Login
     */
   /* public function login(Request $request)
    {
        $data = [
            'login' => $request->login,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;

            return response()->json([
                "message" => "Logged in Success",
                "error" => false,
                "status" => 200,
                'token' => $token,
                "id" => auth()->user()->id,
                "admin" => auth()->user()->admin,
                "name" => auth()->user()->full_name,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}*/

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;


class UserController extends Controller
{


    public $successStatus = 200;


    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
   /* public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }*/

    public function login(Request $request)
    {
        $data = [
            'login' => $request->login,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;

            return response()->json([
                "message" => "Logged in Success",
                "error" => false,
                "status" => 200,
                'token' => $token,
                "id" => auth()->user()->id,
                "admin" => auth()->user()->admin,
                "name" => auth()->user()->full_name,
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }


    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;


        return response()->json(['success'=>$success], $this->successStatus);
    }


    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
