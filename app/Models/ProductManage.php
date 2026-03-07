<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductManage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function manufacturing()
    {
        return $this->belongsTo(ManufacturingManage::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryManage::class, 'category_id');
    }
}
