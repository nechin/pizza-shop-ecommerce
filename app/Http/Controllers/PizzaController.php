<?php

namespace App\Http\Controllers;

use App\Http\Resources\PizzaResource;
use App\Models\Pizza;

class PizzaController extends Controller
{
    public function getAvailable()
    {
        $pizzas = Pizza::all();
        return PizzaResource::collection($pizzas);
    }
}
