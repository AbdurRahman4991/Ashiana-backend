<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductManage;

class CategoryControler extends Controller
{
    public function index($id)
{
    $products = ProductManage::with(['category','manufacturing'])
        ->where('brand_id', $id)
        ->paginate(10);

    return response()->json([
        'status' => true,
        'data' => $products
    ]);
}
}
