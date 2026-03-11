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

}
