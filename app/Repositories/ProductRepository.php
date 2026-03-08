<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function getTrendingProducts(int $limit = 10)
    {
        $trendingProducts = DB::table('order_items')
            ->join('product_manages', 'order_items.product_id', '=', 'product_manages.id')
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
            ->groupBy('product_manages.id','product_manages.name','product_manages.selling_price',
            'product_manages.discount_percent','product_manages.discounted_price','product_manages.stock','product_manages.image')
            ->orderByDesc('total_ordered')
            ->take($limit)
            ->get();

        return $trendingProducts;
    }
}
