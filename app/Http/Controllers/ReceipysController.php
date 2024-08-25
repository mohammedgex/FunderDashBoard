<?php

namespace App\Http\Controllers;

use App\Models\Funder;
use App\Models\Property;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReceipysController extends Controller
{
    public function index()
    {
        $receipts = Receipt::orderByRaw("status = 'pending' DESC")->get();
        return view('Requests.Receipts.receipts', ['receipts' => $receipts]);
    }

    public function show($id)
    {
        $receipt = Receipt::find($id);
        return view('Requests.Receipts.read-more', ['receipt' => $receipt]);
    }

    // get receipt by id
    public function receiptById($id)
    {
        $receipt = Receipt::find($id);
        if (!$receipt) {
            return response()->json([
                'error' => 'receipt not found',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'receipts' => $receipt
        ]);
    }

    // create receipts
    public function create(Request $request)
    {
        $request->validate([
            'count_sheres' => 'required',
            'method' => 'required',
            'image' => 'required',
            'receipt_number' => 'required',
            'deposit_date' => 'required',
            'deposited_amount' => 'required',
            'property_id' => 'required',
        ]);

        $user = auth()->user();
        if ($user->phone == null) {
            return response()->json([
                'error' => 'phone number is required',
            ], 400);
        }
        $property = Property::find($request->property_id);
        if (!$property) {
            return response()->json([
                'error' => 'property not found',
            ], 400);
        }

        if ($property->status == 'sold out') {
            return response()->json([
                'error' => 'property sold out',
            ], 400);
        }

        if ($property->funders->count() == $property->funder_count + $property->funder_count * 1 / 5) {
            return response()->json([
                'error' => 'The number of participants in this property has been completed',
            ], 400);
        }

        if ($property->funders->count() + $request->count_sheres > $property->funder_count + $property->funder_count * 1 / 5) {
            return response()->json([
                'error' => 'The purchase could not be completed because the number of available funders is ' . $property->funder_count  + $property->funder_count * 1 / 5 - $property->funders->count(),
            ], 400);
        }

        $count_sheres_of_property = array_sum($property->receipts()->where('status', '!=', 'rejected')->pluck('count_sheres')->toArray());
        if ($count_sheres_of_property == $property->funder_count + $property->funder_count * 1 / 5) {
            return response()->json([
                'error' => 'Number of orders completed'
            ], 400);
        }

        // count sheres user property
        $count_sheres_user_of_property = array_sum(Receipt::where(['user_id' => $user->id, 'property_id' => $property->id])->where('status', '!=', 'rejected')->pluck('count_sheres')->toArray());
        if (($count_sheres_user_of_property + $request->count_sheres) / $property->funder_count > 2 / 5) {
            return response()->json([
                'error' => 'The number of your requests for the property exceeds the permissible limit by 40%.',
            ], 400);
        }

        $receipt = new Receipt();
        $receipt->count_sheres = $request->count_sheres;
        $receipt->method = $request->method;
        $receipt->receipt_number = $request->receipt_number;
        $receipt->deposit_date = $request->deposit_date;
        $receipt->deposited_amount = $request->deposited_amount;
        $receipt->status = 'pending';
        $receipt->user_id = $user->id;
        $receipt->property_id = $property->id;

        if ($request->has('image')) {
            $filename = Str::random(32) . "." . $request->image->getClientOriginalExtension();
            $request->image->move('uploads/', $filename);
            $receipt->image = $filename;
        } else {
            return response()->json([
                'error' => 'image not found',
            ], 400);
        }

        $receipt->save();

        return response()->json([
            'success' => true,
            'receipts' => $user->receipts
        ]);
    }

    // get Receipts By user
    public function getReceiptsByuser()
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'receipts' => $user->receipts
        ]);
    }

    // get receipts by status
    public function receiptByStatus($status)
    {
        $receipts = Receipt::where('status', $status)->get();

        return response()->json([
            'success' => true,
            'receipts' => $receipts
        ]);
    }

    // accept receipt
    public function accepted($id)
    {
        $receipt = Receipt::find($id);
        if (!$receipt) {
            return response()->json([
                'error' => 'receipt not found',
            ], 400);
        }

        $property = $receipt->property;

        if ($property->funders->count() == $property->funder_count + $property->funder_count * 1 / 5) {
            return redirect()->route('receipts.show', $id)->with('error', 'The number of participants in this property has been completed');
        }

        if ($property->funders->count() + $receipt->count_sheres > $property->funder_count + $property->funder_count * 1 / 5) {
            return redirect()->route('receipts.show', $id)->with('error', 'The purchase could not be completed because the number of available funders is ' . $property->funder_count  + $property->funder_count * 1 / 5 - $property->funders->count());
        }

        $fundercount = $property->funders->where('status', 'funder')->count();
        $pendingcount = $property->funders->where('status', 'pending')->count();

        for ($i = 0; $i < $receipt->count_sheres; $i++) {
            if ($fundercount < $property->funder_count) {
                Funder::create([
                    'user_id' => $receipt->user_id,
                    'property_id' => $property->id,
                    'status' => 'funder'
                ]);
            } else if ($pendingcount < intval($property->funder_count * 20 / 100)) {

                Funder::create([
                    'user_id' => $receipt->user_id,
                    'property_id' => $property->id,
                    'status' => 'pending'
                ]);
            }
        }

        $receipt->status = 'accepted';
        $receipt->save();

        return redirect()->route('receipts.show', $id);
    }

    // reject receipt
    public function rejected($id)
    {
        $receipt = Receipt::find($id);
        if (!$receipt) {
            return response()->json([
                'error' => 'receipt not found',
            ], 400);
        }

        $receipt->status = 'rejected';
        $receipt->save();

        return redirect()->route('receipts.show', $id);
    }
}
