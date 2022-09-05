<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\EventBooking;

use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        // Testing: Display the User login details which has the most bookings.
        $user_bookings = EventBooking::select('user_id')->get();
        return view('login', [
            'user' => User::where('id', ($user_bookings->pluck('user_id'))->mode())->get()
        ]);
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
