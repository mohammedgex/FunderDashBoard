<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{

    // all rent 
    public function allRentforProperty($id)
    {
        $property = Property::find($id);
        $rents = $property->rents;
        return view('Properties.rents-property', ['rents' => $rents, 'property' => $id]);
    }


    public function add($id)
    {
        return view('Properties.create-rent', ['property_id' => $id]);
    }

    // all rent 
    public function create(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required',
            'monthly_income' => 'required',
            'end_date' => 'required',
        ]);

        $rent = new Rent();
        $rent->property_id = $id;
        $rent->start_date = $request->start_date;
        $rent->monthly_income = $request->monthly_income;
        $rent->end_date = $request->end_date;
        $rent->status = 'active';
        $rent->save();

        return redirect()->route('rent.show', $id);
    }

    // active rent 
    public function active($id)
    {
        $rentactive = Rent::find($id);
        $property = $rentactive->property;
        $rents = Rent::where(['property_id' => $property->id])->get();
        foreach ($rents as $rent) {
            $rent->status = 'not active';
            $rent->save();
        }
        $rentactive->status = 'active';
        $rentactive->save();

        return redirect()->back();
    }

    //not active rent 
    public function notActive($id)
    {
        $rent = Rent::find($id);
        $rent->status = 'not active';
        $rent->save();

        return redirect()->back();
    }
}