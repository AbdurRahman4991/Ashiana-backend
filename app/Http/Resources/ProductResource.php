<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'selling_price' => $this->selling_price,
            'image' => asset('storage/products/'.$this->image),
            'total_ordered' => $this->total_ordered
        ];
    }
}
