<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->value,
            'type' => $this->type,
            'code' => $this->code,
        ];
    }
}
