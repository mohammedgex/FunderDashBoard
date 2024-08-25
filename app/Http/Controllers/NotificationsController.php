<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    //notifications by user
    public function all()
    {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'notifications' => $user->notifications
        ]);
    }
}
