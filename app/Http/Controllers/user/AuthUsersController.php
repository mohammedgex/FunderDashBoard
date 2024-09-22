<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\ResetPasswordVerificationNotification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ichtrojan\Otp\Otp;

class AuthUsersController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    // registeration users
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $old_user_email = User::where("email", $request->email)->first();
        if ($old_user_email) {
            return response()->json([
                'error' => 'The email already exists'
            ], 400);
        }
        $old_user_phone = User::where("phone", $request->phone)->first();
        if ($old_user_phone) {
            return response()->json([
                'error' => 'Phone number already exists'
            ], 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if ($request->has('image')) {
            $filename = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $request->image->move('storage/', $filename);
            $user->image = $filename;
        }
        $user->password = bcrypt($request->password);

        $role = new Role();
        $role->role = 'user';
        $user->save();
        $user->role()->save($role);

        return response()->json([
            "success" => true,
        ]);
    }

    // login user
    public static function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'error' => 'Account not found'
            ], 400);
        }

        if ($user->role->role !== 'user') {
            return response()->json([
                'message' => 'You are not an user.',
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->Json(["error" => 'username or password is incorrect']);
        }

        // if ($user->email_verified_at === null) {
        //     return response()->json([
        //         'error' => 'Please confirm your email.',
        //     ], 400);
        // }

        $token = $user->createToken($user->name);
        return response()->Json(
            [
                "token" => $token->plainTextToken,
                'user' => $user
            ]
        );
    }

    // send code to verification email
    public function sendCodeVerification(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'error' => 'user does not exist',
            ]);
        }

        $user->notify(new EmailVerificationNotification());

        return response()->json([
            'success' => true,
        ]);
    }

    // Code comparison
    public function verificationCode(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required',
        ]);

        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status) {
            return response()->Json(['success' => false, "message" => "Invalid code"], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'message' => 'code is true',
            'success' => true
        ]);
    }

    //forget password
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'error' => 'email not found',
            ], 400);
        }

        $user->notify(new ResetPasswordVerificationNotification());
        return response()->Json(['success' => true], 200);
    }

    public function verificationCodeWithResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'otp' => 'required',
        ]);

        $otp2 = $this->otp->validate($request->email, $request->otp);
        if (!$otp2->status) {
            return response()->Json(['success' => false, "message" => "Invalid code"], 400);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken($user->name);

        return response()->Json(['success' => true, 'token' => $token->plainTextToken], 200);
    }

    // reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update(['password' => Hash::make($request->password)]);

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->Json(['success' => true, "message" => "Success updating password"], 200);
    }

    // reset password with old password
    public function resetPasswordWithOldPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'old_password' => ['required', 'min:8'],
            'new_password' => ['required', 'min:8'],
        ]);

        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->Json(['success' => false, "message" => "Invalid old password"], 400);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        $user->tokens->each(function ($token) {
            $token->delete();
        });

        $token = $user->createToken($user->name);

        return response()->Json(['success' => true, "token" => $token, "message" => "Success updating password"], 200);
    }

    // profile 
    public function profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'image' => 'nullable',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->phone = $request->phone;

        if ($request->has('image')) {
            $filename = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $request->image->move('storage/', $filename);
            $user->image = $filename;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // all users 
    public function users()
    {
        $usersWithUserRole = User::whereHas('role', function ($query) {
            $query->where('role', 'user');
        })->with('role')->get();

        return view('Users.users', ['users' => $usersWithUserRole]);
    }

    // all users 
    public function show($id)
    {
        $user = User::find($id);
        return view('Users.read-more', ['user' => $user]);
    }
    public function image(Request $request, $id)
    {
        $request->validate([
            'image' => 'required'
        ]);

        $user = User::find($id);
        $filename = Str::random(32) . "." . $request->image->getClientOriginalExtension();
        $request->image->move('storage/', $filename);
        $user->image = $filename;
        $user->save();
        return redirect()->route('profile.edit');
    }

    public function getUserData()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Check if a user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated'
            ], 401);
        }

        // Return the user's data
        return response()->json([
            'user' => $user
        ], 200);
    }
}