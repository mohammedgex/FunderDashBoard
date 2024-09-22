<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Identification;
use Illuminate\Support\Str;
use App\Models\User;

class IdentificationController extends Controller
{
    // all identification waiting
    public function allIdentification()
    {
        $identifications = Identification::orderByRaw("status = 'Waiting' DESC")->get();
        return view('Requests.Identify.identify', ['identifications' => $identifications]);
    }

    public function show($id)
    {
        $identify = Identification::find($id);
        return view('Requests.Identify.read-more', ['identify' => $identify]);
    }


    // identification user
    public function addIdentification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'front_side' => 'required',
            'back_side' => 'required',
            'type' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'error' => 'Account not found'
            ], 400);
        }

        $Identification_waiting = $user->identification->where('status', 'Waiting')->first();
        $Identification_valid = $user->identification->where('status', 'valid')->first();

        if ($Identification_waiting) {
            return response()->json([
                'error' => 'The identification has already been sent, wait for approval'
            ], 400);
        }
        if ($Identification_valid) {
            return response()->json([
                'error' => 'It has been approved'
            ], 400);
        }


        $identy = new Identification();

        $front_side_name = Str::random(32) . "." . $request->front_side->getClientOriginalExtension();
        $request->front_side->move('uploads/', $front_side_name);
        $identy->front_side = $front_side_name;

        $back_side_name = Str::random(32) . "." . $request->back_side->getClientOriginalExtension();
        $request->back_side->move('uploads/', $back_side_name);
        $identy->back_side = $back_side_name;

        $identy->type = $request->type;
        $identy->status = 'Waiting';

        $user->identification()->save($identy);

        return response()->json([
            'success' => true,
        ]);
    }

    // Identity approval
    public function valid($id)
    {
        $identification = Identification::find($id);
        if (!$identification) {
            return response()->json([
                'error' => 'Identification not found'
            ], 400);
        }

        $identification->status = 'valid';
        $identification->save();

        $user = User::find($identification->user_id);
        $user->identification_verified_at = now();
        $user->save();

        return redirect()->route('identify.show', $id);
    }

    // Identity not valid
    public function notValid($id)
    {
        $identification = Identification::find($id);
        if (!$identification) {
            return response()->json([
                'error' => 'Identification not found'
            ], 400);
        }

        $identification->status = 'not valid';
        $identification->save();

        return redirect()->route('identify.show', $id);
    }

    public function getUserIdentification()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch identification data for the authenticated user
        $identification = Identification::where('user_id', $user->id)->first();

        // If no identification is found, return a 404 response
        if (!$identification) {
            return response()->json([
                'message' => 'Identification not found'
            ], 404);
        }

        // Return the identification data
        return response()->json([
            'identification' => $identification
        ], 200);
    }
}
