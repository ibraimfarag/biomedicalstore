<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        // Get the currently authenticated user ID
        $userId = Auth::id();

        // Find the user by ID using the User model
        $user = User::find($userId);

        if ($user) {
            // Update user details
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            // You can also update other profile details here
            $user->save();

            return back()->with('success', 'Profile updated successfully.');
        }

        return back()->with('error', 'User not found.');
    }
}
