<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    // get Timelines by property id
    public function getTimelines($id)
    {
        $property = Property::find($id);
        if (!$property) {
            return response()->json([
                'message' => 'property not found',
            ], 400);
        }

        return response()->json([
            'success' => true,
            "timelines" => $property->timelines,
        ]);
    }

    public function index($id)
    {
        return view('Properties.create-timeline', ['id' => $id]);
    }

    // create Timelines 
    public function create(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $property = Property::find($id);

        $timeline = new Timeline();
        $timeline->date = $request->date;
        $timeline->title = $request->title;
        $timeline->description = $request->description;
        $timeline->property_id = $property->id;
        $timeline->save();

        return redirect()->route('property.readMore', $timeline->property_id);
    }

    public function show($id)
    {
        $timeline = Timeline::find($id);
        return view('Properties.edit-timeline', ['timeline' => $timeline]);
    }

    // update Timelines 
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        $timeline = Timeline::find($id);
        if (!$timeline) {
            return response()->json([
                'error' => 'timeline not found',
            ], 400);
        }

        $timeline->date = $request->date;
        $timeline->title = $request->title;
        $timeline->description = $request->description;
        $timeline->save();

        return redirect()->route('property.readMore', $timeline->property->id);
    }

    // delete Timelines 
    public function delete($id)
    {
        $timeline = Timeline::find($id);
        $timeline->delete();
        return redirect()->back();
    }
}
