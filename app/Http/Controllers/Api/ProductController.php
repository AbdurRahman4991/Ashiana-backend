<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use App\Models\ProductManage;
use Carbon\Carbon;

class ProductController extends Controller
{
    private $productRepo;

        public function __construct(ProductRepositoryInterface $productRepo)
        {
            $this->productRepo = $productRepo;
        }

        public function trending()
        {
            $products = $this->productRepo->getTrendingProducts(10);

            return response()->json([
                'status' => true,
                'data' => ProductResource::collection($products)
            ]);
        }

        public function newProducts()
        {
            $products = ProductManage::with(['category','manufacturing'])
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->paginate(10);

            return response()->json([
                'status' => true,
                'data' => $products
            ]);
        }

    // public function search(Request $request)
    // {
    //     $search = $request->search;

    //     $products = ProductManage::with(['manufacturing','generic','category'])
    //         ->where('name', 'LIKE', "%$search%")
    //         ->orWhereHas('manufacturing', function ($q) use ($search) {
    //             $q->where('name', 'LIKE', "%$search%");
    //         })

    //         ->orWhereHas('category', function ($q) use ($search) {
    //             $q->where('name', 'LIKE', "%$search%");
    //         })
    //         ->select('id','name','brand_id','category_id','selling_price')
    //         ->limit(20)
    //         ->get();

    //     return response()->json([
    //         'status' => true,
    //         'data' => $products
    //     ]);
    // }
    public function search(Request $request)
{
    $search = $request->search;

    $products = ProductManage::with(['manufacturing','generic','category'])
        ->where('name', 'LIKE', "%$search%")
        ->orWhereHas('manufacturing', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%");
        })
        ->orWhereHas('category', function ($q) use ($search) {
            $q->where('name', 'LIKE', "%$search%");
        })
        ->select(
            'id',
            'name',
            'slug',
            'image',
            'brand_id',
            'category_id',
            'selling_price',
            'discounted_price',
            'discount_percent',
            'stock'
        )
        ->limit(20)
        ->get();

    return response()->json([
        'status' => true,
        'data' => $products
    ]);
}

    

}
