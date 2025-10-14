<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    }

    public function reset(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:8|confirmed',
                'token' => 'required'
            ]);

            Log::info('Password reset attempt', [
                'email' => $request->email,
                'token' => $request->token
            ]);

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->password = Hash::make($password);
                    $user->save();
                    Auth::login($user);
                }
            );

            Log::info('Password reset status: ' . $status);

            if ($status === Password::PASSWORD_RESET) {
                return redirect('/login')->with('success', 'Password has been reset successfully!');
            }

            // Handle specific error cases
            if ($status === Password::INVALID_TOKEN) {
                Log::warning('Invalid password reset token', ['email' => $request->email]);
                return back()->withErrors(['token' => 'This password reset token is invalid or has expired.']);
            }

            if ($status === Password::INVALID_USER) {
                Log::warning('Invalid user for password reset', ['email' => $request->email]);
                return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
            }

            Log::error('Password reset failed with unknown status', [
                'status' => $status,
                'email' => $request->email
            ]);

            return back()->withErrors(['email' => 'Unable to reset password. Please try again.']);

        } catch (\Exception $e) {
            Log::error('Password reset exception: ' . $e->getMessage(), [
                'email' => $request->email ?? 'unknown',
                'exception' => $e
            ]);

            return back()->withErrors(['email' => 'An error occurred while resetting your password. Please try again.']);
        }
    }
}
