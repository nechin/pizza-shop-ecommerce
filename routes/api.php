<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('token')->group(function () {
    Route::post('apply-discount', 'DiscountController@apply');
    Route::post('discounts', 'DiscountController@getAvailable');
    Route::post('pizzas', 'PizzaController@getPizzas');
    Route::post('my-pizzas', 'PizzaController@getMyPizzas');
    Route::post('pizza/{id}', 'PizzaController@getOne');
    Route::post('like/{id}', 'LikeController@like');
    Route::post('create-order', 'OrderController@create');
});
