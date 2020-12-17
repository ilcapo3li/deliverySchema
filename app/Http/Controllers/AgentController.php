<?php

namespace App\Http\Controllers;

use App\Agent;
use Illuminate\Http\Request;

class AgentController extends AuthController
{
    
    public function index()
    {
        $agents = User::where('role_id', 1)->where('name', 'like', '%'.Input::get('query').'%')->orwhere('role_id', 1)->where('email', 'like', '%'.Input::get('query').'%')->with(['role', 'photo'])->where('role_id', 4)->orderBy('id', 'desc')->paginate(10);

        return response()->json($agents);
    }

    public function save(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $admin = new User();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = $request->password;
            $admin->role_id = 4;
            $admin->save();

            return response()->json('Admin Created Suceessfully');
        }
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return 'agent';
    }
}
