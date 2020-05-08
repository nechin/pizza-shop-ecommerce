<?php

namespace App\Http\Controllers;

use App\Http\Resources\PizzaResource;
use App\Models\Pizza;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function home()
    {
        $like = false;

        if (Auth::check()) {
            $userId = Auth::user()->id;
            $like = User::find($userId)->favorite_pizzas()->orderBy('viewed', 'desc')->limit(3)->get();
            if (!$like->count()) {
                $like = false;
            }
        }

        $best = Pizza::orderBy('viewed', 'desc')->limit(3)->get();
        $vegan = Pizza::vegans()->orderBy('viewed', 'desc')->limit(3)->get();
        $tomato = Pizza::where('base', 0)
            ->orderBy('viewed', 'desc')->limit(3)->get();
        $cream = Pizza::where('base', 1)
            ->orderBy('viewed', 'desc')->limit(3)->get();

        return response()->json([
            'like' => $like ? PizzaResource::collection($like) : false,
            'best' => PizzaResource::collection($best),
            'vegan' => PizzaResource::collection($vegan),
            'tomato' => PizzaResource::collection($tomato),
            'cream' => PizzaResource::collection($cream),
        ]);
    }
}
