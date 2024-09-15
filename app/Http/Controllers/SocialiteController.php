<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {
                $token = $finduser->createToken('social');
                return response()->json([
                    'success' => true,
                    'user' => $finduser,
                    'token' => $token->plainTextToken,
                ]);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'image' => $user->avatar,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => Hash::make('my-google'),
                    'email_verified_at' => now(),
                ]);

                $role = new Role();
                $role->role = 'user';
                $newUser->role()->save($role);

                return response()->json([
                    'success' => true,
                    'user' => $newUser,
                    'message' => 'user created successfully'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function handleFacebookCallback(Request $request)
    {
        $token = $request->token;
        try {
            $user = Socialite::driver('facebook')->userFromToken($token);

            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {
                $token = $finduser->createToken('social');
                return response()->json([
                    'success' => true,
                    'user' => $finduser,
                    'token' => $token->plainTextToken,
                ]);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'image' => $user->avatar,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'password' => Hash::make('my-facebook'),
                ]);

                $role = new Role();
                $role->role = 'user';
                $newUser->role()->save($role);

                return response()->json([
                    'success' => true,
                    'user' => $newUser,
                    'message' => 'user created successfully'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
