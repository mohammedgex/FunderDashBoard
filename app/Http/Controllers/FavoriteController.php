<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // get Favorites by user
    public function getFavoByUser()
    {
        $user = auth()->user();
        foreach ($user->favorites as $favorite) {
            $favorite->property = $favorite->property;
        }

        return response()->json([
            'success' => true,
            'message' => $user->favorites
        ]);
    }

    // create a new Favorite
    public function create($prop_id)
    {
        $property = Property::find(id: $prop_id);
        if (!$property) {
            return response()->json([
                'error' => 'Property not found'
            ], 400);
        }

        $user = auth()->user();

        $favoriteAready = Favorite::where(['user_id' => $user->id, 'property_id' => $property->id])->first();
        if ($favoriteAready) {
            return response()->json([
                'error' => 'favorite aready added'
            ]);
        }

        Favorite::create([
            'property_id' => $prop_id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'favorite added successfully'
        ]);
    }

    // remove Favorite
    public function delete($id)
    {
        $favorite = Favorite::find($id);
        if ($favorite->user_id !== auth()->user()->id) {
            return response()->json([
                'error' => 'You do not have permission to edit'
            ], 400);
        }

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Favorite removed successfully'
        ]);
    }

    // remove Favorites
    public function clearAll()
    {
        $user = auth()->user();
        $user->favorites()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Favorites removed successfully'
        ]);
    }

public function removeFavoriteByPropertyId(Request $request, $propertyId)
{
    // Assuming `user_id` is available via authentication
    $userId = auth()->id();

    // Find the favorite record by user_id and property_id
    $favorite = Favorite::where('user_id', $userId)->where('property_id', $propertyId)->first();

    if ($favorite) {
        $favorite->delete();
        return response()->json(['message' => 'Favorite removed successfully.'], 200);
    }

    return response()->json(['message' => 'Favorite not found.'], 404);
}

}
