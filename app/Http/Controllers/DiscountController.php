<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function getAvailable()
    {
        $discounts = Discount::all();
        // abort(500, 'We could not retrieve discounts');
        return DiscountResource::collection($discounts);
    }
}
