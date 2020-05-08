<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        $pizzas = $this->pizzas;
        foreach ($pizzas as $key => $pizza) {
            $pizzas[$key]['count'] = DB::table('order_pizzas')
                ->where('order_id', $this->id)
                ->where('pizza_id', $pizza->id)
                ->value('count');
        }
        return [
            'id' => $this->id,
            'total' => $this->total,
            'pizzas' => $pizzas,
        ];
    }
}
