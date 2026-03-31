<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductManage;

class ManufacturerController extends Controller
{
    public function index($id)
    {
        $manufacturers = ProductManage::with('manufacturing')
         ->where('brand_id', $id)
         ->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $manufacturers
        ]);
    }
}
