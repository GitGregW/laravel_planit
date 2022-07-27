<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('login');
    }

    public function store(){
        $attributes = request()->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required'
        ]);

        if(auth()->attempt($attributes)){
            session()->regenerate(); // session fixation.
            return redirect('/')->with('success', 'You have logged in.');
        }

        throw ValidationException::withMessages([
            'email' => 'Your provided credentials are incorrect.'
        ]);
    }

    public function destroy(){
        auth()->logout();

        return redirect('/')->with('success', 'You have logged out.');
    }
}
