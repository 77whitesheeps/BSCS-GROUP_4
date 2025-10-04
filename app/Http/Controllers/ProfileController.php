<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    #show user profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.userprofile', compact('user'));
    }

    #show user preferences
    public function preferences()
    {
        $user = Auth::user();
        return view('profile.preferences', compact('user'));
    }

    #update preferences
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email_notifications' => 'boolean',
            'theme' => 'string|in:light,dark',
            'default_garden_size' => 'string|in:square_meters,acres',
            'auto_save_calculations' => 'boolean',
            'export_format' => 'string|in:pdf,csv,excel',
        ]);

        $user->update($request->only([
            'email_notifications',
            'theme',
            'default_garden_size',
            'auto_save_calculations',
            'export_format',
        ]));

        return back()->with('success', 'Preferences updated successfully.');
    }

    #update password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        if ($request->current_password === $request->password) {
            return back()->withErrors(['password' => 'New password must be different from the current password.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
