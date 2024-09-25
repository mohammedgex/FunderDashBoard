<?php

namespace App\Http\Controllers;

use App\Models\Funder;
use App\Models\Property;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\Notifications;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::orderByRaw("status = 'pending' DESC")->get();
        return view('Requests.Sales.sales', ['sales' => $sales]);
    }

    public function accepted($id)
    {
        $sale = Sale::find($id);
        $sale->status = 'accepted';
        $sale->save();
        return redirect()->route('sale.index');
    }
    public function rejected($id)
    {
        $sale = Sale::find($id);
        $sale->status = 'rejected';
        $sale->save();
        return redirect()->route('sale.index');
    }

    //
    public function sales()
    {
        $user = auth()->user();
        return response()->json([
            'sales' => $user->sales,
        ]);
    }

    //
    public function create(Request $request)
    {
        $request->validate([
            'property_id' => 'required',
        ]);

        $user = auth()->user();
        $property = Property::find($request->property_id);

        $old_sale = Sale::where(['property_id' => $request->property_id, 'user_id' => $user->id, 'status' => 'pending'])->first();
        if ($old_sale) {
            return response()->json([
                'errors' => "you have previously sent a sale request and am awaiting the admin's response"
            ], 400);
        }

        if ($user->phone == null) {
            return response()->json([
                'errors' => 'Add the phone number first'
            ], 400);
        }

        $funders = Funder::where(['property_id' => $property->id, 'user_id' => $user->id])->get();
        if ($funders->count() == 0) {
            return response()->json([
                'errors' => 'You do not own any shares in this property'
            ], 400);
        }

        $itemCreatedAt = $funders[0]->updated_at;
        $currentDate = Carbon::now();

        if ($itemCreatedAt->diffInYears($currentDate) >= 1) {
            $sales = new Sale();
            $sales->property_id = $property->id;
            $sales->user_id = $user->id;
            $sales->status = 'pending';
            $sales->save();
        } else {
            return response()->json([
                'errors' => 'The sale does not occur until at least one year has passed since you purchased the property'
            ], 400);
        }
        Notification::send($user, new Notifications('sales request', 'the sale you created has been sent to admin.', '50'));

        return response()->json([
            'success' => true,
        ]);
    }
}
