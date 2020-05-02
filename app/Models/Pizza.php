<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pizza extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'image', 'size', 'weight', 'price'
    ];

    /**
     * Get the ingredients for the pizza
     */
    public function ingredients()
    {
        return $this->belongsToMany('App\Models\Ingredient', 'ingredient');
    }

    /**
     * Get the orders for the pizza
     */
    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order');
    }
}
