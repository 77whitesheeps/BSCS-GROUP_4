<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     * With account selection prompt enabled, users will see a list of their Google accounts
     * and can choose which one to use for authentication.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',  // Forces Google account selection screen
                'access_type' => 'offline',    // Allows getting refresh tokens
            ])
            ->redirect();
    }

    /**
     * Handle a callback from the Google OAuth provider.
     * This method processes the user's Google account information
     * and either creates a new user or logs in an existing one.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(uniqid()), // random password
                ]
            );

            Auth::login($user);

            // Redirect to dashboard after successful login
            return redirect()->route('dashboard')->with('success', 'Logged in successfully with Google!');
            
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google authentication failed. Please try again.');
        }
    }
}