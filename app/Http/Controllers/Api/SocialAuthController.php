<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Handle the callback from Google after user consent.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect(env('FRONTEND_URL', 'http://localhost:5173') . '/login?error=' . urlencode('Google authentication failed. Please try again.'));
        }

        // Check if user already exists with this google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        // If not, check if user exists with same email
        if (! $user) {
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Link Google account to existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'auth_provider' => 'google',
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // Create a new user with Google data
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'auth_provider' => 'google',
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(Str::random(32)), // Random password since they'll login via Google
                ]);
            }
        }

        // Ensure email_verified_at is set for Google users
        if (is_null($user->email_verified_at)) {
            $user->update(['email_verified_at' => now()]);
        }

        // Generate Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        // Build the redirect URL with URL-encoded token for the frontend
        $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');
        $redirectUrl = "{$frontendUrl}/auth/callback?token=" . urlencode($token);

        return redirect($redirectUrl);
    }
}
