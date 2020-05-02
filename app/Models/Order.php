<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total', 'state', 'address'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'discount_total'
    ];

    /**
     * Get the user associated with the order
     */
    public function user()
    {
        return $this->hasOne('App\Users');
    }

    /**
     * Get the user pizzas for the order
     */
    public function pizzas()
    {
        return $this->belongsToMany('App\Pizza', 'pizza');
    }
}
