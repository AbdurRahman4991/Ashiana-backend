<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequisition extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function manufacturer()
    {
        return $this->belongsTo(ManufacturingManage::class, 'manufacturer_id');
    }
}
