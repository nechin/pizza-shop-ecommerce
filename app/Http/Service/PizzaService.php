<?php

namespace App\Http\Service;

use App\Models\Pizza;

class PizzaService
{
    private $pizza;

    /**
     * PizzaService constructor.
     * @param $pizza
     */
    public function __construct(Pizza $pizza)
    {
        $this->pizza = $pizza;
    }

    public function incrementViewed()
    {
        $this->pizza->increment('viewed');
    }
}
