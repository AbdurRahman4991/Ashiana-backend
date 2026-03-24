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
            'total_ordered' => $this->total_ordered,
            'discount_price' => $this->discounted_price,
            'discount_percent' => $this->discount_percent,
            'generic_name' => optional($this->generic)->name,
            'generic_id'=> $this->generic_id,
            'menufacture_id' => $this->brand_id,
            'category_id'=> $this->category_id,
            'manufacture_name' => optional($this->manufacturing)->name,
        ];
    }
}
