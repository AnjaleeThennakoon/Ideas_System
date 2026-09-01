<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class RegisteredUserController extends Controller
{
    public function create(){
        return view('auth.register');
    }

    public function Store( Request $request)
    {
        $request->validate([
            'name'=> ['requires','string','min:3','max:255'],
            'email' => ['required','string','email','max:255'],
            'password' => ['required','string','password','min:3'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        auth()->login($user);
        return redirect('/')->with('success', 'Registration Successful!');
    }
}
