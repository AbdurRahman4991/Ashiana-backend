<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\ProductManage;
use App\Models\GenericManage;
use App\Models\ManufacturingManage;
use App\Models\CategoryManage;

class ProductRepository implements ProductRepositoryInterface
{

    public function getTrendingProducts(int $perPage = 10)
    {
        $products = DB::table('order_items')
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
            ->groupBy(
                'product_manages.id',
                'product_manages.name',
                'product_manages.selling_price',
                'product_manages.discount_percent',
                'product_manages.discounted_price',
                'product_manages.stock',
                'product_manages.image'
            )
            ->orderByDesc('total_ordered')
            ->paginate($perPage);

        // Map করে image কে full URL বানানো
        $products->getCollection()->transform(function ($item) {
            $item->image = asset('storage/products/' . $item->image); 
            return $item;
        });

        return $products;
    }

    public function findById($id)
    {
        return ProductManage::with(['category','manufacturing','generic'])->find($id);
    }

    public function filterProducts($categoryIds = [], $companyIds = [])
    {
        $query = ProductManage::query();

        // Category filter
        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        // Company filter
        if (!empty($companyIds)) {
            $query->whereIn('brand_id', $companyIds);
        }

        return $query->latest()->paginate(10);
    }

    public function findBySlug($slug)
    {
        return ProductManage::where('slug', $slug)->first();
    }

    public function getGenerics($genericIds)
    {
        return GenericManage::whereIn('id', $genericIds)->get();
    }

    public function getAlternativeBrands($product, $genericIds)
    {
        return ProductManage::where('id', '!=', $product->id)
            ->where('brand_id', '!=', $product->brand_id)
            ->where(function ($query) use ($genericIds) {
                foreach ($genericIds as $id) {
                    $query->orWhereJsonContains('generic_id', $id);
                }
            })
            ->take(5)
            ->get();
    }

    public function getRecommendedProducts($product)
    {
        return ProductManage::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->orderBy('selling_price', 'desc')
            ->take(5)
            ->get();
    }

    public function getManufacturer($brandId)
    {
        return ManufacturingManage::find($brandId);
    }

    public function getCategory($categoryId)
    {
        return CategoryManage::find($categoryId);
    }
}