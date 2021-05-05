<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   
    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|confirmed'
        ];

        $this->validate($request, $rules);

        $user = User::whereemail($request->email)->first();
    
        if($user){
            return response()->json(["message" => "Email already taken"], 400);
        }
        
        $user = new User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(["message" => "user successfully registered"], 201);
        //
    }

    
}
