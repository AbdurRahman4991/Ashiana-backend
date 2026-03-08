<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;

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
}
