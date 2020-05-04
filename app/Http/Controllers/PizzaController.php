<?php

namespace App\Http\Controllers;

use App\Http\Resources\PizzaResource;
use App\Http\Service\PizzaService;
use App\Models\Pizza;

class PizzaController extends Controller
{
    public function getAvailable()
    {
        $pizzas = Pizza::orderBy('viewed', 'desc')->get();
        return PizzaResource::collection($pizzas);
    }

    public function getOne(int $id)
    {
        if (!$id) {
            abort(404, 'We could not found pizza');
        }

        $pizza = Pizza::find($id);
        (new PizzaService($pizza))->incrementViewed();
        return PizzaResource::collection([$pizza]);
    }
}
