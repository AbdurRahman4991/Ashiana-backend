<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\ProductManage;
use App\Models\ManufacturingManage;
use App\Models\CategoryManage;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
        {
            // Sliders
            $sliders = Slider::select('id','image')
            ->get()
            ->map(function ($item){
                return [
                    'id' => $item->id,
                    'image' => asset('storage/sliders/'.$item->image)
                ];
            });


            // Trending Products
            $trendingProducts = DB::table('order_items')
                ->join('product_manages','order_items.product_id','=','product_manages.id')
                ->select(
                    'product_manages.id',
                    'product_manages.name',
                    'product_manages.selling_price',
                    'product_manages.discounted_price',
                    'product_manages.discount_percent',
                    'product_manages.stock',
                    'product_manages.image',
                    DB::raw('SUM(order_items.qty) as total_ordered')
                )
                ->groupBy(
                    'product_manages.id',
                    'product_manages.name',
                    'product_manages.selling_price',
                    'product_manages.discounted_price',
                    'product_manages.discount_percent',
                    'product_manages.stock',
                    'product_manages.image'
                )
                ->orderByDesc('total_ordered')
                ->limit(10)
                ->get()
                ->map(function ($item){
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'selling_price' => $item->selling_price,
                        'discounted_price' => $item->discounted_price,
                        'discount_percent' => $item->discount_percent,
                        'stock' => $item->stock,
                        'image' => asset('storage/products/'.$item->image)
                    ];
                });


            // New Products
            $newProducts = ProductManage::select(
                'id',
                'name',
                'selling_price',
                'discounted_price',
                'discount_percent',
                'stock',
                'image'
            )
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($item){
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'selling_price' => $item->selling_price,
                    'discounted_price' => $item->discounted_price,
                    'discount_percent' => $item->discount_percent,
                    'stock' => $item->stock,
                    'image' => asset('storage/products/'.$item->image)
                ];
            });


            // Manufacturers
            $manufacturers = ManufacturingManage::select('id','logo')
            ->limit(10)
            ->get()
            ->map(function ($item){
                return [
                    'id' => $item->id,
                    'logo' => asset('storage/products/'.$item->logo)
                ];
            });


            // Categories
            $categories = CategoryManage::select('id','image','name')
            ->limit(10)
            ->get()
            ->map(function ($item){
                return [
                    'id' => $item->id,
                    'image' => asset('storage/products/'.$item->image),
                    'name'=> $item->name,
                ];
            });


            return response()->json([
                'status' => true,
                'data' => [
                    'sliders' => $sliders,
                    'trending_products' => $trendingProducts,
                    'new_products' => $newProducts,
                    'manufacturers' => $manufacturers,
                    'categories' => $categories
                ]
            ]);
        }
}
