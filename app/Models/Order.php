<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    const STATUS_NEW = 0;
    const STATUS_PROGRESS = 1;
    const STATUS_COMPLETE = 2;

    use SoftDeletes;

    public $timestamps = true;

    public $table = 'order';

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
        return $this->hasOne('App\User');
    }

    /**
     * Get the user pizzas from the order
     */
    public function pizzas()
    {
        return $this->belongsToMany('App\Models\Pizza', 'order_pizzas');
    }
}
