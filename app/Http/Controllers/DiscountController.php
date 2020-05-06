<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function getAvailable()
    {
        if (Auth::check()) {
            $discounts = Discount::all();
        } else {
            $discounts = Discount::where('user', 0)->get();
        }
        return DiscountResource::collection($discounts);
    }

    public function apply(Request $request)
    {
        $code = $request->get('code');
        $discount = Discount::where('code', $code)->first();
        return DiscountResource::collection([$discount]);
    }
}
