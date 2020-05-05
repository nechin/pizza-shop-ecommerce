<?php

namespace App\Http\Controllers;

use App\Http\Resources\PizzaResource;
use App\Http\Service\PizzaService;
use App\Models\Pizza;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PizzaController extends Controller
{
    public function getPizzas(Request $request)
    {
        $query = Pizza::orderBy('viewed', 'desc');
        if ($request->get('vegan')) {
            $query->vegans();
        }
        $pizzas = $query->get();
        return PizzaResource::collection($pizzas);
    }

    public function getMyPizzas()
    {
        if (!Auth::check()) {
            abort(500, 'Authorization error');
        }

        $userId = Auth::user()->id;
        $pizzas = User::find($userId)->favorite_pizzas;
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
