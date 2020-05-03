<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pizza extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    public $table = 'pizza';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image', 'size', 'weight', 'price', 'vegan'
    ];

    /**
     * Get the ingredients for the pizza
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient', 'pizza_ingredients')->select('name');
    }

    /**
     * Get the orders for the pizza
     */
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_pizzas');
    }

    /**
     * Get the favorite users for the pizza
     */
    public function favorite_users()
    {
        return $this->belongsToMany('App\User', 'favorite_pizzas');
    }
}
