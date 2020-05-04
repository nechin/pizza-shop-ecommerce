<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
     * The attributes that should be hidden.
     *
     * @var array
     */
    protected $hidden = [
        'viewed'
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

    public function getLikeAttribute()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            return DB::table('favorite_pizzas')
                ->where('pizza_id', $this->id)
                ->where('user_id', $user_id)
                ->exists() ? 1 : 0;
        }

        return 0;
    }
}
