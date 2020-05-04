<?php

namespace App\Http\Controllers;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function getAvailable()
    {
        $discounts = Discount::all();
        return DiscountResource::collection($discounts);
    }
}
