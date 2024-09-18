<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{

// Login form view
public function showLoginForm()
{
    // If the user is already authenticated, redirect them back to their last visited page or a default page
    if (auth()->check()) {
        return redirect()->intended(route('dashboard')); // You can change 'dashboard' to any route you want
        // return redirect()->intended(url()->previous());

    }

    // If not authenticated, show the login form
    return view('auth.login');
}

 
     // Handle login request
     public function login(Request $request)
     {
         // Validate the request (either email or username)
         $request->validate([
             'login' => 'required|string', // This can be email or username
             'password' => 'required|string',
         ]);
     
         // Determine if the input is an email or username
         $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
     
         // Attempt to log the user in
         if (Auth::attempt([$login_type => $request->input('login'), 'password' => $request->input('password')])) {
             // If successful, redirect to the intended URL or fallback
             return redirect()->intended('/'); // or any fallback route
         }
     
         // If unsuccessful, redirect back to the login form with an error
         return back()->withErrors([
             'login' => 'The provided credentials do not match our records.',
         ]);
     }
     
 

 
     // Handle logout
     public function logout(Request $request)
     {
         Auth::logout();
 
         $request->session()->invalidate();
         $request->session()->regenerateToken();
 
         return redirect('/login');
     }
}
